<?php

namespace App\Imports;

use App\Models\EvacuationCenter;
use App\Models\StockLevel;
use App\CustomClasses\UpdateMarker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EvacuationCenterImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $validator = Validator::make($collection->toArray(), [
            '*.evacuation_center_name' => 'required|min:1|max:128',
            '*.address'         => 'required|min:1|max:256',
            '*.latitude'        => 'required',
            '*.longitude'       => 'required',
            '*.capacity'        => 'required|numeric|min:1',
            '*.characteristics' => 'nullable'
        ])->validate();

        foreach ($collection as $row) {
            if ($row->filter()->isNotEmpty()) {
                $evacuation_center = EvacuationCenter::create([
                    'name'              => $row['evacuation_center_name'],
                    'address'           => $row['address'],
                    'latitude'          => $row['latitude'],
                    'longitude'         => $row['longitude'],
                    'capacity'          => $row['capacity'],
                    'characteristics'   => $row['characteristics'],
                ]);

                $stock_level =  StockLevel::create([
                    'evacuation_center_id' => $evacuation_center->id,
                ]);
            }
        }

        $updatemarker = new UpdateMarker;
        $updatemarker->get_evac();
    }
}