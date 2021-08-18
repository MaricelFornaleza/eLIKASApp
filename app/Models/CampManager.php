<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampManager extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'designation',
        'display_name'
    ];
    public function camp_manager()
    {
        return $this->belongsTo('App\Models\User');
    }
}