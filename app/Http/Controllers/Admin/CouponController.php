<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Coupons;
use App\Models\CouponType;
use App\Models\DiscountType;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.coupon.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $coupon = Coupons::select('coupons.*')->with('couponType', 'discountType');
        return dataTables::of($coupon)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('type', function ($row, $order) {
                return $row->orderBy('discount', $order);
            })
            ->addColumn('type', function ($row) {
                if($row->discount_type == 1){
                    return number_format($row->discount,0,',','.') . ' VND';
                }else{
                    return $row->discount . '%';
                }
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
                    <a  class="btn btn-success" href="' . route('coupon.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('coupon.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('code', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        $coupon = Coupons::all();
        $couponType = CouponType::all();
        $discountType = DiscountType::all();
        $product = Product::all();
        $category = Category::all();
        return view('admin.coupon.add-form', compact('coupon', 'couponType', 'discountType', 'product', 'category'));
    }

    public function saveAdd(Request $request, $id = null)
    {
        $model = new Coupons();

        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'code.required' => "Hãy nhập vào mã giảm giá",
            'code.unique' => "Mã giảm giá đã tồn tại",
            'code.regex' => "Mã giảm giá không chứa kí tự đặc biệt",
            'code.min' => "Mã giảm giá ít nhất 3 kí tự",
            'discount.required' => 'Hãy nhập vào giá trị giảm giá',
            'discount.numeric' => 'Giá trị giảm giá phải là số',
            'start_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'end_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'end_date.after' => 'Ngày kết thúc giảm phải sau ngày bắt đầu',
            'discount_type.required' => 'Hãy chọn kiểu giảm giá',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'code' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_]*$/',
                    'min:3',
                    Rule::unique('coupons')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Coupons::onlyTrashed()
                            ->where('code', 'like', '%' . $request->code . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->code) {
                                return $fail('Mã giảm giá đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'discount' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value > 100 && $request->discount_type == 2) {
                            return $fail('Giảm giá không vượt quá 100%');
                        }
                    },
                ],
                //nullable cho phép validate không bắt buộc trừ khi có dữ liệu nhập vào
                'start_date' => 'nullable|date_format:Y-m-d H:i',
                'end_date' => 'nullable|date_format:Y-m-d H:i|after:start_date',
                'discount_type' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $discountType = DiscountType::where('id', $request->discount_type)->first();
                        if ($discountType == '') {
                            return $fail('Kiểu giảm giá không tồn tại');
                        }
                    },
                ]
            ],
            $message
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('coupon.index')]);
        } else {
            $model->fill($request->all());
            $model->user_id = Auth::id();
            if($request->start_date != ''){
                 $model->start_date = Carbon::parse($request->start_date)->format('Y-m-d H:i');
            }
            $model->start_date = null;
            if($request->end_date != ''){
                 $model->end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i');
            }
            $model->end_date = null;

            $model->save();
            
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('coupon.index'), 'message' => 'Thêm giảm giá thành công']);
    }
    public function editForm($id)
    {
        $coupon = Coupons::find($id);
        $couponType = CouponType::all();
        $discountType = DiscountType::all();
        $product = Product::all();
        $category = Category::all();
        if (!$coupon) {
            return redirect()->back();
        }
        return view('admin.coupon.edit-form', compact('coupon', 'couponType', 'discountType', 'product', 'category'));
    }
    public function saveEdit($id, Request $request)
    {
        $model = Coupons::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'code.required' => "Hãy nhập vào mã giảm giá",
            'code.unique' => "Mã giảm giá đã tồn tại",
            'code.regex' => "Mã giảm giá không chứa kí tự đặc biệt",
            'code.min' => "Mã giảm giá ít nhất 3 kí tự",
            'discount.required' => 'Hãy nhập vào giá trị giảm giá',
            'discount.numeric' => 'Giá trị giảm giá phải là số',
            'start_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'end_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'end_date.after' => 'Ngày kết thúc giảm phải sau ngày bắt đầu',
            'discount_type.required' => 'Hãy chọn kiểu giảm giá',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'code' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_]*$/',
                    'min:3',
                    Rule::unique('coupons')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Coupons::onlyTrashed()
                            ->where('code', 'like', '%' . $request->code . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->code) {
                                return $fail('Mã giảm giá đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'discount' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value > 100 && $request->discount_type == 2) {
                            return $fail('Giảm giá không vượt quá 100%');
                        }
                    },
                ],
                //nullable cho phép validate không bắt buộc trừ khi có dữ liệu nhập vào
                'start_date' => 'nullable|date_format:Y-m-d H:i',
                'end_date' => 'nullable|date_format:Y-m-d H:i|after:start_date',
                'discount_type' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $discountType = DiscountType::where('id', $request->discount_type)->first();
                        if ($discountType == '') {
                            return $fail('Kiểu giảm giá không tồn tại');
                        }
                    },
                ]
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('coupon.index')]);
        } else {
            $model->fill($request->all());
            $model->user_id = Auth::id();
            if($request->start_date != ''){
                 $model->start_date = Carbon::parse($request->start_date)->format('Y-m-d H:i');
            }
             $model->start_date = null;
            if($request->end_date != ''){
                 $model->end_date = Carbon::parse($request->end_date)->format('Y-m-d H:i');
            }
            $model->end_date = null;
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('coupon.index'), 'message' => 'Sửa giảm giá thành công']);
    }

    public function detail(Request $request)
    {
    }

    public function backup(Request $request)
    {
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.coupon.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $coupon = Coupons::onlyTrashed()->select('coupons.*')->with('category');
        return dataTables::of($coupon)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
             ->orderColumn('type', function ($row, $order) {
                return $row->orderBy('discount', $order);
            })
            ->addColumn('type', function ($row) {
                if($row->discount_type == 1){
                    return number_format($row->discount,0,',','.') . ' VND';
                }else{
                    return $row->discount . '%';
                }
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
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('coupon.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('coupon.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status') == '0' || $request->get('status') == '1' || $request->get('status') == '3') {
                    $instance->where('status', $request->get('status'));
                }

                if ($request->get('cate') != '') {
                    $instance->where('category_id', $request->get('cate'));
                }

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
        $coupon = Coupons::withTrashed()->find($id);
        $coupon->with(['couponType', 'discountType', 'products', 'couponUsage', 'accessory', 'category']);
        if (empty($coupon)) {
            return response()->json(['success' => 'Giảm không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại giảm giá']);
        }
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
        $coupon->delete();
        return response()->json(['success' => 'Xóa giảm giá thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $coupon = Coupons::withTrashed()->find($id);
        if (empty($coupon)) {
            return response()->json(['success' => 'Giảm giá không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
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
        $coupon->restore();
        return response()->json(['success' => 'Khôi phục giảm giá thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $coupon = Coupons::withTrashed()->find($id);
        if (empty($coupon)) {
            return response()->json(['success' => 'Giảm giá không tồn tại !', 'undo' => "Xóa thất bại !", "empty" => 'Kiểm tra lại bài viết']);
        }
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
        $coupon->forceDelete();
        return response()->json(['success' => 'Xóa giảm giá thành công !']);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $coupon = Coupons::withTrashed()->whereIn('id', $idAll);

        if ($coupon->count() == 0) {
            return response()->json(['success' => 'Xóa giống loài thất bại !']);
        }
        $coupon->each(function ($couponMul) {
            if ($couponMul->category()->count() !== 0) {

                $couponMul->category()->each(function ($product) {

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

                $couponMul->category()->delete();
            }
            $couponMul->products()->each(function ($related) {
                $related->galleries()->delete();
                $related->orderDetails()->where('product_type', 1)->delete();
                $related->reviews()->where('product_type', 1)->delete();
            });

            $couponMul->accessory()->each(function ($related) {
                $related->galleries()->delete();
                $related->orderDetails()->where('product_type', 2)->delete();
                $related->reviews()->where('product_type', 2)->delete();
            });
            $couponMul->accessory()->delete();
            $couponMul->products()->delete();
            $couponMul->couponUsage()->delete();
        });
        $coupon->delete();

        return response()->json(['success' => 'Xóa giảm giá thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $coupon = Coupons::withTrashed()->whereIn('id', $idAll);

        if ($coupon->count() == 0) {
            return response()->json(['success' => 'Khôi phục giảm giá thất bại !']);
        }
        $coupon->each(function ($couponMul) {
            if ($couponMul->category()->count() !== 0) {

                $couponMul->category()->each(function ($product) {

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

                $couponMul->category()->restore();
            }
            $couponMul->products()->each(function ($related) {
                $related->galleries()->restore();
                $related->orderDetails()->where('product_type', 1)->restore();
                $related->reviews()->where('product_type', 1)->restore();
                $related->category()->restore();
            });

            $couponMul->accessory()->each(function ($related) {
                $related->galleries()->restore();
                $related->orderDetails()->where('product_type', 1)->restore();
                $related->reviews()->where('product_type', 1)->restore();
                $related->category()->restore();
            });
            $couponMul->accessory()->restore();
            $couponMul->products()->restore();
            $couponMul->couponUsage()->restore();
        });
        $coupon->restore();

        return response()->json(['success' => 'Khôi phục giảm giá thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $coupon = Coupons::withTrashed()->whereIn('id', $idAll);

        if ($coupon->count() == 0) {
            return response()->json(['success' => 'Xóa giảm giá thất bại !']);
        }
        $coupon->each(function ($couponMul) {
            if ($couponMul->category()->count() !== 0) {

                $couponMul->category()->each(function ($product) {

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

                $couponMul->category()->forceDelete();
            }
            $couponMul->products()->each(function ($related) {
                $related->galleries()->forceDelete();
                $related->orderDetails()->where('product_type', 1)->forceDelete();
                $related->reviews()->where('product_type', 1)->forceDelete();
            });

            $couponMul->accessory()->each(function ($related) {
                $related->galleries()->forceDelete();
                $related->orderDetails()->where('product_type', 2)->forceDelete();
                $related->reviews()->where('product_type', 2)->forceDelete();
            });
            $couponMul->accessory()->forceDelete();
            $couponMul->products()->forceDelete();
            $couponMul->couponUsage()->forceDelete();
        });
        $coupon->forceDelete();

        return response()->json(['success' => 'Xóa giảm giá thành công !']);
    }
}