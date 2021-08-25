<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EvacuationCenterExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $evacuation_centers =  DB::table('evacuation_centers')
            ->leftJoin('users', 'evacuation_centers.camp_manager_id', '=', 'users.id')
            ->select(
                'users.name as camp_manager_name', 
                'evacuation_centers.name',
                'evacuation_centers.address', 
                'evacuation_centers.latitude', 
                'evacuation_centers.longitude',
                'evacuation_centers.capacity', 
                'evacuation_centers.characteristics')
            ->orderByRaw('evacuation_centers.id ASC')
            ->get();
        //dd($evacuation_centers);
        return $evacuation_centers;
    }

    public function headings(): array
    {
        return [
            'Camp Manager Name',
            'Evacuation Center Name',
            'Address',
            'Latitude',
            'Longitude',
            'Capacity',
            'Characteristics',
        ];
    }
}
