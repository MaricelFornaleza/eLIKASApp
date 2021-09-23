<?php

namespace App\Imports;

use App\Models\FamilyMember;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResidentsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $validator = Validator::make($collection->toArray(), [
            '*.name'              => ['required', 'string', 'max:255', 'alpha_spaces'],
            '*.gender'            => ['required', 'string', 'max:255', 'regex:/^[A-Za-z]+$/'],
            '*.birthdate'         => ['required', 'date_format:Y-m-d'],
            '*.sectoral_classification' => ['required', 'string', 'max:255', 'alpha_spaces'],
            '*.is_family_head'    => ['required', 'string', 'max:255'],
            '*.street'           => ['required', 'string', 'max:255', 'alpha_spaces'],
            '*.barangay'           => ['required', 'string', 'max:255'],
        ])->validate();

        foreach ($collection as $row) {
            if ($row->filter()->isNotEmpty()) {
                $family_member = new FamilyMember();
                $family_member->name     = $row['name'];
                $family_member->gender   = $row['gender'];
                $family_member->birthdate = $row['birthdate'];
                $family_member->sectoral_classification = $row['sectoral_classification'];
                $family_member->is_family_head = $row['is_family_head'];
                $family_member->street = $row['street'];
                $family_member->barangay = $row['barangay'];
                $family_member->save();
            }
        }
    }
}