<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'designation',
        'display_name'
    ];
    public function courier()
    {
        return $this->belongsTo('App\Models\User');
    }
}