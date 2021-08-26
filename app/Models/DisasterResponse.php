<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterResponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_started',
        'date_ended',
        'disaster_type',
        'description',
        'photo',
    ];
}