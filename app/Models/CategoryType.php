<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'category_types';
    protected $fillable = [
        'name'
    ];

    public function category()
    {
        return $this->hasMany(Category::class, 'category_type_id')->withTrashed();
    }
}