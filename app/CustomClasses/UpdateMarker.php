<?php
namespace App\CustomClasses;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Pusher\Pusher;

class UpdateMarker {

    public function __construct() {
        $this->options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
    
        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_id'),
            $this->options
        );
    }
    
    public function get_evac()
    {
        $evacuation_centers = DB::table('evacuation_centers')
            ->join('stock_levels', 'evacuation_centers.id', '=', 'stock_levels.evacuation_center_id')
            ->select('evacuation_centers.*', 'stock_levels.food_packs', 'stock_levels.water', 'stock_levels.hygiene_kit', 'stock_levels.medicine',
                'stock_levels.clothes', 'stock_levels.emergency_shelter_assistance')
            ->orderByRaw('evacuation_centers.id ASC')
            ->get();

        $data = ['evacuation_centers' => $evacuation_centers];
        $this->pusher->trigger('my-channel', 'my-event', $data);
    }

    public function get_couriers()
    {
        //$couriers = Courier::all();
        $couriers =  DB::table('couriers')
            ->join('locations', 'couriers.id', '=', 'locations.courier_id')
            ->select('couriers.*', 'locations.latitude', 'locations.longitude', 'locations.updated_at')
            ->orderByRaw('couriers.id ASC')
            ->get();
        
        $data = ['couriers' => $couriers];
        $this->pusher->trigger('my-channel', 'my-event', $data);
    }
}