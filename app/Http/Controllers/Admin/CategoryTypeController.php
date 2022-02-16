<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class CategoryTypeController extends Controller
{
    public function index(Request $request)
    {
        
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.categoryType.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $category = CategoryType::select('category_types.*');
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
                    <a href="' . route('categoryType.edit', ['id' => $row->id]) . '" class="btn btn-outline-success"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('categoryType.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        return view('admin.categoryType.add-form');
    }

    public function saveAdd(Request $request, $id = null)
    {
        $message = [
            'name.required' => "Hãy nhập vào loại danh mục",
            'name.unique' => "Loại danh mục đã tồn tại",
            'name.regex' => "Tên danh mục không chứa kí tự đặc biệt và số",
            'name.min' => "Tên danh mục ít nhất 3 kí tự",
            'slug.required' => "Nhập tên danh mục để tạo slug",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('category_types')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = CategoryType::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Loại danh mục đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'slug' => 'required',
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('categoryType.index')]);
        } else {
            $model = new CategoryType();
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('categoryType.index'), 'message' => 'Thêm loại danh mục thành công']);
    }

    public function editForm($id)
    {
        $model = CategoryType::find($id);

        if (!$model) {
            return redirect()->back();
        }
        return view('admin.categoryType.edit-form', compact('model'));
    }

    public function saveEdit($id, Request $request)
    {
        $model = CategoryType::find($id);
        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "Hãy nhập vào loại danh mục",
            'name.unique' => "Loại danh mục đã tồn tại",
            'name.regex' => "Loại danh mục không chứa kí tự đặc biệt và số",
            'name.min' => "Loại danh mục ít nhất 3 kí tự",
            'slug.required' => "Nhập tên danh mục để tạo slug",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('category_types')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = CategoryType::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Loại danh mục đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'slug' => 'required',
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('categoryType.index')]);
        } else {
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('categoryType.index'), 'message' => 'Sửa loại danh mục thành công']);
    }

    public function backUp()
    {
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.categoryType.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $category = CategoryType::onlyTrashed()->select('category_types.*');
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
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('categoryType.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('categoryType.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $cateType = CategoryType::withTrashed()->find($id);
        if (empty($cateType)) {
            return response()->json(['success' => 'Loại danh mục không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }

        $cateType->category()->each(function ($product) {
            if($product->category_type_id == 1){
                $product->products()->each(function ($related) {
                    $related->galleries()->delete();
                $related->orderDetails()->where('product_type', 1)->delete();
                $related->reviews()->where('product_type', 1)->delete();
                });
                $product->products()->delete();
            }elseif($product->category_type_id == 2){
                $product->accessory()->each(function ($related) {
                    $related->galleries()->delete();
                $related->orderDetails()->where('product_type', 2)->delete();
                $related->reviews()->where('product_type', 2)->delete();
                });
                $product->accessory()->delete();
            }
           
        });
        $cateType->category()->delete();
        $cateType->delete();
        return response()->json(['success' => 'Xóa loại danh mục thành công !','undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $cateType = CategoryType::withTrashed()->find($id);
        if (empty($cateType)) {
            return response()->json(['success' => 'Loại danh mục không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        $cateType->category()->each(function ($product) {
            if($product->category_type_id == 1){
                $product->products()->each(function ($related) {
                    $related->galleries()->restore();
                    $related->orderDetails()->where('product_type', 1)->restore();
                    $related->reviews()->where('product_type', 1)->restore();
                    $related->category()->restore();
                });
                $product->products()->restore();
            }elseif($product->category_type_id == 2){
                $product->accessory()->each(function ($related) {
                    $related->galleries()->restore();
                    $related->orderDetails()->where('product_type', 2)->restore();
                    $related->reviews()->where('product_type', 2)->restore();
                    $related->category()->restore();
                });
                $product->accessory()->restore();
            }
        });
        $cateType->category()->restore();
        $cateType->restore();
        return response()->json(['success' => 'Khôi phục loại danh mục thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $cateType = CategoryType::withTrashed()->find($id);
        if (empty($cateType)) {
            return response()->json(['success' => 'Loại danh mục không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại loại danh mục']);
        }
        $cateType->category()->each(function ($product) {
            if($product->category_type_id == 1){
                $product->products()->each(function ($related) {
                    $related->galleries()->forceDelete();
                    $related->orderDetails()->where('product_type', 1)->forceDelete();
                    $related->reviews()->where('product_type', 1)->forceDelete();
                });
                $product->products()->forceDelete();
            }elseif($product->category_type_id == 2){
                $product->accessory()->each(function ($related) {
                    $related->galleries()->forceDelete();
                    $related->orderDetails()->where('product_type', 2)->forceDelete();
                    $related->reviews()->where('product_type', 2)->forceDelete();
                });
                $product->accessory()->forceDelete();
            }
        });
        $cateType->category()->forceDelete();
        $cateType->forceDelete();
        return response()->json(['success' => 'Xóa loại danh mục thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $cateType = CategoryType::withTrashed()->whereIn('id', $idAll);

        if ($cateType->count() == 0) {
            return response()->json(['success' => 'Xóa loại danh mục thất bại !']);
        }
        $cateType->each(function ($cate) {
            $cate->category()->each(function ($product) {
                if($product->category_type_id == 1){
                    $product->products()->each(function ($related) {
                        $related->galleries()->delete();
                        $related->orderDetails()->where('product_type', 1)->delete();
                        $related->reviews()->where('product_type', 1)->delete();
                    });
                    $product->products()->delete();
                }elseif($product->category_type_id == 2){
                    $product->accessory()->each(function ($related) {
                        $related->galleries()->delete();
                        $related->orderDetails()->where('product_type', 2)->delete();
                        $related->reviews()->where('product_type', 2)->delete();
                    });
                    $product->accessory()->delete();
                }
            });
            $cate->category()->delete();
        });

        $cateType->delete();
        return response()->json(['success' => 'Xóa loại danh mục thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $cateType = CategoryType::withTrashed()->whereIn('id', $idAll);

        if ($cateType->count() == 0) {
            return response()->json(['success' => 'Khôi phục loại danh mục thất bại !']);
        }

        $cateType->each(function ($cate) {
            $cate->category()->each(function ($product) {
                if($product->category_type_id == 1){
                    $product->products()->each(function ($related) {
                        $related->galleries()->restore();
                        $related->orderDetails()->where('product_type', 1)->restore();
                        $related->reviews()->where('product_type', 1)->restore();
                        $related->category()->restore();
                    });
                    $product->products()->restore();
                }elseif($product->category_type_id == 2){
                    $product->accessory()->each(function ($related) {
                        $related->galleries()->restore();
                        $related->orderDetails()->where('product_type', 2)->restore();
                        $related->reviews()->where('product_type', 2)->restore();
                        $related->category()->restore();
                    });
                    $product->accessory()->restore();
                }
            });
            $cate->category()->restore();
        });

        $cateType->restore();
        return response()->json(['success' => 'Khôi phục loại danh mục thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $cateType = CategoryType::withTrashed()->whereIn('id', $idAll);

        if ($cateType->count() == 0) {
            return response()->json(['success' => 'Xóa loại danh mục thất bại !']);
        }

        $cateType->each(function ($cate) {
            $cate->category()->each(function ($product) {
                if($product->category_type_id == 1){
                    $product->products()->each(function ($related) {
                        $related->galleries()->forceDelete();
                        $related->orderDetails()->where('product_type', 1)->forceDelete();
                        $related->reviews()->where('product_type', 1)->forceDelete();
                    });
                    $product->products()->forceDelete();
                }elseif($product->category_type_id == 2){
                    $product->accessory()->each(function ($related) {
                        $related->galleries()->forceDelete();
                        $related->orderDetails()->where('product_type', 2)->forceDelete();
                        $related->reviews()->where('product_type', 2)->forceDelete();
                    });
                    $product->accessory()->forceDelete();
                }
            });
            $cate->category()->forceDelete();
        });

        $cateType->forceDelete();
        return response()->json(['success' => 'Xóa loại danh mục thành công !']);
    }
}