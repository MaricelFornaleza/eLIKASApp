<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvacuationCenter extends Model
{
    use HasFactory;
    protected $table = 'evacuation_centers';

    // protected $fillable = [
    //     'user_id', 'name', 'address', 'latitude', 'longitude', 'capacity', 'characteristics' 
    // ];

    /**
     * Get the Camp_Manager that manages the Evacuation Center.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id')->withTrashed();
    }

}
