<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampManager extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'designation',
        'display_name'
    ];
    public function camp_manager()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function evacuation_center()
    {
        return $this->hasOne('App\Models\EvacuationCenter');
    }

    public function request()
    {
        return $this->hasMany('App\Models\DeliveryRequest');
    }
}