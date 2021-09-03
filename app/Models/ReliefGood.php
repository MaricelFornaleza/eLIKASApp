<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReliefGood extends Model
{
    use HasFactory;

    protected $table = 'relief_goods';

    protected $fillable = [
        'field_officer_id', 'disaster_response_id', 'relief_recipient_id', 'food_packs', 'water', 'hygiene_kit', 'medicine', 'clothes', 'emergency_shelter_assistance' 
    ];
}
