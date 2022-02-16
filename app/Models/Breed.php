<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Breed extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "breeds";
    protected $fillable = [
        'name', 'slug', 'category_id', 'user_id', 'status'
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'breed_id')->withTrashed();
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}