<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'shop_name',
        'shop_url',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country_id',
        'photo',
        'bactive',
        'bkey',
        'status_id',
        'role_id',
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

    public function tp_status()
    {
        return $this->belongsTo(Tp_status::class, 'status_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsTo(User_Role::class, 'role_id');

    }

}
