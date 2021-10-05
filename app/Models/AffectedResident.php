<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffectedResident extends Model
{
    use HasFactory;
    protected $table = 'affected_residents';
    protected $fillable = [
        'disaster_response_id',
        'affected_resident_type',
    ];

    public function evacuee()
    {
        return $this->hasOne('App\Models\Evacuee');
    }
}