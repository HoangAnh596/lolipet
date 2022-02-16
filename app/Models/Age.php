<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Age extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "ages";
    protected $fillable = ['age'];

    public function products()
    {
        return $this->hasMany(Product::class, 'age_id')->withTrashed();
    }
}