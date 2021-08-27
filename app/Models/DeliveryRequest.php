<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRequest extends Model
{
    use HasFactory;
    protected $table = 'requests';
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
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function courier()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
