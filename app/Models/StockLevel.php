<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLevel extends Model
{
    use HasFactory;
    protected $table = 'stock_levels';

    public function evacuation_center()
    {
        return $this->belongsTo('App\Models\EvacuationCenter', 'evacuation_center_id');
    }
}
