<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $fillable = [
        'courier_id'
    ];

    public function courier()
    {
        return $this->belongsTo('App\Models\Courier','courier_id');
    }
}
