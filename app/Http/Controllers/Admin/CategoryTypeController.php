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
            'name.required' => "H??y nh???p v??o lo???i danh m???c",
            'name.unique' => "Lo???i danh m???c ???? t???n t???i",
            'name.regex' => "T??n danh m???c kh??ng ch???a k?? t??? ?????c bi???t v?? s???",
            'name.min' => "T??n danh m???c ??t nh???t 3 k?? t???",
            'slug.required' => "Nh???p t??n danh m???c ????? t???o slug",
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
                                return $fail('Lo???i danh m???c ???? t???n t???i trong th??ng r??c .
                                 Vui l??ng nh???p th??ng tin m???i ho???c x??a d??? li???u trong th??ng r??c');
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
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('categoryType.index'), 'message' => 'Th??m lo???i danh m???c th??nh c??ng']);
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
            'name.required' => "H??y nh???p v??o lo???i danh m???c",
            'name.unique' => "Lo???i danh m???c ???? t???n t???i",
            'name.regex' => "Lo???i danh m???c kh??ng ch???a k?? t??? ?????c bi???t v?? s???",
            'name.min' => "Lo???i danh m???c ??t nh???t 3 k?? t???",
            'slug.required' => "Nh???p t??n danh m???c ????? t???o slug",
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
                                return $fail('Lo???i danh m???c ???? t???n t???i trong th??ng r??c .
                                 Vui l??ng nh???p th??ng tin m???i ho???c x??a d??? li???u trong th??ng r??c');
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
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('categoryType.index'), 'message' => 'S???a lo???i danh m???c th??nh c??ng']);
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
            return response()->json(['success' => 'Lo???i danh m???c kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i b??i vi???t']);
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
        return response()->json(['success' => 'X??a lo???i danh m???c th??nh c??ng !','undo' => "Ho??n t??c th??nh c??ng !"]);
    }

    public function restore($id)
    {
        $cateType = CategoryType::withTrashed()->find($id);
        if (empty($cateType)) {
            return response()->json(['success' => 'Lo???i danh m???c kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i b??i vi???t']);
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
        return response()->json(['success' => 'Kh??i ph???c lo???i danh m???c th??nh c??ng !', 'undo' => "Ho??n t??c th??nh c??ng !"]);
    }

    public function delete($id)
    {
        $cateType = CategoryType::withTrashed()->find($id);
        if (empty($cateType)) {
            return response()->json(['success' => 'Lo???i danh m???c kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i lo???i danh m???c']);
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
        return response()->json(['success' => 'X??a lo???i danh m???c th??nh c??ng !', 'undo' => "Ho??n t??c th??nh c??ng !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $cateType = CategoryType::withTrashed()->whereIn('id', $idAll);

        if ($cateType->count() == 0) {
            return response()->json(['success' => 'X??a lo???i danh m???c th???t b???i !']);
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
        return response()->json(['success' => 'X??a lo???i danh m???c th??nh c??ng !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $cateType = CategoryType::withTrashed()->whereIn('id', $idAll);

        if ($cateType->count() == 0) {
            return response()->json(['success' => 'Kh??i ph???c lo???i danh m???c th???t b???i !']);
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
        return response()->json(['success' => 'Kh??i ph???c lo???i danh m???c th??nh c??ng !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $cateType = CategoryType::withTrashed()->whereIn('id', $idAll);

        if ($cateType->count() == 0) {
            return response()->json(['success' => 'X??a lo???i danh m???c th???t b???i !']);
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
        return response()->json(['success' => 'X??a lo???i danh m???c th??nh c??ng !']);
    }
}