<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterResponse extends Model
{
    use HasFactory;
    protected $table = 'disaster_responses';
    protected $fillable = [
        'date_started',
        'date_ended',
        'disaster_type',
        'description',
        'photo',
    ];

    public function delivery_request()
    {
        return $this->hasMany('App\Models\DeliveryRequest');
    }
    public function affected_residents_stats()
    {
        return $this->hasOne('App\Models\AffectedResidentStats');
    }
}