<?php
namespace App\CustomClasses;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Pusher\Pusher;

class UpdateDRData {

    public function __construct() {
        $this->options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
    
        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $this->options
        );
    }

    public function refreshData($id)
    {
        //'disaster_response', 'barangays', 'data', 'chartData', 'chartData2', 'dates'
        $data = $id;
        $this->pusher->trigger('disaster-response-channel', 'update-event', $data);
    }
    
}