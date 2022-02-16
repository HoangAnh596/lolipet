<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.blog.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $category = Blog::select('blogs.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('category_blog_id', function ($row, $order) {
                return $row->orderBy('category_blog_id', $order);
            })
            ->addColumn('category_blog_id', function ($row) {
                return $row->BlogCategory->name;
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('blog.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    <a href="' . route('blog.edit', ['id' => $row->id]) . '" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('blog.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('title', 'LIKE', "%$search%")
                            ->orWhere('slug', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }
    public function addForm()
    {
        $categoryBlog = BlogCategory::all();
        return view('admin.blog.add-form', compact('categoryBlog'));
    }

    public function upload(Request $request)
    {
        $uploadImg = $request->file('file')->store('images', 'public');
        return json_encode(['location' => "/storage/$uploadImg"]);
    }

    public function saveAdd(Request $request, $id = null)
    {
        if ($request->title) {
            $dupicate = Blog::onlyTrashed()
                ->where('title', 'like', $request->title)->first();
        } else {
            $dupicate = null;
        }

        $message = [
            'title.required' => "Hãy nhập vào chủ đề bài viết",
            'title.unique' => "Tên chủ đề bài viết đã tồn tại",
            'title.regex' => "Tên chủ đề không chứa kí tự đặc biệt",
            'title.min' => "Tên chủ đề bài viết ít nhất 3 kí tự",
            'slug.required' => "Viết tiêu đề để tạo slug",
            'category_blog_id.required' => "Hãy chọn danh mục bài viết",
            'status.required' => 'Hãy chọn trạng thái bài viết',
            'status.numeric' => 'Trạng thái bài viết phải là kiểu số',
            'content.required' => 'Hãy nhập nội dung bài viết',
            'image.required' => 'Hãy chọn ảnh bài viết',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'title' => [
                    'required',
                    'min:3',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_]*$/',
                    Rule::unique('blogs')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Blog::onlyTrashed()
                            ->where('title', 'like', '%' . $request->title . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->title) {
                                return $fail('Loại danh mục đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'slug' => 'required',
                'category_blog_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $blogCate = BlogCategory::where('id', $value)->first();
                        if ($blogCate == '') {
                            return $fail('Danh mục bài viết không tồn tại');
                        }
                    },
                ],
                'status' => 'required|numeric',
                'content' => 'required',
                'image' => 'required|mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('blog.index'), 'dupicate' => $dupicate]);
        } else {
            $model = new Blog();

            $model->fill($request->all());
            $model->user_id = Auth::id();
            if ($request->has('image')) {
                $model->image = $request->file('image')->storeAs(
                    'uploads/blog/',
                    uniqid() . '-' . $request->image->getClientOriginalName()
                );
            }

            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('blog.index'), 'message' => 'Thêm bài viết thành công']);
    }

    public function editForm($id)
    {
        $model = Blog::find($id);
        $categoryBlog = BlogCategory::all();

        if (!$model) {
            return redirect()->back();
        }
        return view('admin.blog.edit-form', compact('model', 'categoryBlog'));
    }

    public function saveEdit($id, Request $request)
    {
        $model = Blog::find($id);

        if (!$model) {
            return redirect()->back();
        }

        if ($request->title) {
            $dupicate = Blog::onlyTrashed()
                ->where('title', 'like', $request->title)->first();
        } else {
            $dupicate = null;
        }

        $message = [
            'title.required' => "Hãy nhập vào chủ đề bài viết",
            'title.unique' => "Tên chủ đề bài viết đã tồn tại",
            'title.regex' => "Tên chủ đề không chứa kí tự đặc biệt",
            'title.min' => "Tên chủ đề bài viết ít nhất 3 kí tự",
            'slug.required' => "Viết tiêu đề để tạo slug",
            'category_blog_id.required' => "Hãy chọn danh mục bài viết",
            'status.required' => 'Hãy chọn trạng thái bài viết',
            'status.numeric' => 'Trạng thái bài viết phải là kiểu số',
            'content.required' => 'Hãy nhập nội dung bài viết',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'title' => [
                    'required',
                    'min:3',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_]*$/',
                    Rule::unique('blogs')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Blog::onlyTrashed()
                            ->where('title', 'like', '%' . $request->title . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->title) {
                                return $fail('Loại danh mục đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'slug' => 'required',
                'category_blog_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $blogCate = BlogCategory::where('id', $value)->first();
                        if ($blogCate == '') {
                            return $fail('Danh mục bài viết không tồn tại');
                        }
                    },
                ],
                'status' => 'required|numeric',
                'content' => 'required',
                'image' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('blog.index'), 'dupicate' => $dupicate]);
        } else {
            $model->fill($request->all());

            $model->user_id = Auth::id();
            if ($request->has('image')) {
                $model->image = $request->file('image')->storeAs(
                    'uploads/blog/',
                    uniqid() . '-' . $request->image->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('blog.index'), 'message' => 'Sửa bài viết thành công']);
    }

    public function detail($id)
    {
        $blog = Blog::find($id);

        return view('admin.blog.detail', compact('blog'));
    }

    public function backUp()
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.blog.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $category = Blog::onlyTrashed()->select('blogs.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('category_blog_id', function ($row, $order) {
                return $row->orderBy('category_blog_id', $order);
            })
            ->addColumn('category_blog_id', function ($row) {
                return $row->BlogCategory->name;
            })
            ->addColumn('action', function ($row) {
                return '
            <span class="float-right">
            <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('blog.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('blog.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
            </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('title', 'LIKE', "%$search%")
                            ->orWhere('slug', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $blog = Blog::find($id);
        if (empty($blog)) {
            return response()->json(['success' => 'Bài viết không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        $blog->delete();
        return response()->json(['success' => 'Xóa bài viết thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $blog = Blog::withTrashed()->find($id);
        if (empty($blog)) {
            return response()->json(['success' => 'Bài viết không tồn tại !', "empty" => 'Kiểm tra lại bài viết']);
        }
        $blog->BlogCategory()->restore();
        $blog->restore();
        return response()->json(['success' => 'Khôi phục bài viết thành công !']);
    }

    public function delete($id)
    {
        $blog = Blog::withTrashed()->find($id);
        if (empty($blog)) {
            return response()->json(['success' => 'Bài viết không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        $blog->forceDelete();
        return response()->json(['success' => 'Xóa bài viết thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $blog = Blog::withTrashed()->whereIn('id', $idAll);

        if ($blog->count() == 0) {
            return response()->json(['success' => 'Xóa bài viết thất bại !']);
        }
        $blog->delete();

        return response()->json(['success' => 'Xóa bài viết thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $blog = Blog::withTrashed()->whereIn('id', $idAll);

        if ($blog->count() == 0) {
            return response()->json(['success' => 'Khôi phục bài viết thất bại !']);
        }
        $blog->restore();

        return response()->json(['success' => 'Khôi phục bài viết thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $blog = Blog::withTrashed()->whereIn('id', $idAll);

        if ($blog->count() == 0) {
            return response()->json(['success' => 'Xóa bài viết thất bại !']);
        }

        $blog->forceDelete();

        return response()->json(['success' => 'Xóa bài viết thành công !']);
    }
}