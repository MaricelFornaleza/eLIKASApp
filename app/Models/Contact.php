<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $fillable = [
        'contact_no', 'user_id'
    ];
    public function contact()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
