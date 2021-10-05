<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffectedResidentStat extends Model
{
    use HasFactory;
    protected $table = 'affected_resident_stats';
    protected $fillable = [
        'disaster_response_id',
        'date',
        'no_of_evacuees',
        'no_of_non_evacuees'
    ];

    public function disaster_response()
    {
        return $this->hasOne('App\Models\DisasterResponse');
    }
}