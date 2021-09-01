<?php
namespace App\CustomClasses;

use App\Models\DeliveryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
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
            env('PUSHER_APP_ID'),
            $this->options
        );
    }
    
    public function get_requests($id)
    {
        // $delivery_requests = DB::table('requests')
        //     ->leftJoin('users', 'requests.camp_manager_id', '=', 'users.id')
        //     ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
        //     ->select('users.name as camp_manager_name','evacuation_centers.name as evacuation_center_name','requests.*')
        //     ->orderByRaw('updated_at ASC')
        //     ->get();

        

        $data = ['delivery_requests' => $delivery_requests];
        $this->pusher->trigger('requests-channel', 'deliver-event', $data);
    }

    public function refreshList()
    {
        $delivery_requests = DB::table('requests')
            ->leftJoin('users', 'requests.camp_manager_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select(
                'users.name as camp_manager_name',
                'evacuation_centers.name as evacuation_center_name',
                'evacuation_centers.id as evacuation_center_id',
                'requests.id',
                'requests.status',
                'requests.food_packs',
                'requests.water',
                'requests.hygiene_kit',
                'requests.clothes',
                'requests.medicine',
                'requests.emergency_shelter_assistance',
                'requests.note',
                'requests.updated_at',)
            ->orderByRaw('updated_at DESC')
            ->get();
        
        //(string)View::make('admin.request_resource.body', [ 'delivery_requests' => $delivery_requests ]);
        //$view = View::make( 'admin.request_resource.body', [ 'delivery_requests' => $delivery_requests ] );
        //$data = $view->render();
        $data = [ 'delivery_requests' => $delivery_requests ];
        $dummyData = 'dummyData';
        $this->pusher->trigger('requests01-channel', 'admin-deliver-event', $dummyData);
    }

    public function refreshHistory()
    {
        // $delivery_requests = DeliveryRequest::orderBy('updated_at', 'DESC')->get();

        $delivery_requests = DB::table('requests')
            ->select(DB::raw("id, status, TO_CHAR(updated_at, 'FMMonth DD, YYYY, FMHH12:MI am') as updated_at"))
            ->orderBy('updated_at', 'DESC')
            ->get();

        $data = [ 'delivery_requests' => $delivery_requests ];

        $this->pusher->trigger('requests01-channel', 'camp_manger-deliver-event', $data);
    }

    public function refreshDeliveries($id)
    {
        //$user = Auth::user();
        //dd($id);
        $delivery_requests = DB::table('requests')
            ->join('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select(DB::raw("evacuation_centers.name as evacuation_center_name, requests.id, requests.status, TO_CHAR(requests.updated_at, 'FMMonth DD, YYYY, FMHH12:MI am') as updated_at"))
            ->where('courier_id', '=', $id)
            ->orderBy('requests.updated_at', 'DESC')
            ->get();
        
        //$is_empty = DeliveryRequest::where('courier_id', '=', $id)->first();
        $data = [ 'delivery_requests' => $delivery_requests ];

        $this->pusher->trigger('requests01-channel', 'courier-deliver-event', $data);
    }

}