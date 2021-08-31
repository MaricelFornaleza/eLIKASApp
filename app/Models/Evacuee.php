<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evacuee extends Model
{
    use HasFactory;

    protected $table = 'evacuees';

    protected $fillable = [
        'relief_recipient_id', 
        'evacuation_center_id'
    ];

    public function relief_recipient()
    {
        return $this->belongsTo('App\Models\ReliefRecipient');
    }

    public function evacuation_center()
    {
        return $this->belongsTo('App\Models\EvacuationCenter');
    }
}
