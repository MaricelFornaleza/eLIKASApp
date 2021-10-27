<?php
namespace App\CustomClasses;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Pusher\Pusher;

class UpdateVerification {

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

    public function refreshVerifications()
    {
        $field_officers = User::where('officer_type', '!=', 'Administrator')
            ->leftJoin('camp_managers', 'camp_managers.user_id', '=', 'users.id')
            ->leftJoin('barangay_captains', 'barangay_captains.user_id', '=', 'users.id')
            ->leftJoin('couriers', 'couriers.user_id', '=', 'users.id')
            ->select('users.id', 'users.email_verified_at')
            ->get();

        $data = [ 'field_officers' => $field_officers ];

        $this->pusher->trigger('fieldOfficer-channel', 'verification-event', $data);
    }
    
}