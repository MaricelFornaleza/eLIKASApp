<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;
    protected $table = 'supplies';

    // protected $fillable = [
    //     'user_id', 'supply_type', 'quantity', 'source'
    // ];
}
