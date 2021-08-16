<?php

namespace App\Exports;

use App\Models\Supply;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Inventory;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();

        $user_inventory = User::find($user->id)->user_inventory;
        
        return Inventory::find($user_inventory->id)->inventory_supplies;
    }
}
