<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'reviews';
    protected $fillable = [
        'product_id',
        'product_type',
        'user_id',
        'name',
        'email',
        'rating',
        'comment',
        'status',
        'product_type'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function accessory()
    {
        return $this->belongsTo(Accessory::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoryType()
    {
        return $this->belongsTo(CategoryType::class, 'product_type');
    }
}