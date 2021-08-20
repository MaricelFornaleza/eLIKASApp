<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Traits\LaratrustUserTrait;



class User extends Authenticatable
{

    use Notifiable;
    use SoftDeletes;

    use HasFactory;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'photo', 'email', 'officer_type', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'deleted_at'
    ];

    function user_contacts()
    {
        return $this->hasMany('App\Models\Contact', 'user_id', 'user_id');
    }

    function user_inventory()
    {
        return $this->hasOne('App\Models\Inventory');
    }
    function admin()
    {
        return $this->hasOne('App\Models\Admin');
    }
    function camp_manager()
    {
        return $this->hasOne('App\Models\CampManager');
    }
    function barangay_captain()
    {
        return $this->hasOne('App\Models\BarangayCaptain');
    }
    function courier()
    {
        return $this->hasOne('App\Models\Courier');
    }
}