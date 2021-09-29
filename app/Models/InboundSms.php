<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboundSms extends Model
{
    use HasFactory;

    protected $fillable = [
        'time_sent',
        'destination_address',
        'sender_address',
        'message',
        'resource_url',

    ];
}