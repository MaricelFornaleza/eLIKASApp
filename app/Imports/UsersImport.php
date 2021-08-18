<?php

namespace App\Imports;

use App\Models\Supply;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        
     $user = Auth::user();

     $user_inventory_id = User::find($user->id)->user_inventory->id;
     
     foreach ($collection as $row) {
        if ($row->filter()->isNotEmpty()) {
            $supply = new Supply();
            $supply->inventory_id     = $user_inventory_id;
            $supply->supply_type   = $row[0];
            $supply->quantity = $row[1];
            $supply->source = $row[2];
            $supply->save();
        }
     }
     
    }
}
