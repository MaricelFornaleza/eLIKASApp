<?php
namespace App\CustomClasses;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Pusher\Pusher;

class UpdateRequests {

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
    
    public function get_requests()
    {
        $delivery_requests = DB::table('requests')
            ->leftJoin('users', 'requests.camp_manager_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select('users.name as camp_manager_name','evacuation_centers.name as evacuation_center_name','requests.*')
            ->orderByRaw('updated_at ASC')
            ->get();

        $data = ['delivery_requests' => $delivery_requests];
        $this->pusher->trigger('my-channel', 'my-event', $data);
    }

}