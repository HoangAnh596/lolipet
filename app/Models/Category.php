<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "categories";
    protected $fillable = [
        'name', 'slug', 'show_slide',  'category_type_id', 'coupon_id'
    ];
    // Quan hệ category -> product
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id')->withTrashed();
        // quan he 
    }

    public function breeds()
    {
        return $this->hasMany(Breed::class, 'category_id')->withTrashed();
        // quan he 
    }

    public function categoryType()
    {
        return $this->belongsTo(CategoryType::class, 'category_type_id')->withTrashed();
    }

    public function accessory()
    {
        return $this->hasMany(Accessory::class, 'category_id')->withTrashed();
    }
}