<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accessory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'accessories';
    protected $fillable = [
        'name',
        'category_id',
        'slug',
        'price',
        'coupon_id',
        'discount',
        'discount_type',
        'min_quantity',
        'discount_start_date',
        'discount_end_date',
        'status',
        'quantity',
        'detail'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    public function galleries()
    {
        return $this->hasMany(AccessoryGallery::class, 'accessory_id')->withTrashed();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id')->withTrashed();
    }

    public function discountType()
    {
        return $this->belongsTo(DiscountType::class, 'discount_type')->withTrashed();
    }

    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class, 'product_id')->withTrashed();
    }
    
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id')->withTrashed();
    }
}