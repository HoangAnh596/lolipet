<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class GenderController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.gender.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $age = Gender::select('genders.*');
        return dataTables::of($age)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="' . route('gender.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('gender.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
        return view('admin.gender.add-form');
    }

    public function saveAdd(Request $request, $id = null)
    {

        $message = [
            'gender.required' => "Hãy nhập vào giới tính",
            'gender.unique' => "Giới tính đã tồn tại",
            'gender.regex' => "Giới tính không chứa kí tự đặc biệt và số",
            'gender.min' => "Giới tính ít nhất 3 kí tự",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'gender' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('genders')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Gender::onlyTrashed()
                            ->where('gender', 'like', '%' . $request->gender . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->gender) {
                                return $fail('Giới tính đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('gender.index')]);
        } else {
            $model = new Gender();
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('gender.index'), 'message' => 'Thêm giới tính thành công']);
    }

    public function editForm($id)
    {
        $model = Gender::find($id);
        if (!$model) {
            return redirect()->back();
        }
        return view('admin.gender.edit-form', compact('model'));
    }

    public function saveEdit($id, Request $request)
    {

        $model = Gender::find($id);

        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'gender.required' => "Hãy nhập vào giới tính",
            'gender.unique' => "Giới tính đã tồn tại",
            'gender.regex' => "Giới tính không chứa kí tự đặc biệt và số",
            'gender.min' => "Giới tính ít nhất 3 kí tự",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'gender' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('genders')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Gender::onlyTrashed()
                            ->where('gender', 'like', '%' . $request->gender . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->gender) {
                                return $fail('Giới tính đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('gender.index')]);
        } else {
            $model->fill($request->all());
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('gender.index'), 'message' => 'Sửa giới tính thành công']);
    }

    public function detail($id)
    {
        $model = Gender::find($id);
        $model->load('products');

        $product = Product::all();
        // $category = Category::all();

        return view('admin.gender.detail', compact('product', 'model'));
    }

    public function backup(Request $request)
    {
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.gender.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $gender = Gender::onlyTrashed()->select('genders.*');
        return dataTables::of($gender)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('gender.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('gender.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $gender = Gender::withTrashed()->find($id);
        if (empty($gender)) {
            return response()->json(['success' => 'Giới tính không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại giới tính']);
        }

        $gender->products()->each(function ($related) {
            $related->galleries()->delete();
            $related->orderDetails()->where('product_type', 1)->delete();
            $related->reviews()->where('product_type', 1)->delete();
        });
        $gender->products()->delete();
        $gender->delete();
        return response()->json(['success' => 'Xóa giới tính thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function restore($id)
    {
        $gender = Gender::withTrashed()->find($id);
        if (empty($gender)) {
            return response()->json(['success' => 'Giới tính không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại giới tính']);
        }
        $gender->products()->each(function ($related) {
            $related->galleries()->restore();
            $related->orderDetails()->where('product_type', 1)->restore();
            $related->reviews()->where('product_type', 1)->restore();
            $related->category()->restore();
        });
        $gender->products()->restore();
        $gender->restore();
        return response()->json(['success' => 'Khôi phục giới tính thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function delete($id)
    {
        $gender = Gender::withTrashed()->find($id);
        if (empty($gender)) {
            return response()->json(['success' => 'Giới tính không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại giới tính']);
        }
        $gender->products()->each(function ($related) {
            $related->galleries()->forceDelete();
            $related->orderDetails()->where('product_type', 1)->forceDelete();
            $related->reviews()->where('product_type', 1)->forceDelete();
        });
        $gender->products()->forceDelete();
        $gender->forceDelete();
        return response()->json(['success' => 'Xóa giới tính thành công !', 'undo' => "Hoàn tác thành công !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $gender = Gender::withTrashed()->whereIn('id', $idAll);

        if ($gender->count() == 0) {
            return response()->json(['success' => 'Xóa giới tính thất bại !']);
        }

        $gender->each(function ($pro) {
            $pro->products()->each(function ($related) {
                $related->galleries()->delete();
                $related->orderDetails()->where('product_type', 1)->delete();
                $related->reviews()->where('product_type', 1)->delete();
            });
            $pro->products()->delete();
        });
        $gender->delete();
        return response()->json(['success' => 'Xóa giới tính thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $gender = Gender::withTrashed()->whereIn('id', $idAll);

        if ($gender->count() == 0) {
            return response()->json(['success' => 'Khôi phục giới tính thất bại !']);
        }

        $gender->each(function ($pro) {
            $pro->products()->each(function ($related) {
                $related->galleries()->restore();
                $related->orderDetails()->where('product_type', 1)->restore();
                $related->reviews()->where('product_type', 1)->restore();
                $related->category()->restore();
            });
            $pro->products()->restore();
        });
        $gender->restore();
        return response()->json(['success' => 'Khôi phục giới tính thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $gender = Gender::withTrashed()->whereIn('id', $idAll);

        if ($gender->count() == 0) {
            return response()->json(['success' => 'Xóa giới tính thất bại !']);
        }

        $gender->each(function ($pro) {
            $pro->products()->each(function ($related) {
                $related->galleries()->forceDelete();
                $related->orderDetails()->where('product_type', 1)->forceDelete();
                $related->reviews()->where('product_type', 1)->forceDelete();
            });
            $pro->products()->forceDelete();
        });
        $gender->forceDelete();
        return response()->json(['success' => 'Xóa giới tính thành công !']);
    }
}