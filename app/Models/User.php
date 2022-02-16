<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'phone',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function personal_information()
    {
        return $this->hasMany(PersonalInformation::class, 'user_id');
    }

    public function model_has_role()
    {
        return $this->hasMany(ModelHasRole::class, 'model_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id')->withTrashed();
        // quan he 
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id')->withTrashed();
        // quan he 
    }

    public function slides()
    {
        return $this->hasMany(Slide::class, 'user_id')->withTrashed();
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id')->withTrashed();
        // quan he  
    }

    public function coupons()
    {
        return $this->hasMany(Coupons::class, 'user_id')->withTrashed();
        // quan he 
    }

    public function coupon_usage()
    {
        return $this->hasMany(CouponUsage::class, 'user_id')->withTrashed();
        // quan he 
    }


    public function breeds()
    {
        return $this->hasMany(Breed::class, 'user_id')->withTrashed();
        // quan he 
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id')->withTrashed();
        // quan he 
    }

    public function accessories()
    {
        return $this->hasMany(Accessory::class, 'user_id')->withTrashed();
        // quan he
    }
}