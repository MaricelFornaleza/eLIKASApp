<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventories';

    protected $fillable = [
        'name', 'user_id', 'total_no_of_food_packs',
        'total_no_of_water', 'total_no_of_hygiene_kit',
        'total_no_of_medicine', 'total_no_of_clothes',
        'total_no_of_emergency_shelter_assistance'
    ];

    public function inventory(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    function inventory_supplies()
    {
        return $this->hasMany('App\Models\Supply');
    }
}
