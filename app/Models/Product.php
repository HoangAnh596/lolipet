<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'image',
        'slug',
        'weight',
        'breed_id',
        'age_id',
        'gender_id',
        'rating',
        'price',
        'coupon_id',
        'discount',
        'discount_type',
        'min_quantity',
        'discount_start_date',
        'discount_end_date',
        'status',
        'quantity',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class, 'breed_id')->withTrashed();
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id')->withTrashed();
    }

    public function age()
    {
        return $this->belongsTo(Age::class, 'age_id')->withTrashed();
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'product_id')->withTrashed();
    }

    public function discountType()
    {
        return $this->belongsTo(DiscountType::class, 'discount_type')->withTrashed();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id')->withTrashed();
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'product_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id')->withTrashed();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupons::class, 'coupon_id')->withTrashed();
    }
}