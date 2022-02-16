<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "coupon_types";
    protected $fillable = [
        'name'
    ];

    public function coupons()
    {
        return $this->hasMany(Coupons::class, 'type')->withTrashed();
    }
}