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

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.blogCategory.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $category = BlogCategory::select('blog_categories.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a href="' . route('blogCategory.edit', ['id' => $row->id]) . '" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('blogCategory.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('slug', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        return view('admin.blogCategory.add-form');
    }

    public function saveAdd(Request $request, $id = null)
    {
        $message = [
            'name.required' => "H??y nh???p v??o danh m???c b??i vi???t",
            'name.unique' => "Danh m???c b??i vi???t ???? t???n t???i",
            'name.min' => "Danh m???c b??i vi???t ??t nh???t 3 k?? t???",
            'name.regex' => "Danh m???c b??i vi???t kh??ng ch???a k?? t??? ?????c bi???t",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'min:3',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_]*$/',
                    Rule::unique('blog_categories')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = BlogCategory::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Danh m???c b??i vi???t ???? t???n t???i trong th??ng r??c .
                                 Vui l??ng nh???p th??ng tin m???i ho???c x??a d??? li???u trong th??ng r??c');
                            }
                        }
                    },
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('blogCategory.index')]);
        } else {
            $model = new BlogCategory();
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('blogCategory.index'), 'message' => 'Th??m tu???i th??nh c??ng']);
    }

    public function editForm($id)
    {
        $model = BlogCategory::find($id);

        if (!$model) {
            return redirect()->back();
        }
        return view('admin.blogCategory.edit-form', compact('model'));
    }

    public function saveEdit($id, Request $request)
    {
        $model = BlogCategory::find($id);
        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "H??y nh???p v??o danh m???c b??i vi???t",
            'name.unique' => "Danh m???c b??i vi???t ???? t???n t???i",
            'name.min' => "Danh m???c b??i vi???t ??t nh???t 3 k?? t???",
            'name.regex' => "Danh m???c b??i vi???t kh??ng ch???a k?? t??? ?????c bi???t",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'min:3',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_]*$/',
                    Rule::unique('blog_categories')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = BlogCategory::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Danh m???c b??i vi???t ???? t???n t???i trong th??ng r??c .
                                 Vui l??ng nh???p th??ng tin m???i ho???c x??a d??? li???u trong th??ng r??c');
                            }
                        }
                    },
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('blogCategory.index')]);
        } else {
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('blogCategory.index'), 'message' => 'S???a danh m???c b??i vi???t th??nh c??ng']);
    }

    public function backUp()
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.blogCategory.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $category = BlogCategory::onlyTrashed()->select('blog_categories.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('blogCategory.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('blogCategory.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('slug', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $blogCate = BlogCategory::withTrashed()->find($id);
        if (empty($blogCate)) {
            return response()->json(['success' => 'Danh m???c b??i vi???t kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i b??i vi???t']);
        }

        $blogCate->blogs()->delete();
        $blogCate->delete();
        return response()->json(['success' => 'X??a danh m???c b??i vi???t th??nh c??ng !', 'undo' => "Ho??n t??c th??nh c??ng !"]);
    }

    public function restore($id)
    {
        $blogCate = BlogCategory::withTrashed()->find($id);
        if (empty($blogCate)) {
            return response()->json(['success' => 'Danh m???c b??i vi???t kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i b??i vi???t']);
        }
        $blogCate->blogs()->restore();
        $blogCate->restore();
        return response()->json(['success' => 'Kh??i ph???c danh m???c b??i vi???t th??nh c??ng !', 'undo' => "Ho??n t??c th??nh c??ng !"]);
    }

    public function delete($id)
    {
        $blogCate = BlogCategory::withTrashed()->find($id);
        if (empty($blogCate)) {
            return response()->json(['success' => 'Danh m???c b??i vi???t kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i b??i vi???t']);
        }
        $blogCate->blogs()->forceDelete();
        $blogCate->forceDelete();
        return response()->json(['success' => 'X??a danh m???c b??i vi???t th??nh c??ng !', 'undo' => "Ho??n t??c th??nh c??ng !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $blogCate = BlogCategory::withTrashed()->whereIn('id', $idAll);

        if ($blogCate->count() == 0) {
            return response()->json(['success' => 'X??a danh m???c b??i vi???t th???t b???i !']);
        }

        $blogCate->each(function ($blog) {
            $blog->blogs()->delete();
        });
        $blogCate->delete();
        return response()->json(['success' => 'X??a danh m???c b??i vi???t th??nh c??ng !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $blogCate = BlogCategory::withTrashed()->whereIn('id', $idAll);

        if ($blogCate->count() == 0) {
            return response()->json(['success' => 'Kh??i ph???c danh m???c b??i vi???t th???t b???i !']);
        }

        $blogCate->each(function ($blog) {
            $blog->blogs()->restore();
        });
        $blogCate->restore();
        return response()->json(['success' => 'Kh??i ph???c danh m???c b??i vi???t th??nh c??ng !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $blogCate = BlogCategory::withTrashed()->whereIn('id', $idAll);

        if ($blogCate->count() == 0) {
            return response()->json(['success' => 'X??a danh m???c b??i vi???t th???t b???i !']);
        }

        $blogCate->each(function ($blog) {
            $blog->blogs()->forceDelete();
        });
        $blogCate->forceDelete();
        return response()->json(['success' => 'X??a danh m???c b??i vi???t th??nh c??ng !']);
    }
}