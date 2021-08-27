<?php

namespace App\Imports;

use App\Models\Supply;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class SuppliesImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $validator = Validator::make($collection->toArray(), [
            '*.supply_type' => ['required', 'string', 'max:255', 'alpha_spaces'],
            '*.quantity' => ['required', 'numeric', "min:1"],
            '*.source' => ['required', 'string', 'max:255'],
        ])->validate();

        $user = Auth::user();

        $user_inventory_id = User::find($user->id)->user_inventory->id;

        foreach ($collection as $row) {
            if ($row->filter()->isNotEmpty()) {
                $supply = new Supply();
                $supply->inventory_id     = $user_inventory_id;
                $supply->supply_type   = $row['supply_type'];
                $supply->quantity = $row['quantity'];
                $supply->source = $row['source'];
                $supply->save();
            }
        }
    }
}