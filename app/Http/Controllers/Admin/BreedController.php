<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Breed;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class BreedController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.breed.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $breed = Breed::select('breeds.*')->with('category');
        return dataTables::of($breed)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('cate_id', function ($row, $order) {
                return $row->orderBy('category_id', $order);
            })
            ->orderColumn('status', function ($row, $order) {
                return $row->orderBy('status', $order);
            })
            ->addColumn('category_id', function ($row) {
                return $row->category->name;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-primary">Active</span>';
                } elseif ($row->status == 0) {
                    return '<span class="badge badge-danger">Deactive</span>';
                } else {
                    return '<span class="badge badge-danger">Sắp ra mắt</span>';
                }
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="' . route('breed.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('breed.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        $category = Category::all();
        return view('admin.breed.add-form', compact('category'));
    }

    public function saveAdd(Request $request, $id = null)
    {

        $message = [
            'name.required' => "Hãy nhập vào tên giống loài",
            'name.unique' => "Tên giống loài đã tồn tại",
            'name.regex' => "Tên giống loài không chứa kí tự đặc biệt và số",
            'name.min' => "Tên giống loài ít nhất 3 kí tự",
            'slug.required' => 'Nhập tên giống loài để tạo slug',
            'category_id.required' => "Hãy chọn danh mục",
            'status.required' => "Hãy chọn trạng thái giống loài",
            'status.numeric' => "Trạng thái giống loài phải là kiểu số",
            'uploadfile.required' => 'Hãy chọn ảnh giống loài',
            'uploadfile.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('breeds')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Breed::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Tên giống loài đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'category_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $categoryId = Category::where(function ($query) use ($request) {
                            $query->where('category_type_id', 1)
                                ->where('id', $request->category_id);
                        })->first();
                        if ($categoryId == '') {
                            return $fail('Danh mục thú cưng không tồn tại');
                        }
                    },
                ],
                'slug' => 'required',
                'status' => 'required|numeric',
                'uploadfile' => 'required|mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('breed.index')]);
        } else {
            $model = new Breed();
            $auth = Auth::user();
            $model->fill($request->all());
            $model->user_id =  $auth->id;
            if ($request->has('uploadfile')) {
                $model->image = $request->file('uploadfile')->storeAs(
                    'uploads/breeds/',
                    uniqid() . '-' . $request->uploadfile->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('breed.index'), 'message' => 'Thêm giống loài thành công']);
    }

    public function editForm($id)
    {
        $model = Breed::find($id);
        if (!$model) {
            return redirect()->back();
        }
        $category = Category::all();
        return view('admin.breed.edit-form', compact('model', 'category'));
    }

    public function saveEdit($id, Request $request)
    {

        $model = Breed::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "Hãy nhập vào tên giống loài",
            'name.unique' => "Tên giống loài đã tồn tại",
            'name.regex' => "Tên giống loài không chứa kí tự đặc biệt và số",
            'name.min' => "Tên giống loài ít nhất 3 kí tự",
            'slug.required' => "Nhập tên giống loài để tạo slug",
            'category_id.required' => "Hãy chọn danh mục",
            'status.required' => "Hãy chọn trạng thái giống loài",
            'status.numeric' => "Trạng thái giống loài phải là kiểu số",
            'uploadfile.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ảnh không được quá 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('breeds')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Breed::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Tên giống loài đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'category_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $categoryId = Category::where(function ($query) use ($request) {
                            $query->where('category_type_id', 1)
                                ->where('id', $request->category_id);
                        })->first();
                        if ($categoryId == '') {
                            return $fail('Danh mục thú cưng không tồn tại');
                        }
                    },
                ],
                'slug' => 'required',
                'status' => 'required|numeric',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('breed.index')]);
        } else {
            $model->user_id =  Auth::id();
            $model->fill($request->all());

            if ($request->has('image')) {
                $model->image = $request->file('image')->storeAs(
                    'uploads/breeds/',
                    uniqid() . '-' . $request->image->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('breed.index'), 'message' => 'Sửa giống loài thành công']);
    }

    public function detail($id)
    {
        $model = breed::find($id);
        $model->load('products', 'category');

        $product = Product::all();
        $category = Category::all();

        return view('admin.breed.detail', compact('category', 'product', 'model'));
    }

    public function backup(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.breed.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $breed = Breed::onlyTrashed()->select('breeds.*')->with('category');
        return dataTables::of($breed)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('cate_id', function ($row, $order) {
                return $row->orderBy('category_id', $order);
            })
            ->orderColumn('status', function ($row, $order) {
                return $row->orderBy('status', $order);
            })
            ->addColumn('category_id', function ($row) {
                return $row->category->name;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge badge-primary">Active</span>';
                } elseif ($row->status == 0) {
                    return '<span class="badge badge-danger">Deactive</span>';
                } else {
                    return '<span class="badge badge-danger">Sắp ra mắt</span>';
                }
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('breed.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('breed.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $breed = Breed::withTrashed()->find($id);
        if (empty($breed)) {
            return response()->json(['success' => 'Giống loài không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        $breed->products()->each(function ($related) {
            $related->galleries()->delete();
                                    $related->orderDetails()->where('product_type', 1)->delete();
                                    $related->reviews()->where('product_type', 1)->delete();
        });
        $breed->products()->delete();
        $breed->delete();
        return response()->json(['success' => 'Xóa giống loài thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $breed = Breed::withTrashed()->find($id);
        if (empty($breed)) {
            return response()->json(['success' => 'Giống loài không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        $breed->products()->each(function ($related) {
            $related->galleries()->restore();
                                    $related->orderDetails()->where('product_type', 1)->restore();
                                    $related->reviews()->where('product_type', 1)->restore();
                                    $related->category()->restore();
        });
        $breed->products()->restore();
        $breed->restore();
        return response()->json(['success' => 'Khôi phục giống loài thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $breed = Breed::withTrashed()->find($id);
        if (empty($breed)) {
            return response()->json(['success' => 'Giống loài không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        $breed->products()->each(function ($related) {
             $related->galleries()->forceDelete();
                                    $related->orderDetails()->where('product_type', 1)->forceDelete();
                                    $related->reviews()->where('product_type', 1)->forceDelete();
        });
        $breed->products()->forceDelete();
        $breed->forceDelete();
        return response()->json(['success' => 'Xóa bài viết thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $breed = Breed::withTrashed()->whereIn('id', $idAll);

        if ($breed->count() == 0) {
            return response()->json(['success' => 'Xóa giống loài thất bại !']);
        }

        $breed->each(function ($pro) {
            $pro->products()->each(function ($related) {
                $related->galleries()->delete();
                                        $related->orderDetails()->where('product_type', 1)->delete();
                                        $related->reviews()->where('product_type', 1)->delete();
            });
            $pro->products()->delete();
        });
        $breed->delete();
        return response()->json(['success' => 'Xóa giống loài thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $breed = Breed::withTrashed()->whereIn('id', $idAll);

        if ($breed->count() == 0) {
            return response()->json(['success' => 'Khôi phục giống loài thất bại !']);
        }

        $breed->each(function ($pro) {
            $pro->products()->each(function ($related) {
                $related->galleries()->restore();
                                        $related->orderDetails()->where('product_type', 1)->restore();
                                        $related->reviews()->where('product_type', 1)->restore();
                                        $related->category()->restore();
            });
            $pro->products()->restore();
        });
        $breed->restore();
        return response()->json(['success' => 'Khôi phục giống loài thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $breed = Breed::withTrashed()->whereIn('id', $idAll);

        if ($breed->count() == 0) {
            return response()->json(['success' => 'Xóa giống loài thất bại !']);
        }

        $breed->each(function ($pro) {
            $pro->products()->each(function ($related) {
                $related->galleries()->forceDelete();
                                        $related->orderDetails()->where('product_type', 1)->forceDelete();
                                        $related->reviews()->where('product_type', 1)->forceDelete();
            });
            $pro->products()->forceDelete();
        });
        $breed->forceDelete();
        return response()->json(['success' => 'Xóa giống loài thành công !']);
    }
}