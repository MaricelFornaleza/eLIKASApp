<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvacuationCenter extends Model
{
    use HasFactory;
    protected $table = 'evacuation_centers';

    protected $fillable = [
        'name', 
        'camp_manager_id', 
        'address', 
        'latitude', 
        'longitude', 
        'capacity', 
        'characteristics' 
    ];

    /**
     * Get the Camp_Manager that manages the Evacuation Center.
     */
    public function camp_manager()
    {
        return $this->belongsTo('App\Models\CampManager');
    }

    public function stock_level()
    {
        return $this->hasOne('App\Models\StockLevel');
    }
}
