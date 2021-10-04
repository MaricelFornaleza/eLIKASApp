<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evacuee extends Model
{
    use HasFactory;

    protected $table = 'evacuees';

    protected $fillable = [
        'affected_resident_id',
        'evacuation_center_id'
    ];

    public function affected_resident()
    {
        return $this->belongsTo('App\Models\AffectedResident');
    }

    public function evacuation_center()
    {
        return $this->belongsTo('App\Models\EvacuationCenter');
    }
}