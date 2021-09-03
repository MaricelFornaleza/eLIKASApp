<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffectedArea extends Model
{
    use HasFactory;
    protected $fillable = [
        'disaster_response_id',
        'barangay'
    ];
}