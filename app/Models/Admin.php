<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'region',
        'province',
        'city',


    ];
    public function admin()
    {
        return $this->belongsTo('App\Models\User');
    }

    
}