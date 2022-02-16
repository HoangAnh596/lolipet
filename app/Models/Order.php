<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "orders";
    protected $fillable = [
        'user_id',
        'seller_id',
        'name',
        'phone',
        'email',
        'note',
        'shipping_address',
        'payment_type',
        'payment_status',
        'delivery_status',
        'grand_total',
        'coupon_discount',
        'code',
        'cancel_order'
    ];

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}