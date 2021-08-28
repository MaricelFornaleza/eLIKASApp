<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLevel extends Model
{
    use HasFactory;
    protected $table = 'stock_levels';

    protected $fillable = [
        'evacuation_center_id', 'food_packs', 'water', 'hygiene_kit', 'medicine', 'clothes', 'emergency_shelter_assistance' 
    ];

    public function evacuation_center()
    {
        return $this->belongsTo('App\Models\EvacuationCenter', 'evacuation_center_id');
    }
}
