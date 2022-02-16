<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class DiscountTypeController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.discountType.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $discountType = DiscountType::select('discount_types.*');
        return dataTables::of($discountType)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="' . route('discountType.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('discountType.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
        return view('admin.discountType.add-form');
    }

    public function saveAdd(Request $request, $id = null)
    {
        $model = new DiscountType();

        $message = [
            'name.required' => "Hãy nhập vào loại giảm giá",
            'name.unique' => "Loại giảm giá đã tồn tại",
            'name.regex' => "Loại giảm giá không tồn tại số và các kí hiệu đặc biệt",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    Rule::unique('coupon_types')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = DiscountType::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Loại giảm giá đã tồn tại trong thùng rác .
                             Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    }
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('discountType.index')]);
        } else {
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('discountType.index'), 'message' => 'Thêm kiểu giảm giá thành công']);
    }
    public function editForm($id)
    {
        $model = DiscountType::find($id);
        if (!$model) {
            return redirect()->back();
        }
        return view('admin.discountType.edit-form', compact('model'));
    }
    public function saveEdit($id, Request $request)
    {
        $model = DiscountType::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "Hãy nhập vào loại giảm giá",
            'name.unique' => "Loại giảm giá đã tồn tại",
            'name.regex' => "Loại giảm giá không tồn tại số và các kí hiệu đặc biệt",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    Rule::unique('coupon_types')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = DiscountType::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Loại giảm giá đã tồn tại trong thùng rác .
                             Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    }
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('discountType.index')]);
        } else {
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('discountType.index'), 'message' => 'Sửa kiểu giảm giá thành công']);
    }

    public function backup(Request $request)
    {
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.discountType.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $discountType = DiscountType::onlyTrashed()->select('discount_types.*');
        return dataTables::of($discountType)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('discountType.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('discountType.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
        $discountType = DiscountType::withTrashed()->find($id);
        $discountType->with('coupons');
        if (empty($discountType)) {
            return response()->json(['success' => 'Loại giảm giá không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại giảm giá']);
        }
        if ($discountType->coupons()->count() !== 0) {
            $discountType->coupons()->each(function ($coupon) {
                if ($coupon->category()->count() !== 0) {
                    $coupon->category()->each(function ($product) {

                        if($product->category_type_id == 1){
                            if ($product->breeds()->count() == 0) {
                                $product->products()->each(function ($related) {
                                    $related->galleries()->delete();
                                    $related->orderDetails()->where('product_type', 1)->delete();
                                    $related->reviews()->where('product_type', 1)->delete();
                                });
                            $product->products()->delete();
                            } else {

                                $product->breeds()->each(function ($related) {
                                    $related->products()->each(function ($related) {
                                        $related->galleries()->delete();
                                        $related->orderDetails()->where('product_type', 1)->delete();
                                        $related->reviews()->where('product_type', 1)->delete();
                                    });
                                    $related->products()->delete();
                                });
                                $product->breeds()->delete();
                                $product->products()->each(function ($related) {
                                    $related->galleries()->delete();
                                    $related->orderDetails()->where('product_type', 1)->delete();
                                    $related->reviews()->where('product_type', 1)->delete();
                                });
                                $product->products()->delete();
                            }
                        }elseif($product->category_type_id == 2){
                            $product->accessory()->each(function ($related) {
                                $related->galleries()->delete();
                                $related->orderDetails()->where('product_type', 2)->delete();
                                $related->reviews()->where('product_type', 2)->delete();
                            });
                            $product->accessory()->delete();
                        }
                    });

                    $coupon->category()->delete();
                }

                $coupon->products()->each(function ($related) {
                    $related->galleries()->delete();
                    $related->orderDetails()->where('product_type', 1)->delete();
                    $related->reviews()->where('product_type', 1)->delete();
                });

                $coupon->accessory()->each(function ($related) {
                    $related->galleries()->delete();
                    $related->orderDetails()->where('product_type', 2)->delete();
                    $related->reviews()->where('product_type', 2)->delete();
                });
                $coupon->accessory()->delete();
                $coupon->products()->delete();
                $coupon->couponUsage()->delete();
            });
        };
        $discountType->coupons()->delete();
        $discountType->products()->each(function ($related) {
            $related->galleries()->delete();
            $related->orderDetails()->where('product_type', 1)->delete();
            $related->reviews()->where('product_type', 1)->delete();
        });
        $discountType->products()->delete();
        $discountType->accessory()->each(function ($related) {
            $related->galleries()->delete();
            $related->orderDetails()->where('product_type', 2)->delete();
            $related->reviews()->where('product_type', 2)->delete();
        });
        $discountType->accessory()->delete();
        $discountType->delete();
        return response()->json(['success' => 'Xóa loại giảm giá thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $discountType = DiscountType::withTrashed()->find($id);
        if (empty($discountType)) {
            return response()->json(['success' => 'Loại giảm giá không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
        if ($discountType->coupons()->count() !== 0) {
            $discountType->coupons()->each(function ($coupon) {
                if ($coupon->category()->count() !== 0) {
                    $coupon->category()->each(function ($product) {

                        if($product->category_type_id == 1){
                            if ($product->breeds()->count() == 0) {
                                $product->products()->each(function ($related) {
                                    $related->galleries()->restore();
                                    $related->orderDetails()->where('product_type', 1)->restore();
                                    $related->reviews()->where('product_type', 1)->restore();
                                    $related->category()->restore();
                                });
                            $product->products()->restore();
                            } else {

                                $product->breeds()->each(function ($related) {
                                    $related->products()->each(function ($related) {
                                        $related->galleries()->restore();
                                        $related->orderDetails()->where('product_type', 1)->restore();
                                        $related->reviews()->where('product_type', 1)->restore();
                                        $related->category()->restore();
                                    });
                                    $related->products()->restore();
                                });
                                $product->breeds()->restore();
                                $product->products()->each(function ($related) {
                                    $related->galleries()->restore();
                                    $related->orderDetails()->where('product_type', 1)->restore();
                                    $related->reviews()->where('product_type', 1)->restore();
                                    $related->category()->restore();
                                });
                                $product->products()->restore();
                            }
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

                    $coupon->category()->restore();
                }

                $coupon->products()->each(function ($related) {
                    $related->galleries()->restore();
                    $related->orderDetails()->where('product_type', 1)->restore();
                    $related->reviews()->where('product_type', 1)->restore();
                    $related->category()->restore();
                });

                $coupon->accessory()->each(function ($related) {
                    $related->galleries()->restore();
                    $related->orderDetails()->where('product_type', 2)->restore();
                    $related->reviews()->where('product_type', 2)->restore();
                    $related->category()->restore();
                });
                $coupon->accessory()->restore();
                $coupon->products()->restore();
                $coupon->couponUsage()->restore();
            });
        };
        $discountType->coupons()->restore();
        $discountType->products()->each(function ($related) {
            $related->galleries()->restore();
            $related->orderDetails()->where('product_type', 1)->restore();
            $related->reviews()->where('product_type', 1)->restore();
            $related->category()->restore();
        });
        $discountType->products()->restore();
        $discountType->accessory()->each(function ($related) {
            $related->galleries()->restore();
            $related->orderDetails()->where('product_type', 2)->restore();
            $related->reviews()->where('product_type', 2)->restore();
            $related->category()->restore();
        });
        $discountType->accessory()->restore();
        $discountType->restore();
        return response()->json(['success' => 'Khôi phục loại giảm giá thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $discountType = DiscountType::withTrashed()->find($id);
        $discountType->with('coupons');
        if (empty($discountType)) {
            return response()->json(['success' => 'Kiểu giảm giá không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại giảm giá']);
        }
        if ($discountType->coupons()->count() !== 0) {
            $discountType->coupons()->each(function ($coupon) {
                if ($coupon->category()->count() !== 0) {
                    $coupon->category()->each(function ($product) {

                        if($product->category_type_id == 1){
                            if ($product->breeds()->count() == 0) {
                                $product->products()->each(function ($related) {
                                    $related->galleries()->forceDelete();
                                    $related->orderDetails()->where('product_type', 1)->forceDelete();
                                    $related->reviews()->where('product_type', 1)->forceDelete();
                                });
                            $product->products()->forceDelete();
                            } else {

                                $product->breeds()->each(function ($related) {
                                    $related->products()->each(function ($related) {
                                        $related->galleries()->forceDelete();
                                        $related->orderDetails()->where('product_type', 1)->forceDelete();
                                        $related->reviews()->where('product_type', 1)->forceDelete();
                                    });
                                    $related->products()->forceDelete();
                                });
                                $product->breeds()->forceDelete();
                                $product->products()->each(function ($related) {
                                    $related->galleries()->forceDelete();
                                    $related->orderDetails()->where('product_type', 1)->forceDelete();
                                    $related->reviews()->where('product_type', 1)->forceDelete();
                                });
                                $product->products()->forceDelete();
                            }
                        }elseif($product->category_type_id == 2){
                            $product->accessory()->each(function ($related) {
                                $related->galleries()->forceDelete();
                                $related->orderDetails()->where('product_type', 2)->forceDelete();
                                $related->reviews()->where('product_type', 2)->forceDelete();
                            });
                            $product->accessory()->forceDelete();
                        }
                    });

                    $coupon->category()->forceDelete();
                }

                $coupon->products()->each(function ($related) {
                    $related->galleries()->forceDelete();
                    $related->orderDetails()->where('product_type', 1)->forceDelete();
                    $related->reviews()->where('product_type', 1)->forceDelete();
                });

                $coupon->accessory()->each(function ($related) {
                    $related->galleries()->forceDelete();
                    $related->orderDetails()->where('product_type', 2)->forceDelete();
                    $related->reviews()->where('product_type', 2)->forceDelete();
                });
                $coupon->accessory()->forceDelete();
                $coupon->products()->forceDelete();
                $coupon->couponUsage()->forceDelete();
            });
        };
        $discountType->coupons()->forceDelete();
        $discountType->products()->each(function ($related) {
            $related->galleries()->forceDelete();
            $related->orderDetails()->where('product_type', 1)->forceDelete();
            $related->reviews()->where('product_type', 1)->forceDelete();
        });
        $discountType->products()->forceDelete();
        $discountType->accessory()->each(function ($related) {
            $related->galleries()->forceDelete();
            $related->orderDetails()->where('product_type', 2)->forceDelete();
            $related->reviews()->where('product_type', 2)->forceDelete();
        });
        $discountType->accessory()->forceDelete();
        $discountType->forceDelete();
        return response()->json(['success' => 'Xóa kiểu giảm giá thành công !']);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $discountType = DiscountType::withTrashed()->whereIn('id', $idAll);

        if ($discountType->count() == 0) {
            return response()->json(['success' => 'Xóa giống loài thất bại !']);
        }
        $discountType->each(function ($coupons) {
            if ($coupons->coupons()->count() !== 0) {
                $coupons->coupons()->each(function ($coupon) {
                    if ($coupon->category()->count() !== 0) {
                        $coupon->category()->each(function ($product) {

                            if($product->category_type_id == 1){
                                if ($product->breeds()->count() == 0) {
                                    $product->products()->each(function ($related) {
                                        $related->galleries()->delete();
                                        $related->orderDetails()->where('product_type', 1)->delete();
                                        $related->reviews()->where('product_type', 1)->delete();
                                    });
                                    $product->products()->delete();
                                } else {

                                    $product->breeds()->each(function ($related) {
                                        $related->products()->each(function     ($related) {
                                            $related->galleries()->delete();
                                            $related->orderDetails()->where('product_type', 1)->delete();
                                            $related->reviews()->where('product_type', 1)->delete();
                                        });
                                        $related->products()->delete();
                                    });
                                    $product->breeds()->delete();
                                    $product->products()->each(function ($related) {
                                        $related->galleries()->delete();
                                        $related->orderDetails()->where('product_type', 1)->delete();
                                        $related->reviews()->where('product_type', 1)->delete();
                                    });
                                    $product->products()->delete();
                                }
                            }elseif($product->category_type_id == 2){
                                $product->accessory()->each(function ($related) {
                                    $related->galleries()->delete();
                                    $related->orderDetails()->where('product_type', 2)->delete();
                                    $related->reviews()->where('product_type', 2)->delete();
                                });
                                $product->accessory()->delete();
                            }
                        });

                        $coupon->category()->delete();
                    }

                    $coupon->products()->each(function ($related) {
                        $related->galleries()->delete();
                        $related->orderDetails()->where('product_type', 1)->delete();
                        $related->reviews()->where('product_type', 1)->delete();
                    });

                    $coupon->accessory()->each(function ($related) {
                        $related->galleries()->delete();
                        $related->orderDetails()->where('product_type', 2)->delete();
                        $related->reviews()->where('product_type', 2)->delete();
                    });
                    $coupon->accessory()->delete();
                    $coupon->products()->delete();
                    $coupon->couponUsage()->delete();
                });
            };
            $coupons->coupons()->delete();
            $coupons->products()->each(function ($related) {
                $related->galleries()->delete();
                $related->orderDetails()->where('product_type', 1)->delete();
                $related->reviews()->where('product_type', 1)->delete();
            });
            $coupons->products()->delete();
            $coupons->accessory()->each(function ($related) {
                $related->galleries()->where('product_type', 2)->delete();
                $related->orderDetails()->where('product_type', 2)->delete();
                $related->reviews()->delete();
            });
            $coupons->accessory()->delete();
        });
        $discountType->delete();

        return response()->json(['success' => 'Xóa kiểu giảm giá thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $discountType = DiscountType::withTrashed()->whereIn('id', $idAll);

        if ($discountType->count() == 0) {
            return response()->json(['success' => 'Khôi phục kiểu giảm giá thất bại !']);
        }
        $discountType->each(function ($coupons) {
            if ($coupons->coupons()->count() !== 0) {
                $coupons->coupons()->each(function ($coupon) {
                    if ($coupon->category()->count() !== 0) {
                        $coupon->category()->each(function ($product) {

                            if($product->category_type_id == 1){
                                if ($product->breeds()->count() == 0) {
                                    $product->products()->each(function ($related) {
                                        $related->galleries()->restore();
                                        $related->orderDetails()->where('product_type', 1)->restore();
                                        $related->reviews()->where('product_type', 1)->restore();
                                        $related->category()->restore();
                                    });
                                    $product->products()->restore();
                                } else {

                                    $product->breeds()->each(function ($related) {
                                        $related->products()->each(function     ($related) {
                                            $related->galleries()->restore();
                                            $related->orderDetails()->where('product_type', 1)->restore();
                                            $related->reviews()->where('product_type', 1)->restore();
                                            $related->category()->restore();
                                        });
                                        $related->products()->restore();
                                    });
                                    $product->breeds()->restore();
                                    $product->products()->each(function ($related) {
                                        $related->galleries()->restore();
                                        $related->orderDetails()->where('product_type', 1)->restore();
                                        $related->reviews()->where('product_type', 1)->restore();
                                        $related->category()->restore();
                                    });
                                    $product->products()->restore();
                                }
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

                        $coupon->category()->restore();
                    }

                    $coupon->products()->each(function ($related) {
                        $related->galleries()->restore();
                        $related->orderDetails()->where('product_type', 1)->restore();
                        $related->reviews()->where('product_type', 1)->restore();
                        $related->category()->restore();
                    });

                    $coupon->accessory()->each(function ($related) {
                        $related->galleries()->restore();
                        $related->orderDetails()->where('product_type', 2)->restore();
                        $related->reviews()->where('product_type', 2)->restore();
                        $related->category()->restore();
                    });
                    $coupon->accessory()->restore();
                    $coupon->products()->restore();
                    $coupon->couponUsage()->restore();
                });
            };
            $coupons->coupons()->restore();
            $coupons->products()->each(function ($related) {
                $related->galleries()->restore();
                $related->orderDetails()->where('product_type', 1)->restore();
                $related->reviews()->where('product_type', 1)->restore();
                $related->category()->restore();
            });
            $coupons->products()->restore();
            $coupons->accessory()->each(function ($related) {
                $related->galleries()->restore();
                $related->orderDetails()->where('product_type', 2)->restore();
                $related->reviews()->where('product_type', 2)->restore();
                $related->category()->restore();
            });
            $coupons->accessory()->restore();
        });
        $discountType->restore();

        return response()->json(['success' => 'Khôi phục kiểu giảm giá thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $discountType = DiscountType::withTrashed()->whereIn('id', $idAll);

        if ($discountType->count() == 0) {
            return response()->json(['success' => 'Xóa kiểu giảm giá thất bại !']);
        }

        $discountType->each(function ($coupons) {
            if ($coupons->coupons()->count() !== 0) {
                $coupons->coupons()->each(function ($coupon) {
                    if ($coupon->category()->count() !== 0) {
                        $coupon->category()->each(function ($product) {

                            if($product->category_type_id == 1){
                                if ($product->breeds()->count() == 0) {
                                    $product->products()->each(function ($related) {
                                        $related->galleries()->forceDelete();
                                        $related->orderDetails()->where('product_type', 1)->forceDelete();
                                        $related->reviews()->where('product_type', 1)->forceDelete();
                                    });
                                    $product->products()->forceDelete();
                                } else {

                                    $product->breeds()->each(function ($related) {
                                        $related->products()->each(function     ($related) {
                                            $related->galleries()->forceDelete();
                                            $related->orderDetails()->where('product_type', 1)->forceDelete();
                                            $related->reviews()->where('product_type', 1)->forceDelete();
                                        });
                                        $related->products()->forceDelete();
                                    });
                                    $product->breeds()->forceDelete();
                                    $product->products()->each(function ($related) {
                                        $related->galleries()->forceDelete();
                                        $related->orderDetails()->where('product_type', 1)->forceDelete();
                                        $related->reviews()->where('product_type', 1)->forceDelete();
                                    });
                                    $product->products()->forceDelete();
                                }
                            }elseif($product->category_type_id == 2){
                                $product->accessory()->each(function ($related) {
                                    $related->galleries()->forceDelete();
                                    $related->orderDetails()->where('product_type', 2)->forceDelete();
                                    $related->reviews()->where('product_type', 2)->forceDelete();
                                });
                                $product->accessory()->forceDelete();
                            }
                        });

                        $coupon->category()->forceDelete();
                    }

                    $coupon->products()->each(function ($related) {
                        $related->galleries()->forceDelete();
                        $related->orderDetails()->where('product_type', 1)->forceDelete();
                        $related->reviews()->where('product_type', 1)->forceDelete();
                    });

                    $coupon->accessory()->each(function ($related) {
                        $related->galleries()->forceDelete();
                        $related->orderDetails()->where('product_type', 2)->forceDelete();
                        $related->reviews()->where('product_type', 2)->forceDelete();
                    });
                    $coupon->accessory()->forceDelete();
                    $coupon->products()->forceDelete();
                    $coupon->couponUsage()->forceDelete();
                });
            };
            $coupons->coupons()->forceDelete();
            $coupons->products()->each(function ($related) {
                $related->galleries()->forceDelete();
                $related->orderDetails()->where('product_type', 1)->forceDelete();
                $related->reviews()->where('product_type', 1)->forceDelete();
            });
            $coupons->products()->forceDelete();
            $coupons->accessory()->each(function ($related) {
                $related->galleries()->forceDelete();
                $related->orderDetails()->where('product_type', 2)->forceDelete();
                $related->reviews()->where('product_type', 2)->forceDelete();
            });
            $coupons->accessory()->forceDelete();
        });
        $discountType->forceDelete();

        return response()->json(['success' => 'Xóa kiểu giảm giá thành công !']);
    }
}