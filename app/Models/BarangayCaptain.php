<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayCaptain extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'barangay',
        'display_name'
    ];
    public function barangay_captain()
    {
        return $this->belongsTo('App\Models\User');
    }

    
}