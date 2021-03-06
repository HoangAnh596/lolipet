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
            'gender.required' => "H??y nh???p v??o gi???i t??nh",
            'gender.unique' => "Gi???i t??nh ???? t???n t???i",
            'gender.regex' => "Gi???i t??nh kh??ng ch???a k?? t??? ?????c bi???t v?? s???",
            'gender.min' => "Gi???i t??nh ??t nh???t 3 k?? t???",
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
                                return $fail('Gi???i t??nh ???? t???n t???i trong th??ng r??c .
                                 Vui l??ng nh???p th??ng tin m???i ho???c x??a d??? li???u trong th??ng r??c');
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
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('gender.index'), 'message' => 'Th??m gi???i t??nh th??nh c??ng']);
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
            'gender.required' => "H??y nh???p v??o gi???i t??nh",
            'gender.unique' => "Gi???i t??nh ???? t???n t???i",
            'gender.regex' => "Gi???i t??nh kh??ng ch???a k?? t??? ?????c bi???t v?? s???",
            'gender.min' => "Gi???i t??nh ??t nh???t 3 k?? t???",
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
                                return $fail('Gi???i t??nh ???? t???n t???i trong th??ng r??c .
                                 Vui l??ng nh???p th??ng tin m???i ho???c x??a d??? li???u trong th??ng r??c');
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
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('gender.index'), 'message' => 'S???a gi???i t??nh th??nh c??ng']);
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
            return response()->json(['success' => 'Gi???i t??nh kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i gi???i t??nh']);
        }

        $gender->products()->each(function ($related) {
            $related->galleries()->delete();
            $related->orderDetails()->where('product_type', 1)->delete();
            $related->reviews()->where('product_type', 1)->delete();
        });
        $gender->products()->delete();
        $gender->delete();
        return response()->json(['success' => 'X??a gi???i t??nh th??nh c??ng !', 'undo' => "Ho??n t??c th??nh c??ng !"]);
    }

    public function restore($id)
    {
        $gender = Gender::withTrashed()->find($id);
        if (empty($gender)) {
            return response()->json(['success' => 'Gi???i t??nh kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i gi???i t??nh']);
        }
        $gender->products()->each(function ($related) {
            $related->galleries()->restore();
            $related->orderDetails()->where('product_type', 1)->restore();
            $related->reviews()->where('product_type', 1)->restore();
            $related->category()->restore();
        });
        $gender->products()->restore();
        $gender->restore();
        return response()->json(['success' => 'Kh??i ph???c gi???i t??nh th??nh c??ng !', 'undo' => "Ho??n t??c th??nh c??ng !"]);
    }

    public function delete($id)
    {
        $gender = Gender::withTrashed()->find($id);
        if (empty($gender)) {
            return response()->json(['success' => 'Gi???i t??nh kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i gi???i t??nh']);
        }
        $gender->products()->each(function ($related) {
            $related->galleries()->forceDelete();
            $related->orderDetails()->where('product_type', 1)->forceDelete();
            $related->reviews()->where('product_type', 1)->forceDelete();
        });
        $gender->products()->forceDelete();
        $gender->forceDelete();
        return response()->json(['success' => 'X??a gi???i t??nh th??nh c??ng !', 'undo' => "Ho??n t??c th??nh c??ng !"]);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $gender = Gender::withTrashed()->whereIn('id', $idAll);

        if ($gender->count() == 0) {
            return response()->json(['success' => 'X??a gi???i t??nh th???t b???i !']);
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
        return response()->json(['success' => 'X??a gi???i t??nh th??nh c??ng !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $gender = Gender::withTrashed()->whereIn('id', $idAll);

        if ($gender->count() == 0) {
            return response()->json(['success' => 'Kh??i ph???c gi???i t??nh th???t b???i !']);
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
        return response()->json(['success' => 'Kh??i ph???c gi???i t??nh th??nh c??ng !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $gender = Gender::withTrashed()->whereIn('id', $idAll);

        if ($gender->count() == 0) {
            return response()->json(['success' => 'X??a gi???i t??nh th???t b???i !']);
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
        return response()->json(['success' => 'X??a gi???i t??nh th??nh c??ng !']);
    }
}