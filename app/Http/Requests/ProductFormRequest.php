<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ruleArr =  [
            'name' => [
                'required',
                Rule::unique('products')->ignore($this->id)
            ],
            'price' => 'required|numeric',
            'quantity' => 'required|numeric'
        ];
        if($this->id == null){
            $ruleArr['uploadfile'] = 'required|mimes:jpg,bmp,png,jpeg';
        }else{
            $ruleArr['uploadfile'] = 'mimes:jpg,bmp,png,jpeg';
        }
        return $ruleArr;
    }

    public function messages(){
        return [
            'name.required' => 'Hãy nhập tên sản phẩm',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'quantity.required' => 'Hãy nhập số lượng sản phẩm',
            'quantity.numeric"' => 'Số lượng phải là dạng sổ',
            'quantity.between:1,1000' => 'Số lượng nhập vào ít nhất là 1',
            'price.required' => 'Hãy nhập giá sản phẩm',
            'price.numeric' => 'Giá sản phẩm không đúng định dạng',
            'price.size:1' => 'Giá sản phẩm thấp nhất phải bằng 1',
            'uploadfile.required' => 'Hãy chọn ảnh sản phẩm',
            'uploadfile.mimes' => 'File ảnh sản phẩm không đúng định dạng (jpg, bmp, png, jpeg)',
        ];
    }
}