<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $table = 'request';
    protected $fillable = [
        //'disaster_response_id',
        'camp_manager_id', 
        'courier_id',
        'date',
        'food_packs', 
        'water', 
        'hygiene_kit', 
        'medicine', 
        'clothes', 
        'emergency_shelter_assistance', 
        'notes', 
        'status'
    ];

    // public function disaster_response()
    // {
    //     return $this->belongsTo('App\Models\DisasterResponse');
    // }
    public function camp_manager()
    {
        return $this->belongsTo('App\Models\CampManager');
    }
    public function courier()
    {
        return $this->belongsTo('App\Models\Courier');
    }
}
