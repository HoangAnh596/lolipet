<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class SlideController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::user()->hasanyrole('Admin|Manager');
        return view('admin.slide.index', compact('admin'));
    }

    public function getData(Request $request)
    {
        $slide = Slide::select('slides.*');
        return dataTables::of($slide)
            ->setRowId(function ($row) {
                return $row->id;
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="checkPro" class="checkPro" value="' . $row->id . '" />';
            })
            ->addColumn('image', function ($row) {
                return '<img width="120" class="thumbail" src="' . asset('storage/' . $row->image) . '"/>';
            })
            ->addColumn('action', function ($row) {
                return '
                <span class="float-right">
                    <a  class="btn btn-success" href="' . route('slide.edit', ["id" => $row->id]) . '"><i class="far fa-edit"></i></a>
                    <a class="btn btn-danger" href="javascript:void(0);" id="deleteUrl' . $row->id . '" data-url="' . route('slide.remove', ["id" => $row->id]) . '" onclick="removeForever(' . $row->id . ')"><i class="far fa-trash-alt"></i></a>
                </span>';
            })
            ->filter(function ($instance) use ($request) {

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('url', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['image', 'action', 'checkbox'])
            ->make(true);
    }

    public function addForm()
    {
        return view("admin.slide.add-form");
    }

    public function saveAdd(Request $request, $id = null)
    {
        $message = [
            'image.required' => "H??y ch???n ???nh cho slide",
            'image.*.mimes' => 'File ???nh kh??ng ????ng ?????nh d???ng (jpg, bmp, png, jpeg)',
            'image.*.max' => 'File ???nh kh??ng ???????c qu?? 2MB',
            'status.required' => "H??y ch???n tr???ng th??i",
            'url.url' => "???????ng d???n kh??ng h???p l???"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'url' => 'nullable|url',
                'image' => 'required',
                'image.*' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'status' => 'required'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('slide.index')]);
        } else {

            // upload ???nh
            if ($request->has('image')) {
                foreach ($request->image as $item) {
                    $model = new Slide();
                    $model->fill($request->all());
                    $model->user_id = Auth::id();
                    $model->image = $item->storeAs(
                        'uploads/slide/',
                        uniqid() . '-' . $item->getClientOriginalName()
                    );
                    $model->save();
                }
            }
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('slide.index'), 'message' => 'Th??m slide th??nh c??ng']);
    }

    public function editForm($id)
    {
        $model = Slide::find($id);

        if (!$model) {
            return redirect()->back();
        }

        return view("admin.slide.edit-form", compact('model'));
    }

    public function saveEdit(Request $request, $id)
    {
        $message = [
            'image.mimes' => 'File ???nh kh??ng ????ng ?????nh d???ng (jpg, bmp, png, jpeg)',
            'image.max' => 'File ???nh kh??ng ???????c qu?? 2MB',
            'status.required' => "H??y ch???n tr???ng th??i",
            'url.url' => "???????ng d???n kh??ng h???p l???"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'url' => 'nullable|url',
                'image' => 'mimes:jpg,bmp,png,jpeg|max:2048',
                'status' => 'required'
            ],
            $message
        );
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors(), 'url' => route('slide.index')]);
        } else {

            $model = Slide::find($id);
            $model->fill($request->all());
            $model->user_id = Auth::id();
            // upload ???nh
            if ($request->has('image')) {
                $model->image = $request->image->storeAs(
                    'uploads/slide/',
                    uniqid() . '-' . $request->image->getClientOriginalName()
                );
            }
            $model->save();
        }
        return response()->json(['status' => 1, 'success' => 'success', 'url' => route('slide.index'), 'message' => 'S???a slide th??nh c??ng']);
    }

    public function remove($id, Request $request)
    {
        $model = Slide::find($id);

        if ($model->count() == 0) {
            return response()->json(['success' => 'Slide kh??ng t???n t???i !']);
        }
        $model->forceDelete();

        return response()->json(['success' => 'X??a slide th??nh c??ng !']);
    }

    public function removeMultiple(Request $request)
    {
        $idAll = $request->allId;
        $slide = Slide::withTrashed()->whereIn('id', $idAll);

        if ($slide->count() == 0) {
            return response()->json(['success' => 'X??a slide th???t b???i !']);
        }
        $slide->forceDelete();

        return response()->json(['success' => 'X??a slide th??nh c??ng !']);
    }
}