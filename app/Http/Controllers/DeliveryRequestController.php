<?php

namespace App\Http\Controllers;


use App\Models\DeliveryRequest;
use App\Models\EvacuationCenter;
use App\CustomClasses\UpdateRequests;
use App\Models\Evacuee;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\AffectedResident;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class DeliveryRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_requests = DB::table('requests')
            ->leftJoin('users', 'requests.camp_manager_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select(
                'users.name as camp_manager_name',
                'evacuation_centers.name as evacuation_center_name',
                'evacuation_centers.address as evacuation_center_address',
                'evacuation_centers.id as evacuation_center_id',
                'requests.*'
            )
            //->orderByRaw('updated_at DESC')
            ->orderByRaw("CASE WHEN requests.status = 'pending' THEN '1'
                            WHEN requests.status = 'preparing' THEN '2'
                            WHEN requests.status = 'in-transit' THEN '3'
                            WHEN requests.status = 'delivered' THEN '4'
                            WHEN requests.status = 'cancelled' THEN '5'
                            WHEN requests.status = 'decline' THEN '6' END ASC, requests.updated_at DESC")
            ->paginate(20);

        // SELECT users.name as camp_manager_name, evacuation_centers.name as evacuation_center_name, requests.*
        // FROM public.requests
        // LEFT JOIN users
        // ON requests.camp_manager_id = users.id
        // LEFT JOIN evacuation_centers
        // ON evacuation_centers.camp_manager_id = requests.camp_manager_id
        // ORDER BY updated_at ASC

        return view('admin.request_resource.requestList', ['delivery_requests' => $delivery_requests]);
    }

    public function evac_data($evac_id)
    {
        $evacuees = Evacuee::where('evacuation_center_id', $evac_id)->where('date_discharged', null)->get();

        $total_number_of_evacuees = 0;
        if ($evacuees != null) {
            $family_codes =  array();
            $female = 0;
            $male = 0;
            $children = 0;
            $lactating = 0;
            $pwd = 0;
            $pregnant = 0;
            $senior_citizen  = 0;
            $solo_parent = 0;

            foreach ($evacuees as $evacuee) {
                $affected_resident = AffectedResident::where('id', $evacuee->affected_resident_id)->first();
                if (!in_array($affected_resident->family_code, $family_codes)) {
                    array_push($family_codes, $affected_resident->family_code);
                    $family = Family::where('family_code', $affected_resident->family_code)->first();
                    $total_number_of_evacuees = $total_number_of_evacuees + $family->no_of_members;

                    $family_members = FamilyMember::where('family_code', $family->family_code)->get();

                    $female = $female + $family_members->where('gender', 'Female')->count();
                    $male = $male + $family_members->where('gender', 'Male')->count();
                    $children = $children + $family_members->where('sectoral_classification', 'Children')->count();
                    $lactating = $lactating + $family_members->where('sectoral_classification', 'Lactating')->count();
                    $pwd = $pwd + $family_members->where('sectoral_classification', 'Person with Disability')->count();
                    $pregnant = $pregnant + $family_members->where('sectoral_classification', 'Pregnant')->count();
                    $senior_citizen  = $senior_citizen + $family_members->where('sectoral_classification', 'Senior Citizen')->count();
                    $solo_parent = $solo_parent + $family_members->where('sectoral_classification', 'Solo Parent')->count();
                }
            }
        }
        $html = "<p><b>Total Evacuees: </b>" . $total_number_of_evacuees . "</p>" .
            "<p><b>Children: </b>" . $children . "</p>" .
            "<p><b>Lactating: </b>" . $lactating . "</p>" .
            "<p><b>PWD: </b>" . $pwd . "</p>" .
            "<p><b>Pregnant: </b>" . $pregnant . "</p>" .
            "<p><b>Senior Citizen: </b>" . $senior_citizen . "</p>" .
            "<p><b>Solo Parent: </b>" . $solo_parent . "</p>";
        return $html;
    }

    public function refresh()
    {
        $delivery_requests = DB::table('requests')
            ->leftJoin('users', 'requests.camp_manager_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select(
                'users.name as camp_manager_name',
                'evacuation_centers.name as evacuation_center_name',
                'evacuation_centers.address as evacuation_center_address',
                'evacuation_centers.id as evacuation_center_id',
                'requests.*'
            )
            ->orderByRaw("CASE WHEN requests.status = 'pending' THEN '1'
                WHEN requests.status = 'preparing' THEN '2'
                WHEN requests.status = 'in-transit' THEN '3'
                WHEN requests.status = 'delivered' THEN '4'
                WHEN requests.status = 'cancelled' THEN '5'
                WHEN requests.status = 'decline' THEN '6' END ASC, requests.updated_at DESC")
            ->paginate(20);

        return view('admin.request_resource.body', ['delivery_requests' => $delivery_requests]);
    }

    public function approve(Request $request)
    {
        $id = $request->input('id');
        $user = Auth::user();
        $delivery_request = DeliveryRequest::where('id', '=', $id)->first();


        $admin_inventory = Inventory::where('user_id', '=', $user->id)->first();

        if (
            $admin_inventory->total_no_of_food_packs >= $delivery_request->food_packs &&
            $admin_inventory->total_no_of_water >= $delivery_request->water &&
            $admin_inventory->total_no_of_hygiene_kit >= $delivery_request->hygiene_kit &&
            $admin_inventory->total_no_of_medicine >= $delivery_request->medicine &&
            $admin_inventory->total_no_of_clothes >= $delivery_request->clothes &&
            $admin_inventory->total_no_of_emergency_shelter_assistance >= $delivery_request->emergency_shelter_assistance
        ) {
            $delivery_request->status = "preparing";
            $delivery_request->save();
            $admin_inventory->update([
                'total_no_of_food_packs'                    => ($admin_inventory->total_no_of_food_packs - $delivery_request->food_packs),
                'total_no_of_water'                         => ($admin_inventory->total_no_of_water - $delivery_request->water),
                'total_no_of_hygiene_kit'                   => ($admin_inventory->total_no_of_hygiene_kit - $delivery_request->hygiene_kit),
                'total_no_of_medicine'                      => ($admin_inventory->total_no_of_medicine - $delivery_request->medicine),
                'total_no_of_clothes'                       => ($admin_inventory->total_no_of_clothes - $delivery_request->clothes),
                'total_no_of_emergency_shelter_assistance'  => ($admin_inventory->total_no_of_emergency_shelter_assistance - $delivery_request->emergency_shelter_assistance),
            ]);
            Session::flash('message', 'You have approved Request ID ' . $id);
        } else {
            Session::flash('message', 'Not enough supply');
        }


        $update_requests = new UpdateRequests;
        $update_requests->refreshHistory($delivery_request->camp_manager_id);

        return redirect()->back();
    }

    public function admin_decline(Request $request)
    {
        $id = $request->input('id');
        $delivery_request = DeliveryRequest::where('id', '=', $id)->first();
        $delivery_request->status = 'declined';
        $delivery_request->save();

        $update_requests = new UpdateRequests;
        $update_requests->refreshHistory($delivery_request->camp_manager_id);
        $update_requests->refreshDeliveries($delivery_request->courier_id);

        return redirect()->back()->with('message', 'You have declined Request ID ' . $id);
    }

    public function cancel(Request $request)
    {
        $role = Auth::user()->officer_type;
        $id = $request->input('id');

        // DeliveryRequest::where('id', $id)->update([
        //     'status' => 'cancelled'
        // ])
        $delivery_request = DeliveryRequest::where('id', '=', $id)->first();
        $delivery_request->status = 'cancelled';
        $delivery_request->save();

        $request->session()->flash('message', 'You have cancelled Request ID ' . $id);

        $update_requests = new UpdateRequests;
        if ($role == 'Administrator') {
            $update_requests->refreshHistory($delivery_request->camp_manager_id);
            if (!empty($delivery_request->courier_id))
                $update_requests->refreshDeliveries($delivery_request->courier_id);

            return redirect()->back();
        } else if ($role == 'Camp Manager') {
            $update_requests->refreshList();
            $update_requests->refreshDeliveries($delivery_request->courier_id);

            return redirect()->route('request.camp-manager.history');
        } else if ($role == 'Courier') {
            $update_requests->refreshList();
            $update_requests->refreshHistory($delivery_request->camp_manager_id);

            return redirect()->route('home');
        }
    }

    public function assign_courier(Request $request)
    {
        $id = $request->input('id');
        DeliveryRequest::where('id', $id)->update([
            'status' => 'preparing',
            'courier_id' => $request->input('courier_id')
        ]);

        $delivery_request = DeliveryRequest::where('requests.id', '=', $id)
            ->leftJoin('users', 'requests.courier_id', '=', 'users.id')
            ->leftJoin('evacuation_centers', 'evacuation_centers.camp_manager_id', '=', 'requests.camp_manager_id')
            ->select('users.id', 'users.name as courier_name', 'evacuation_centers.name as evacuation_center_name')
            ->first();

        $update_requests = new UpdateRequests;
        $update_requests->refreshDeliveries($request->input('courier_id'));
        //send sms to courier
        $user = User::where('id', $request->input('courier_id'))->first();
        $message = "Request " . $id . ": \n\nA delivery was assigned to you. Reply 'accept " . $id . "' if you want to accept the request otherwise, reply 'cancel " . $id . "'.";
        if ($user->globe_labs_access_token != null) {
            (new OutboundSmsController)->reply($user->contact_no, $message);
        }


        //dd($delivery_requests->courier_name);
        return redirect()->back()->with('message', 'You have assigned '
            . $delivery_request->courier_name
            . ' to '
            . $delivery_request->evacuation_center_name);
    }

    public function receive_supplies(Request $request)
    {
        $id = $request->input('id');
        $delivery_request = DeliveryRequest::where('id', '=', $id)->first();

        // $user = CampManager::where('user_id', '=', $delivery_request->camp_manager_id)->first();
        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $delivery_request->camp_manager_id)->first();
        $prev_stock = $evacuation_center->stock_level()->first();
        $evacuation_center->stock_level()->update([
            'food_packs'                    => ($prev_stock->food_packs + $delivery_request->food_packs),
            'water'                         => ($prev_stock->water + $delivery_request->water),
            'hygiene_kit'                   => ($prev_stock->hygiene_kit + $delivery_request->hygiene_kit),
            'medicine'                      => ($prev_stock->medicine + $delivery_request->medicine),
            'clothes'                       => ($prev_stock->clothes + $delivery_request->clothes),
            'emergency_shelter_assistance'  => ($prev_stock->emergency_shelter_assistance + $delivery_request->emergency_shelter_assistance),
        ]);
        $delivery_request->status = "delivered";
        $delivery_request->save();

        $update_requests = new UpdateRequests;
        $update_requests->refreshList();
        $update_requests->refreshDeliveries($delivery_request->courier_id);

        return redirect()->route('request.camp-manager.history')->with('message', 'Request ID ' . $id . ' has been delivered! Check your supply inventory to confirm.');
    }

    public function courier_accept($id)
    {
        // DeliveryRequest::where('id', $id)->update([
        //     'status' => 'in-transit'
        // ]);
        $delivery_request = DeliveryRequest::where('id', '=', $id)->first();
        $delivery_request->status = 'in-transit';
        $delivery_request->save();

        $update_requests = new UpdateRequests;
        $update_requests->refreshList();
        $update_requests->refreshHistory($delivery_request->camp_manager_id);

        return redirect()->route('home')->with('message', 'You have accepted Request ID ' . $id);
    }

    public function courier_decline(Request $request)
    {
        $id = $request->input('id');
        // DeliveryRequest::where('id', $id)->update([
        //     'status' => 'declined'
        // ]);
        $delivery_request = DeliveryRequest::where('id', '=', $id)->first();
        $delivery_request->status = 'declined';
        $delivery_request->save();

        $update_requests = new UpdateRequests;
        $update_requests->refreshList();
        $update_requests->refreshHistory($delivery_request->camp_manager_id);

        return redirect()->route('home')->with('message', 'You have declined Request ID ' . $id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'disaster_response_id'          => ['required', 'numeric'],
            'food_packs'                    => ['numeric', 'min:0', 'max:10000'],
            'water'                         => ['numeric', 'min:0', 'max:10000'],
            'clothes'                       => ['numeric', 'min:0', 'max:10000'],
            'hygiene_kit'                   => ['numeric', 'min:0', 'max:10000'],
            'medicine'                      => ['numeric', 'min:0', 'max:10000'],
            'emergency_shelter_assistance'  => ['numeric', 'min:0', 'max:10000'],
            'note'                          => ['nullable'],
        ]);

        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $user->id)->first();
        //dd($evacuation_center);
        if (empty($evacuation_center)) {
            $request->session()->flash('error', 'You are not assigned to an evacuation center.');
            return redirect()->route('request.camp-manager.history');
        }

        $delivery_request = DeliveryRequest::create([
            'disaster_response_id'          => $validated['disaster_response_id'],
            'camp_manager_id'               => $user->id,
            'date'                          => Carbon::now(),
            'food_packs'                    => $validated['food_packs'],
            'water'                         => $validated['water'],
            'hygiene_kit'                   => $validated['hygiene_kit'],
            'medicine'                      => $validated['medicine'],
            'clothes'                       => $validated['clothes'],
            'emergency_shelter_assistance'  => $validated['emergency_shelter_assistance'],
            'note'                          => $validated['note'],
            'status'                        => "pending"
        ]);

        $update_requests = new UpdateRequests;
        $update_requests->refreshList();

        $request->session()->flash('message', 'Successfully sent a request!');

        //TO-DO: put here dynamic updating

        return redirect()->route('request.camp-manager.history');
    }
}