<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;
    protected $table = 'supplies';

    // protected $fillable = [
    //     'inventory_id', 'supply_type', 'quantity', 'source'
    // ];

    public function supply(){
        return $this->belongsTo('App\Models\Inventory','inventory_id');
    }
}
