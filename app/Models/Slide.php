<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'slides';
    protected $fillable = [
        'user_id',
        'image',
        'url',
        'status'
    ];
}