<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Inventory;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SuppliesExport implements FromCollection,ShouldAutoSize, WithHeadings
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

    public function headings(): array
    {
        return [
            'Supply_id',
            'Inventory_id',
            'Supply Type',
            'Quantity',
            'Source',
            'Created_at',
            'Updated_at',
        ];
    }
}