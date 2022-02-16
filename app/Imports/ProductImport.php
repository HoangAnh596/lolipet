<?php

namespace App\Imports;

use App\Models\Age;
use App\Models\Breed;
use App\Models\Category;
use App\Models\Coupons;
use App\Models\Gender;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ProductImport implements ToModel, SkipsOnError, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        if (isset($row['category'])) {
            $cate = Category::where('name', 'like', '%' . $row['category'] . '%')->first();
        }
        if (isset($row['breed'])) {
            $breed = Breed::where('name', 'like', '%' . $row['breed'] . '%')->first();
        }
        if (isset($row['age'])) {
            $age = Age::where('age', 'like', '%' . $row['age'] . '%')->first();
        }
        if (isset($row['gender'])) {
            $gender = Gender::where('gender', 'like', '%' . $row['gender'] . '%')->first();
        }
        if (isset($row['coupon'])) {
            $coupon = Coupons::where('code', 'like', '%' . $row['coupon'] . '%')->first();
        }
        if (isset($row['status']) && $row['status'] == 'Còn hàng') {
            $row['status'] = 1;
        } else {
            $row['status'] = 0;
        }
        $user_id = Auth::id();
        $product = Product::create([
            'name' => $row['name'],
            'user_id' => $user_id,
            'category_id' => isset($cate['id']) ? $cate['id'] : 1,
            'image' => isset($row['image']) ? $row['image'] : 'không có sẵn',
            'slug' => isset($row['slug']) ? $row['slug'] : '',
            'weight' => isset($row['weight']) ? $row['weight'] : '',
            'breed_id' => isset($breed['id']) ? $breed['id'] : 0,
            'age_id' => isset($age['id']) ? $age['id'] : 0,
            'gender_id' => isset($gender['id']) ? $gender['id'] : 0,
            'price' => isset($row['price']) ? $row['price'] : 0,
            'coupon_id' => isset($coupon['id']) ? $coupon['id'] : 0,
            'discount' => isset($row['discount']) ? $row['discount'] : 0,
            'discount_type' => isset($row['discount_type']) ? $row['discount_type'] : 0,
            'discount_start_date' => isset($row['discount_start_date']) ? $row['discount_start_date'] : null,
            'discount_end_date' => isset($row['discount_end_date']) ? $row['discount_end_date'] : null,
            'status' => isset($row['status']) ? $row['status'] : 1,
            'quantity' => isset($row['quantity']) ? $row['quantity'] : 1,
            'description' => isset($row['description']) ? $row['description'] : 'Chưa có thông tin',
        ]);
        return $product;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('products')],
            'slug' => ['required', Rule::unique('products')],
        ];
    }
}