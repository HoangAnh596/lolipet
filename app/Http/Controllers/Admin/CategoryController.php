<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Product;
use App\Models\Breed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;
use App\Models\Accessory;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.category.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $category = Category::select('categories.*')->with('categoryType');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('category_type_id', function ($row, $order) {
                return $row->orderBy('category_type_id', $order);
            })
            ->addColumn('category_type_id', function ($row) {
                return $row->categoryType->name;
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="' . route('category.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('category.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
        $categoryType = CategoryType::all();
        return view('admin.category.add-form', compact('categoryType'));
    }

    public function saveAdd(Request $request, $id = null)
    {

        $message = [
            'name.required' => "H??y nh???p v??o t??n danh m???c",
            'name.unique' => "T??n danh m???c ???? t???n t???i",
            'name.regex' => "T??n danh m???c kh??ng ch???a k?? t??? ?????c bi???t v?? s???",
            'name.min' => "T??n danh m???c ??t nh???t 3 k?? t???",
            'slug.required' => 'Nh???p t??n danh m???c ????? slug',
            'category_type_id.required' => "H??y ch???n lo???i danh m???c",
            'show_slide.required' => "H??y ch???n tr???ng th??i danh m???c",
            'show_slide.numeric' => "Tr???ng th??i danh m???c ph???i l?? ki???u s???",
            'uploadfile.mimes' => 'File ???nh kh??ng ????ng ?????nh d???ng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ???nh kh??ng ???????c qu?? 2MB',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('categories')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Category::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Danh m???c ???? t???n t???i trong th??ng r??c .
                             Vui l??ng nh???p th??ng tin m???i ho???c x??a d??? li???u trong th??ng r??c');
                            }
                        }
                    }
                ],
                'slug' => 'required',
                'category_type_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $categoryId = CategoryType::where('id', $request->category_type_id)
                            ->first();
                        if ($categoryId == '') {
                            return $fail('Lo???i danh m???c kh??ng t???n t???i');
                        }
                    },
                ],
                'show_slide' => 'required|numeric',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('category.index')]);
        } else {
            $model = new Category();
            $model->fill($request->all());
            if ($request->has('uploadfile')) {
                $model->image = $request->file('uploadfile')->storeAs(
                    'uploads/categories/' . $model->id,
                    uniqid() . '-' . $request->uploadfile->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('category.index'), 'message' => 'Th??m s???n ph???m th??nh c??ng']);
    }

    public function editForm($id)
    {
        $model = Category::find($id);
        $categoryType = CategoryType::all();
        if (!$model) {
            return redirect()->back();
        }
        return view('admin.category.edit-form', compact('model', 'categoryType'));
    }

    public function saveEdit($id, Request $request)
    {
        $model = Category::find($id);
        if (!$model) {
            return redirect()->back();
        }

        $message = [
            'name.required' => "H??y nh???p v??o t??n danh m???c",
            'name.unique' => "T??n danh m???c ???? t???n t???i",
            'name.regex' => "T??n danh m???c kh??ng ch???a k?? t??? ?????c bi???t v?? s???",
            'name.min' => "T??n danh m???c ??t nh???t 3 k?? t???",
            'slug.required' => 'Nh???p t??n danh m???c ????? slug',
            'category_type_id.required' => "H??y ch???n danh m???c",
            'show_slide.required' => "H??y ch???n tr???ng th??i danh m???c",
            'show_slide.numeric' => "Tr???ng th??i danh m???c ph???i l?? ki???u s???",
            'uploadfile.mimes' => 'File ???nh kh??ng ????ng ?????nh d???ng (jpg, bmp, png, jpeg)',
            'uploadfile.max' => 'File ???nh kh??ng ???????c qu?? 2MB',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('categories')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Category::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Danh m???c ???? t???n t???i trong th??ng r??c .
                             Vui l??ng nh???p th??ng tin m???i ho???c x??a d??? li???u trong th??ng r??c');
                            }
                        }
                    }
                ],
                'category_type_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $categoryId = CategoryType::where('id', $request->category_type_id)
                            ->first();
                        if ($categoryId == '') {
                            return $fail('Lo???i danh m???c kh??ng t???n t???i');
                        }
                    },
                ],
                'slug' => 'required',
                'show_slide' => 'required|numeric',
                'uploadfile' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('category.index')]);
        } else {
            $model->fill($request->all());
            if ($request->has('uploadfile')) {
                $model->image = $request->file('uploadfile')->storeAs(
                    'uploads/categories/' . $model->id,
                    uniqid() . '-' . $request->uploadfile->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('category.index'), 'message' => 'S???a s???n ph???m th??nh c??ng']);
    }

    public function detail($id)
    {
        $category = Category::find($id);
        if (!$category) {
            $category = Category::onlyTrashed()->find($id);
            $category->load('products', 'breeds');
        }
        $category->load('products', 'breeds');

        $product = Product::all();
        $breed = Breed::all();

        return view('admin.category.detail', compact('category', 'product', 'breed'));
    }

    public function backUp()
    {
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.category.back-up', compact('admin'));
    }

    public function getBackUp(Request $request)
    {
        $category = Category::onlyTrashed()->select('categories.*');
        return dataTables::of($category)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('category_type_id', function ($row, $order) {
                return $row->orderBy('category_type_id', $order);
            })
            ->addColumn('category_type_id', function ($row) {
                return $row->categoryType->name;
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('category.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('category.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
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
        $category = Category::withTrashed()->find($id);

        if ($category->count() == 0) {
            return response()->json(['success' => 'X??a danh m???c th???t b???i !']);
        }
        if($category->category_type_id == 1){
            $pro = $category->products();
            $pro->each(function ($related) {
                $related->galleries()->delete();
                $related->orderDetails()->where('product_type', 1)->delete();
                $related->reviews()->where('product_type', 1)->delete();
            });
            $pro->delete();
        }
        if($category->category_type_id == 2){
            $category->accessory()->each(function ($related) {
                $related->galleries()->delete();
                $related->orderDetails()->where('product_type', 2)->delete();
                $related->reviews()->where('product_type', 2)->delete();
            });
            $category->accessory()->delete();
        }
        $category->delete();

        return response()->json(['success' => 'X??a danh m???c th??nh c??ng !', 'undo' => "Ho??n t??c th??nh c??ng !"]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category->count() == 0) {
            return response()->json(['success' => 'S???n ph???m kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i danh muc']);
        }

        if($category->category_type_id == 1){
            $pro = $category->products();
            $pro->each(function ($related) {
                $related->galleries()->restore();
                                    $related->orderDetails()->where('product_type', 1)->restore();
                                    $related->reviews()->where('product_type', 1)->restore();
                                    $related->category()->restore();
            });
            $pro->restore();
        }
        if($category->category_type_id == 2){
            $category->accessory()->each(function ($related) {
                $related->galleries()->restore();
                                    $related->orderDetails()->where('product_type', 2)->restore();
                                    $related->reviews()->where('product_type', 2)->restore();
                                    $related->category()->restore();
            });
            $category->accessory()->restore();
        }
        
        $category->restore();

        return response()->json(['success' => 'Kh??i ph???c th?? c??ng th??nh c??ng !']);
    }

    public function delete($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category->count() == 0) {
            return response()->json(['success' => 'S???n ph???m kh??ng t???n t???i !', 'undo' => "Ho??n t??c th???t b???i !", "empty" => 'Ki???m tra l???i danh m???c']);
        }

        if($category->category_type_id == 1){
            $pro = $category->products();
            $pro->each(function ($related) {
                $related->galleries()->forceDelete();
                                    $related->orderDetails()->where('product_type', 1)->forceDelete();
                                    $related->reviews()->where('product_type', 1)->forceDelete();
            });
            $pro->forceDelete();
        }
        if($category->category_type_id == 2){
            $category->accessory()->each(function ($related) {
                $related->galleries()->forceDelete();
                                    $related->orderDetails()->where('product_type', 2)->forceDelete();
                                    $related->reviews()->where('product_type', 2)->forceDelete();
            });
            $category->accessory()->forceDelete();
        }
        $category->forceDelete();

        return response()->json(['success' => 'X??a danh m???c th??nh c??ng !']);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $category = Category::withTrashed()->whereIn('id', $idAll);

        if ($category->count() == 0) {
            return response()->json(['success' => 'X??a danh m???c th???t b???i !']);
        }

        $category->each(function ($product) {
            if($product->category_type_id == 1){
                $pro = $product->products();
                $pro->each(function ($related) {
                     $related->galleries()->delete();
                                        $related->orderDetails()->where('product_type', 1)->delete();
                                        $related->reviews()->where('product_type', 1)->delete();
                });
                $pro->delete();
            }
            if($product->category_type_id == 2){
                $product->accessory()->each(function ($related) {
                     $related->galleries()->delete();
                                        $related->orderDetails()->where('product_type', 2)->delete();
                                        $related->reviews()->where('product_type', 2)->delete();
                });
                $product->accessory()->delete();
            }
        });
        $category->delete();

        return response()->json(['success' => 'X??a danh m???c th??nh c??ng !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $category = Category::withTrashed()->whereIn('id', $idAll);

        if ($category->count() == 0) {
            return response()->json(['success' => 'X??a danh m???c th???t b???i !']);
        }

        $category->each(function ($product) {
            if($product->category_type_id == 1){
                $pro = $product->products();
                $pro->each(function ($related) {
                    $related->galleries()->restore();
                                        $related->orderDetails()->where('product_type', 1)->restore();
                                        $related->reviews()->where('product_type', 1)->restore();
                                        $related->category()->restore();
                });
                $pro->restore();
            }
            if($product->category_type_id == 2){
                $product->accessory()->each(function ($related) {
                   $related->galleries()->restore();
                                        $related->orderDetails()->where('product_type', 2)->restore();
                                        $related->reviews()->where('product_type', 2)->restore();
                                        $related->category()->restore();
                });
                $product->accessory()->restore();
            }
        });
        $category->restore();

        return response()->json(['success' => 'Kh??i ph???c danh m???c th??nh c??ng !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $category = Category::withTrashed()->whereIn('id', $idAll);

        if ($category->count() == 0) {
            return response()->json(['success' => 'X??a danh m???c th???t b???i !']);
        }

        $category->each(function ($product) {
           if($product->category_type_id == 1){
                $pro = $product->products();
                $pro->each(function ($related) {
                     $related->galleries()->forceDelete();
                                        $related->orderDetails()->where('product_type', 1)->forceDelete();
                                        $related->reviews()->where('product_type', 1)->forceDelete();
                });
                $pro->forceDelete();
            }
            if($product->category_type_id == 2){
                $product->accessory()->each(function ($related) {
                    $related->galleries()->forceDelete();
                                        $related->orderDetails()->where('product_type', 2)->forceDelete();
                                        $related->reviews()->where('product_type', 2)->forceDelete();
                });
                $product->accessory()->forceDelete();
            }
        });
        $category->forceDelete();

        return response()->json(['success' => 'X??a danh m???c danh m???c th??nh c??ng !']);
    }
}