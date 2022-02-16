<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'category_blog_id',
        'image',
        'content',
        'status'
    ];

    public function BlogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'category_blog_id')->withTrashed();
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}