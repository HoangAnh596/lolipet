<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\DiscountType;
use App\Models\Breed;
use App\Models\Gender;
use App\Models\Age;
use App\Models\ProductGallery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $gender = Gender::all();
        $breed = Breed::all();
        $age = Age::all();
        $admin = Auth::user()->hasanyrole('Admin|Manager');

        return view('admin.product.index', compact('categories', 'gender', 'breed', 'age', 'admin'));
    }

    public function getData(Request $request)
    {
        $pet = Product::select('products.*')->with('category');
        return dataTables::of($pet)
            //thêm id vào tr trong datatable
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('category_id', function ($row, $order) {
                return $row->orderBy('category_id', $order);
            })
            ->orderColumn('status', function ($row, $order) {
                return $row->orderBy('status', $order);
            })
            ->addColumn('category_id', function ($row) {
                return $row->category->name;
            })
            ->addColumn('status', function ($row) {
                    return $row->quantity;
            })
            ->addColumn('action', function ($row) {
                if(Auth::user()->hasPermissionTo('edit products') && Auth::user()->hasPermissionTo('delete products')){
                    return '
                    <span class="float-right">
                        <a href="' . route('product.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                        <a  class="btn btn-success" href="' . route('product.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                        <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('product.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                    </span>';
                }elseif(Auth::user()->hasPermissionTo('edit products')){
                    return '
                    <span class="float-right">
                        <a href="' . route('product.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                        <a  class="btn btn-success" href="' . route('product.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    </span>';
                }elseif(Auth::user()->hasPermissionTo('delete products')){
                    return '
                    <span class="float-right">
                        <a href="' . route('product.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                        <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('product.remove', ["id" => $row->id]) . '" onclick="deleteData(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                    </span>';
                }else{
                    return '
                    <span class="float-right">
                        <a href="' . route('product.detail', ['id' => $row->id]) . '" class="btn btn-outline-info"><i class="far fa-eye"></i></a>
                    </span>';
                }
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status') == '0' || $request->get('status') == '1') {
                    $instance->where('status', $request->get('status'));
                }

                if ($request->get('cate') != '') {
                    $instance->where('category_id', $request->get('cate'));
                }

                if ($request->get('gender') != '') {
                    $instance->where('gender_id', $request->get('gender'));
                }

                if ($request->get('breed') != '') {
                    $instance->where('breed_id', $request->get('breed'));
                }

                if ($request->get('age') != '') {
                    $instance->where('age_id', $request->get('age'));
                }

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('description', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        $category = Category::all();
        $breed = Breed::all();
        $gender = Gender::all();
        $discountType = DiscountType::all();
        $age = Age::all();
        return view('admin.product.add-form', compact('category', 'breed', 'gender', 'age', 'discountType'));
    }

    public function saveAdd(Request $request, $id = null)
    {

        $message = [
            'name.required' => "Hãy nhập vào tên thú cưng",
            'name.unique' => "Tên thú cưng đã tồn tại",
            'name.regex' => "Tên thú cưng không chứa kí tự đặc biệt và số",
            'name.min' => "Tên thú cưng ít nhất 3 kí tự",
            'discount.regex' => "Giảm giá không chứa kí tự đặc biệt và chữ cái",
            'discount.min' => "Giảm giá bé nhất là 1",
            'category_id.required' => "Hãy chọn danh mục",
            'price.required' => "Hãy nhập giá thú cưng",
            'price.numeric' => "Giá thú cưng phải là số",
            'status.required' => "Hãy chọn trạng thái thú cưng",
            'status.numeric' => "Trạng thái thú cưng phải là số",
            'age_id.required' => "Hãy nhập tuổi thú cưng",
            'quantity.required' => "Hãy nhập số lượng thú cưng",
            'quantity.numeric' => "Số lượng thú cưng phải là số",
            'discount_start_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'discount_end_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'discount_end_date.after' => 'Ngày kết thúc giảm giá không được trước ngày bắt đầu',
            'weight.required' => "Hãy nhập cân nặng thú cưng",
            'weight.numeric' => "Cân nặng thú cưng phải là số",
            'breed_id.required' => "Hãy chọn giống loài",
            'gender_id.required' => "Hãy chọn giới tính thú cưng",
            'image.required' => 'Hãy chọn ảnh thú cưng',
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
            'galleries.*.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'galleries.*.max' => 'File ảnh không được quá 2MB',
            'slug.required' => "Nhập tên sản phẩm để tạo slug",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('products')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Product::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Tên thú cưng đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },

                ],
                'discount' => [
                    'nullable',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_a-zA-Z]*$/',
                    'min:1',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value > 100 && $request->discount_type == 2) {
                            return $fail('Giảm giá không vượt quá 100%');
                        }
                    },
                ],
                'slug' => 'required',
                'discount_start_date' => 'nullable|date_format:Y-m-d H:i',
                'discount_end_date' => 'nullable|date_format:Y-m-d H:i|after:discount_start_date',
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

                        if ($request->breed_id) {
                            $breed = Breed::where('id', $request->breed_id)->first();
                            if ($breed->category_id != $categoryId->id) {
                                return $fail('Danh mục thú cưng không thuộc giống loài');
                            }
                        }
                    },
                ],
                'discount_type' => [
                    'nullable',
                    function ($attribute, $value, $fail) use ($request) {
                        $discountType = DiscountType::where('id', $request->discount_type)->first();
                        if ($discountType == '') {
                            return $fail('Kiểu giảm giá không tồn tại');
                        }
                    },
                ],
                'gender_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $gender = Gender::where('id', $value)->first();
                        if ($gender == '') {
                            return $fail('Giới tính thú cưng không tồn tại');
                        }
                    },
                ],
                'price' => 'required|numeric',
                'status' => 'required|numeric',
                'age_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $age = Age::where('id', $value)->first();
                        if ($age == '') {
                            return $fail('Tuổi thú cưng không tồn tại');
                        }
                    },
                ],
                'quantity' => 'required|numeric',
                'weight' => 'required|numeric',
                'breed_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $breed = Breed::where('id', $value)->first();
                        if ($breed == '') {
                            return $fail('Giống loài thú cưng không tồn tại');
                        }
                    },
                ],
                'image' => 'required|mimes:jpg,bmp,png,jpeg|max:2048',
                'galleries.*' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('product.index')]);
        } else {
            $model = new Product();
            $model->user_id = Auth::id();
            $model->discount_start_date = Carbon::parse($request->discount_start_date)->format('Y-m-d H:i');
            $model->discount_end_date = Carbon::parse($request->discount_end_date)->format('Y-m-d H:i');
            $model->fill($request->all());
            if ($request->has('image')) {
                $model->image = $request->file('image')->storeAs(
                    'uploads/products/',
                    uniqid() . '-' . $request->image->getClientOriginalName()
                );
            }
            $model->save();

            if ($request->has('galleries')) {
                foreach ($request->galleries as $i => $item) {
                    $galleryObj = new ProductGallery();
                    $galleryObj->product_id = $model->id;
                    $galleryObj->order_no = $i + 1;
                    $galleryObj->image_url = $item->storeAs(
                        'uploads/gallery/' . $model->id,
                        uniqid() . '-' . $item->getClientOriginalName()
                    );
                    $galleryObj->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('product.index'), 'message' => 'Thêm sản phẩm thành công']);
}

    public function editForm($id)
    {
        $model = Product::find($id);
        if (!$model) {
            return redirect()->back();
        }

        $category = Category::all();
        $breed = Breed::all();
        $gender = Gender::all();
        $age = Age::all();
        $discountType = DiscountType::all();

        $model->load('category', 'breed', 'gender', 'age');
        return view('admin.product.edit-form', compact('model', 'category', 'breed', 'gender', 'age', 'discountType'));
    }

    public function saveEdit($id, Request $request)
    {
        $model = Product::find($id);

        if (!$model) {
            return redirect()->back()->with('BadState', 'Sản phẩm có id là ' . $id . 'không tồn tại');
        }

        $message = [
            'name.required' => "Hãy nhập vào tên danh mục",
            'name.unique' => "Tên thú cưng đã tồn tại",
            'name.regex' => "Tên thú cưng không chứa kí tự đặc biệt và số",
            'name.min' => "Tên thú cưng ít nhất 3 kí tự",
            'discount.regex' => "Giảm giá không chứa kí tự đặc biệt và chữ cái",
            'discount.min' => "Giảm giá bé nhất là 1",
            'category_id.required' => "Hãy chọn danh mục",
            'price.required' => "Hãy nhập giá thú cưng",
            'price.numeric' => "Giá thú cưng phải là số",
            'status.required' => "Hãy chọn trạng thái thú cưng",
            'status.numeric' => "Trạng thái thú cưng phải là số",
            'age_id.required' => "Hãy nhập tuổi thú cưng",
            'quantity.required' => "Hãy nhập số lượng thú cưng",
            'quantity.numeric' => "Số lượng thú cưng phải là số",
            'discount_start_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'discount_end_date.date_format' => 'Ngày tháng giảm giá không hợp lệ',
            'discount_end_date.after' => 'Ngày kết thúc giảm giá không được trước ngày bắt đầu',
            'weight.required' => "Hãy nhập cân nặng thú cưng",
            'weight.numeric' => "Cân nặng thú cưng phải là số",
            'breed_id.required' => "Hãy chọn giống loài",
            'gender_id.required' => "Hãy chọn giới tính thú cưng",
            'image.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ảnh không được quá 2MB',
            'galleries.*.mimes' => 'File ảnh không đúng định dạng (jpg, bmp, png, jpeg)',
            'galleries.*.max' => 'File ảnh không được quá 2MB',
            'slug.required' => "Nhập tên sản phẩm để tạo slug",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_0-9]*$/',
                    'min:3',
                    Rule::unique('products')->ignore($id)->whereNull('deleted_at'),
                    function ($attribute, $value, $fail) use ($request) {
                        $dupicate = Product::onlyTrashed()
                            ->where('name', 'like', '%' . $request->name . '%')
                            ->first();
                        if ($dupicate) {
                            if ($value == $dupicate->name) {
                                return $fail('Tên thú cưng đã tồn tại trong thùng rác .
                                 Vui lòng nhập thông tin mới hoặc xóa dữ liệu trong thùng rác');
                            }
                        }
                    },
                ],
                'discount' => [
                    'nullable',
                    'regex:/^[^\-\!\[\]\{\}\"\'\>\<\%\^\*\?\/\\\|\,\;\:\+\=\(\)\@\$\&\!\.\#\_a-zA-Z]*$/',
                    'min:1',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value > 100 && $request->discount_type == 2) {
                            return $fail('Giảm giá không vượt quá 100%');
                        }
                    },
                ],
                'discount_type' => [
                    'nullable',
                    function ($attribute, $value, $fail) use ($request) {
                        $discountType = DiscountType::where('id', $request->discount_type)->first();
                        if ($discountType == '') {
                            return $fail('Kiểu giảm giá không tồn tại');
                        }
                    },
                ],
                'slug' => 'required',
                'discount_start_date' => 'nullable|date_format:Y-m-d H:i',
                'discount_end_date' => 'nullable|date_format:Y-m-d H:i|after:discount_start_date',
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
                        if ($request->breed_id) {
                            $breed = Breed::where('id', $request->breed_id)->first();
                            if ($breed->category_id != $categoryId->id) {
                                return $fail('Danh mục thú cưng không thuộc giống loài');
                            }
                        }
                    },
                ],
                'gender_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $gender = Gender::where('id', $value)->first();
                        if ($gender == '') {
                            return $fail('Giới tính thú cưng không tồn tại');
                        }
                    },
                ],
                'price' => 'required|numeric',
                'status' => 'required|numeric',
                'age_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $age = Age::where('id', $value)->first();
                        if ($age == '') {
                            return $fail('Tuổi thú cưng không tồn tại');
                        }
                    },
                ],
                'quantity' => 'required|numeric',
                'weight' => 'required|numeric',
                'breed_id' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $breed = Breed::where('id', $value)->first();
                        if ($breed == '') {
                            return $fail('Giống loài thú cưng không tồn tại');
                        }
                    },
                ],
                'image' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'galleries.*' => 'mimes:jpg,bmp,png,jpeg|max:2048'
            ],
            $message
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('product.index')]);
        } else {
            $model->user_id = Auth::id();
            $model->fill($request->all());
            if ($request->image != '') {
                Storage::delete($model->image);
                $model->image = $request->file('image')->storeAs(
                    'uploads/products/',
                    uniqid() . '-' . $request->image->getClientOriginalName()
                );
            }
            $model->save();

            /* gallery
         * xóa gallery đc mark là bị xóa đi
        */
            if ($request->has('removeGalleryIds')) {
                $strIds = rtrim($request->removeGalleryIds, '|');
                $lstIds = explode('|', $strIds);
                // xóa các ảnh vật lý
                $removeList = ProductGallery::whereIn('id', $lstIds)->get();
                foreach ($removeList as $gl) {
                    Storage::delete($gl->url);
                }
                ProductGallery::whereIn('id', $lstIds)->forceDelete();
            }

            // lưu mới danh sách gallery
            if ($request->has('galleries')) {
                foreach ($request->galleries as $i => $item) {
                    $galleryObj = new ProductGallery();
                    $galleryObj->product_id = $model->id;
                    $galleryObj->order_no = $i + 1;
                    $galleryObj->image_url = $item->storeAs(
                        'uploads/products/galleries/' . $model->id,
                        uniqid() . '-' . $item->getClientOriginalName()
                    );
                    $galleryObj->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('product.index'), 'message' => 'Sửa sản phẩm thành công']);
    }

    public function detail($id)
    {
$model = Product::find($id);

        if (!$model) {
            return redirect()->back()->with('BadState', 'Sản phẩm có id là ' . $id . ' không tồn tại');
        }


        $model->load('category', 'breed', 'gender');
        $category = Category::all();
        $breed = Breed::all();
        $gender = Gender::all();

        return view('admin.product.detail', compact('category', 'model', 'breed', 'gender'));
    }

    public function backUp()
    {
        $categories = Category::all();
        $gender = Gender::all();
        $breed = Breed::all();
        $age = Age::all();
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.product.back-up', compact('categories', 'gender', 'breed', 'age', 'admin'));
    }

    public function getBackUp(Request $request)
    {
        $product = Product::onlyTrashed()->select('products.*');
        return dataTables::of($product)
            //thêm id vào tr trong datatable
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->orderColumn('category_id', function ($row, $order) {
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
                    <a  class="btn btn-success" href="javascript:void(0);" id="restoreUrl' . $row->id . '" data-url="' . route('product.restore', ["id" => $row->id]) . '" onclick="restoreData(' . $row->id . ')"><i class="fas fa-trash-restore"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('product.delete', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status') == '0' || $request->get('status') == '1' || $request->get('status') == '3') {
$instance->where('status', $request->get('status'));
                }

                if ($request->get('cate') != '') {
                    $instance->where('category_id', $request->get('cate'));
                }

                if ($request->get('gender') != '') {
                    $instance->where('gender_id', $request->get('gender'));
                }

                if ($request->get('breed') != '') {
                    $instance->where('breed_id', $request->get('breed'));
                }

                if ($request->get('age') != '') {
                    $instance->where('age_id', $request->get('age'));
                }

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orWhere('description', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action', 'checkbox'])
            ->make(true);
    }

    public function remove($id)
    {
        $product = Product::withTrashed()->find($id);

        if ($product->count() == 0) {
            return response()->json(['success' => 'Xóa thú cưng thất bại !', 'undo' => "Hoàn tác thất bại !"]);
        }

        $product->galleries()->delete();
        $product->orderDetails()->where('product_type', 1)->delete();
        $product->reviews()->where('product_type', 1)->delete();
        $product->delete();

        return response()->json(['success' => 'Xóa thú cưng thành công !']);
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->find($id);

        if ($product->count() == 0) {
            return response()->json(['success' => 'Thú cưng không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại thú cưng']);
        }

        $product->galleries()->restore();
        $product->category()->restore();
        $product->orderDetails()->where('product_type', 1)->restore();
        $product->reviews()->where('product_type', 1)->restore();
        $product->restore();

        return response()->json(['success' => 'Khôi phục thú cưng thành công !']);
    }

    public function delete($id)
    {
        $product = Product::withTrashed()->find($id);

        if ($product->count() == 0) {
            return response()->json(['success' => 'thú cưng không tồn tại !', 'undo' => "Hoàn tác thất bại !", "empty" => 'Kiểm tra lại thú cưng']);
        }

        $product->galleries()->forceDelete();
        $product->orderDetails()->where('product_type', 1)->forceDelete();
        $product->reviews()->where('product_type', 1)->forceDelete();
        $product->forceDelete();

        return response()->json(['success' => 'Xóa thú cưng thành công !']);
    }

    public function store(Request $request)
    {
        if($request->has('file')){

           $extension = File::extension($request->file->getClientOriginalName());
           if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                $file = $request->file('file')->store('public/excel');
                $import = new ProductImport;
                $import->import($file);
                $fail = $import->failures();
                if ($fail->isNotEmpty()) {
                    return view('admin.product.error', compact('fail'));
                }
                Excel::import(new ProductImport, $file);
        
                return back()->with('congratulation!');
           }else {
              return back()->with('BadState','File import phải là phải có đuôi xlsx,csv');
           }
        }else{
            return back()->with('BadState','Chưa có file import!');
        }
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $product = Product::withTrashed()->whereIn('id', $idAll);

        if ($product->count() == 0) {
            return response()->json(['success' => 'Xóa thú cưng thất bại !']);
        }

        $product->each(function ($related) {
            $related->galleries()->delete();
            $related->orderDetails()->where('product_type', 1)->delete();
            $related->reviews()->where('product_type', 1)->delete();
        });
        $product->delete();

        return response()->json(['success' => 'Xóa sản phẩm thành công !']);
    }

    public function restoreMultiple(Request $request)
    {
        $idAll = $request->allId;
        $product = Product::withTrashed()->whereIn('id', $idAll);

        if ($product->count() == 0) {
            return response()->json(['success' => 'Xóa thú cưng thất bại !']);
        }

        $product->each(function ($related) {
            $related->galleries()->restore();
            $related->category()->restore();
            $related->orderDetails()->where('product_type', 1)->restore();
            $related->reviews()->where('product_type', 1)->restore();
        });
        $product->restore();

        return response()->json(['success' => 'Khôi phục thú cưng thành công !']);
    }

    public function deleteMultiple(Request $request)
    {
        $idAll = $request->allId;
        $product = Product::withTrashed()->whereIn('id', $idAll);

        if ($product->count() == 0) {
            return response()->json(['success' => 'Xóa thú cưng thất bại !']);
        }

        $product->each(function ($related) {
            $related->galleries()->forceDelete();
            $related->orderDetails()->where('product_type', 1)->forceDelete();
            $related->reviews()->where('product_type', 1)->forceDelete();
        });
        $product->forceDelete();

        return response()->json(['success' => 'Xóa thú cưng thành công !']);
    }
}