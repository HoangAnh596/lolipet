<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "order_details";

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'tax',
        'shipping_cost',
        'shipping_type',
        'payment_status',
        'delivery_status',
        'quantity'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withTrashed();
    }

    public function accessory()
    {
        return $this->belongsTo(Accessory::class, 'product_id');
    }
}