<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Age;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class AgeController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.age.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $age = Age::select('ages.*');
        return dataTables::of($age)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            // ->orderColumn('product', function ($row, $order) {
            //     return $row
            //         ->withTrashed()
            //         ->join('products', 'products.age_id', '=', 'ages.id')
            //         ->groupBy('ages.id')
            //         ->orderByRaw("count(ages.id)$order");
            // })
            // ->addColumn('product', function (Age $row) {
            //     return $row->products->map(function ($pro) {
            //         return '<a href="' . route('product.detail', ['id' => $pro->id]) . '" class="btn btn-outline-primary">' . $pro->name . '</a>';
            //     })->implode(' ');
            // })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="' . route('age.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('age.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('age', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        return view('admin.age.add-form');
    }

    public function saveAdd(Request $request, $id = null)
    {

        $message = [
            'age.required' => "Hãy nhập vào tuổi",
            'age.unique' => "Tuổi đã tồn tại",
            'age.regex' => "Tuổi không chứa kí tự đặc biệt",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'age' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_]*$/',
                    Rule::unique('ages')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Age::onlyTrashed()
                            ->where('age', 'like', '%' . $request->age . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->age) {
                                return $fail('Tuổi đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('age.index')]);
        } else {
            $model = new Age();
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('age.index'), 'message' => 'Thêm tuổi thành công']);
    }

    public function editForm($id)
    {
        $model = Age::find($id);
        if (!$model) {
            return redirect()->back();
        }
        return view('admin.age.edit-form', compact('model'));
    }

    public function saveEdit($id, Request $request)
    {

        $model = Age::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'age.required' => "Hãy nhập vào tuổi",
            'age.unique' => "Tuổi đã tồn tại",
            'age.regex' => "Tuổi không chứa kí tự đặc biệt",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'age' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_]*$/',
                    Rule::unique('ages')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Age::onlyTrashed()
                            ->where('age', 'like', '%' . $request->age . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->age) {
                                return $fail('Tuổi đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('age.index')]);
        } else {
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('age.index'), 'message' => 'Sửa tuổi thành công']);
    }

    public function detail($id)
    {
        $model = Age::find($id);
        $model->load('products');

        $product = Product::all();
        // $category = Category::all();

        return view('admin.age.detail', compact('product', 'model'));
    }

    public function backup(Request $request)
    {
        $admin = Auth::user()->hasanyrole('admin|manager');
        return view('admin.age.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $age = Age::onlyTrashed()->select('ages.*');
        return dataTables::of($age)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            // ->orderColumn('product', function ($row, $order) {
            //     return $row
            //         ->onlyTrashed()
            //         ->join('products', 'products.age_id', '=', 'ages.id')
            //         ->groupBy('ages.id')
            //         ->orderByRaw("count(ages.id)$order");
            // })
            // ->addColumn('product', function (Age $row) {
            //     return $row->products->map(function ($pro) {
            //         return '<a href="' . route('product.detail', ['id' => $pro->id]) . '" class="btn btn-outline-primary">' . $pro->name . '</a>';
            //     })->implode(' ');
            // })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('age.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('age.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('age', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $age = Age::withTrashed()->find($id);
        if (empty($age)) {
            return response()->json(['success' => 'Tuổi không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại tuổi']);
        }

        $age->products()->each(function ($related) {
             $related->galleries()->delete();
            $related->orderDetails()->where('product_type', 1)->delete();
            $related->reviews()->where('product_type', 1)->delete();
        });
        $age->products()->delete();
        $age->delete();
        return response()->json(['success' => 'Xóa tuổi thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $age = Age::withTrashed()->find($id);
        if (empty($age)) {
            return response()->json(['success' => 'Tuổi không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại tuổi']);
        }
        $age->products()->each(function ($related) {
            $related->galleries()->restore();
            $related->orderDetails()->where('product_type', 1)->restore();
            $related->reviews()->where('product_type', 1)->restore();
            $related->category()->restore();
        });
        $age->products()->restore();
        $age->restore();
        return response()->json(['success' => 'Khôi phục tuổi thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $age = Age::withTrashed()->find($id);
        if (empty($age)) {
            return response()->json(['success' => 'Tuổi không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại tuổi']);
        }
        $age->products()->each(function ($related) {
           $related->galleries()->forceDelete();
                                        $related->orderDetails()->where('product_type', 1)->forceDelete();
                                        $related->reviews()->where('product_type', 1)->forceDelete();
        });
        $age->products()->forceDelete();
        $age->forceDelete();
        return response()->json(['success' => 'Xóa tuổi thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $age = Age::withTrashed()->whereIn('id', $idAll);

        if ($age->count() == 0) {
            return response()->json(['success' => 'Xóa Tuổi thất bại !']);
        }

        $age->each(function ($pro) {
            $pro->products()->each(function ($related) {
               $related->galleries()->delete();
                                        $related->orderDetails()->where('product_type', 1)->delete();
                                        $related->reviews()->where('product_type', 1)->delete();
            });
            $pro->products()->delete();
        });
        $age->delete();
        return response()->json(['success' => 'Xóa tuổi thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $age = Age::withTrashed()->whereIn('id', $idAll);

        if ($age->count() == 0) {
            return response()->json(['success' => 'Khôi phục tuổi thất bại !']);
        }

        $age->each(function ($pro) {
            $pro->products()->each(function ($related) {
                $related->galleries()->restore();
                                        $related->orderDetails()->where('product_type', 1)->restore();
                                        $related->reviews()->where('product_type', 1)->restore();
                                        $related->category()->restore();
            });
            $pro->products()->restore();
        });
        $age->restore();
        return response()->json(['success' => 'Khôi phục tuổi thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $age = Age::withTrashed()->whereIn('id', $idAll);

        if ($age->count() == 0) {
            return response()->json(['success' => 'Xóa tuổi thất bại !']);
        }

        $age->each(function ($pro) {
            $pro->products()->each(function ($related) {
                $related->galleries()->restore();
                                            $related->orderDetails()->where('product_type', 1)->restore();
                                            $related->reviews()->where('product_type', 1)->restore();
                                            $related->category()->restore();
            });
            $pro->products()->forceDelete();
        });
        $age->forceDelete();
        return response()->json(['success' => 'Xóa tuổi thành công !']);
    }
}