<?php

namespace App\Imports;

use App\Models\FamilyMember;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Family;
use App\Models\ReliefRecipient;

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

                // if ($row['family_code'] != null) {
                //     $findFamily =  DB::table('families')->where('family_code', $family_member->family_code)->first();
                //     if($findFamily == null){
                //         $family = new Family();
                //         $family->family_code = $family_member->family_code;
                //         $family->no_of_members = 1;
                //         $family->save();

                //         $relief_recipient = new ReliefRecipient();
                //         $relief_recipient->family_code = $family_member->family_code;
                //         $relief_recipient->recipient_type = 'Non-Evacuee';
                //         $relief_recipient->save();
                //     }else if($findFamily != null){
                //         $family = Family::find($findFamily->id);
                //         $family->no_of_members = $family->no_of_members+1;
                //         $family->save();
                //     }
                // }


            }
        }
    }
}