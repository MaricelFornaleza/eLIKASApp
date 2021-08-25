<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeliveryRequestExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $delivery_requests = DB::table('requests')
            ->leftJoin('users', 'requests.camp_manager_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select(
                'requests.id',
                'users.name as camp_manager_name',
                'evacuation_centers.name',
                'requests.food_packs',
                'requests.water',
                'requests.hygiene_kit',
                'requests.clothes',
                'requests.medicine',
                'requests.emergency_shelter_assistance',
                'requests.note',
                'requests.status',
                'requests.updated_at')
            ->orderByRaw('updated_at ASC')
            ->get();
        return $delivery_requests;
    }

    public function headings(): array
    {
        return [
            'Request ID',
            'Camp Manager Name',
            'Evacuation Center Name',
            'No. of Food Packs',
            'No. of Water',
            'No. of Hygiene Kit',
            'No. of Clothes',
            'No. of Medicine',
            'No. of Emergency Shelter Assistance',
            'Note',
            'Status',
            'Last Modified'
        ];
    }
}
