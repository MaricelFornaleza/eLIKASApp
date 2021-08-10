<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';

    protected $fillable = [
        'name', 'user_id'
    ];

    public function inventory(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
