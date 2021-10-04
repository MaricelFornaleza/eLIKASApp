<?php

namespace App\Http\Controllers;

use App\CustomClasses\UpdateRequests;
use App\Models\BarangayCaptain;
use App\Models\DeliveryRequest;
use App\Models\DisasterResponse;
use App\Models\EvacuationCenter;
use App\Models\Evacuee;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\InboundSms;
use App\Models\Inventory;
use App\Models\ReliefGood;
use App\Models\AffectedResident;
use App\Models\Supply;
use App\Models\User;

class InboundSmsController extends Controller
{
    public function decodesms($id)
    {
        $sms = InboundSms::where('id', $id)->first();
        if (substr($sms->message, 0, 6) == "cancel") {
            $message = explode(' ', $sms->message);
        } else if (substr($sms->message, 0, 6) == "accept") {
            $message = explode(' ', $sms->message);
        } else {
            $message = explode(',', $sms->message);
        }

        $sender = $sms->sender_address;
        switch ($message[0]) {
            case 'admit':
                return $this->admit($sender, $message);
                break;
            case 'discharge':
                return $this->discharge($sender, $message);
                break;
            case 'dispense':
                return $this->dispense($sender, $message);
                break;
            case 'request':
                return $this->request($sender, $message);
                break;
            case 'viewEvacuees':
                return $this->viewEvacuees($sender, $message);
                break;
            case 'viewSupply':
                return $this->viewSupply($sender, $message);
                break;
            case 'viewNonEvacuees':
                return $this->viewNonEvacuees($sender, $message);
                break;
            case 'addSupply':
                return $this->addSupply($sender, $message);
                break;
            case 'cancel':
                return $this->cancelRequest($sender, $message);
                break;
            case 'accept':
                return $this->acceptRequest($sender, $message);
                break;
            default:

                break;
        };
    }
    public function admit($sender, $message)
    {
        $evac_center = EvacuationCenter::where('camp_manager_id', $message[1])->first();
        $families = AffectedResident::whereIn('family_code', $message)->get();
        if ($families != null) {
            foreach ($families as $family) {
                $affected_resident = AffectedResident::find($family->id);
                $affected_resident->affected_resident_type = 'Evacuee';
                $affected_resident->save();

                $checkIf_DR_IsEnded = DisasterResponse::where('id', $affected_resident->disaster_response_id)->first();
                $checkIfExistsInEvacuee = Evacuee::where('affected_resident_id', $affected_resident->id)->first();
                if ($checkIf_DR_IsEnded->date_ended == null) {
                    if ($checkIfExistsInEvacuee == null) {
                        $evacuee = new Evacuee();
                        $evacuee->affected_resident_id = $affected_resident->id;
                        $evacuee->date_admitted = now();
                        $evacuee->evacuation_center_id = $evac_center->id;
                        $evacuee->save();
                    } else {
                        $checkIfExistsInEvacuee->date_discharged = null;
                        $checkIfExistsInEvacuee->save();
                    }
                }
            }
            $reply = "Residents admitted successfully!";
        } else {
            $reply = "Request unsuccessful.";
        }

        return (new OutboundSmsController)->reply($sender, $reply);
    }
    public function discharge($sender, $message)
    {
        $families = AffectedResident::whereIn('family_code', $message)->get();
        if ($families != null) {
            foreach ($families as $family) {
                $affected_resident = AffectedResident::find($family->id);
                $affected_resident->affected_resident_type = 'Non-evacuee';
                $affected_resident->save();
                $findEvacuee = Evacuee::where('affected_resident_id', $affected_resident->id)->first();

                if ($findEvacuee == null) {
                    $evacuee = Evacuee::find($findEvacuee->id);
                    $evacuee->date_discharged = now();
                    $evacuee->save();
                }
            }
            $reply = "Residents discharged successfully!";
        } else {
            $reply = "Request unsuccessful.";
        }

        return (new OutboundSmsController)->reply($sender, $reply);
    }
    public function dispense($sender, $message)
    {
        $this_rr = AffectedResident::where('family_code', $message[3])
            ->where('disaster_response_id', $message[2])->first();

        $user = User::where('id', $message[1])->first();

        $relief_good = new ReliefGood();
        $relief_good->field_officer_id              = $user->id;
        $relief_good->disaster_response_id          = $message[2];
        $relief_good->affected_resident_id           = $this_rr->id;
        $relief_good->date                          = now();
        $relief_good->food_packs                    = $message[4];
        $relief_good->water                         = $message[5];
        $relief_good->hygiene_kit                   = $message[6];
        $relief_good->medicine                      = $message[7];
        $relief_good->clothes                       = $message[8];
        $relief_good->emergency_shelter_assistance  = $message[9];
        $relief_good->save();

        if ($user->officer_type == "Camp Manager") {
            $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $user->id)->first();

            if ($evacuation_center->stock_level() != null) {
                $prev_stock = $evacuation_center->stock_level()->first();
                $evacuation_center->stock_level()->update([
                    'food_packs'                    => ($prev_stock->food_packs - $relief_good->food_packs),
                    'water'                         => ($prev_stock->water - $relief_good->water),
                    'hygiene_kit'                   => ($prev_stock->hygiene_kit - $relief_good->hygiene_kit),
                    'medicine'                      => ($prev_stock->medicine - $relief_good->medicine),
                    'clothes'                       => ($prev_stock->clothes - $relief_good->clothes),
                    'emergency_shelter_assistance'  => ($prev_stock->emergency_shelter_assistance - $relief_good->emergency_shelter_assistance),
                ]);
            } else {
                return response("empty stocks");
            }
        } else if ($user->officer_type == "Barangay Captain") {
            $bc_inventory = Inventory::where('user_id', '=', $user->id)->first();
            $bc_inventory->update([
                'total_no_of_food_packs'                    => ($bc_inventory->total_no_of_food_packs - $relief_good->food_packs),
                'total_no_of_water'                         => ($bc_inventory->total_no_of_water - $relief_good->water),
                'total_no_of_hygiene_kit'                   => ($bc_inventory->total_no_of_hygiene_kit - $relief_good->hygiene_kit),
                'total_no_of_medicine'                      => ($bc_inventory->total_no_of_medicine - $relief_good->medicine),
                'total_no_of_clothes'                       => ($bc_inventory->total_no_of_clothes - $relief_good->clothes),
                'total_no_of_emergency_shelter_assistance'  => ($bc_inventory->total_no_of_emergency_shelter_assistance - $relief_good->emergency_shelter_assistance),
            ]);
        }

        return response($user->officer_type);
    }
    public function request($sender, $message)
    {
        $user = User::where('id', $message[1])->first();

        $delivery_request = DeliveryRequest::create([
            'disaster_response_id'          => $message[2],
            'camp_manager_id'               => $user->id,
            'date'                          => now(),
            'food_packs'                    => $message[3],
            'water'                         => $message[4],
            'hygiene_kit'                   => $message[5],
            'medicine'                      => $message[6],
            'clothes'                       => $message[7],
            'emergency_shelter_assistance'  => $message[8],
            'note'                          => $message[9],
            'status'                        => "pending"
        ]);
        $update_requests = new UpdateRequests;
        $update_requests->refreshList();
        $reply = "Request " . $delivery_request->id . ": \n\nYour request is pending. Reply 'cancel <SPACE><REQUEST ID>' to this message if you want to cancel the request or reply 'accept <SPACE><REQUEST ID>' when you received the delivery.";
        return (new OutboundSmsController)->reply($sender, $reply);
    }
    public function viewEvacuees($sender, $message)
    {

        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $message[1])->first();
        $evacuees = Evacuee::where('evacuation_center_id', $evacuation_center->id)->whereNull('date_discharged')->get();
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
        $reply = $evacuation_center->address . " " . $evacuation_center->name
            . " Evacuees Record"
            . "\n\nTotal Evacuees: " . $total_number_of_evacuees
            . "\nFemale: " . $female
            . "\nMale: " . $male
            . "\n\nSectoral Breakdown: "
            . "\nChildren: " . $children
            . "\nLactating: " . $lactating
            . "\nPWD: " . $pwd
            . "\nPregnant: " . $pregnant
            . "\nSenior Citizen: " . $senior_citizen
            . "\nSolo Parent: " . $solo_parent;
        return (new OutboundSmsController)->reply($sender, $reply);
    }
    public function viewSupply($sender, $message)
    {
        $user = User::where('id', $message[1])->first();
        if ($user->officer_type == "Camp Manager") {
            $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $user->id)->first();

            $evacuees = Evacuee::where('evacuation_center_id', $evacuation_center->id)->get();
            $total_number_of_evacuees = 0;
            if ($evacuees != null) {

                foreach ($evacuees as $evacuee) {
                    $affected_resident = AffectedResident::where('id', $evacuee->affected_resident_id)->first();
                    $family = Family::where('family_code', $affected_resident->family_code)->first();
                    $total_number_of_evacuees = $total_number_of_evacuees + $family->no_of_members;
                }
            }
            $stock_level = $evacuation_center->stock_level()->first();
            $reply = $evacuation_center->address . " " . $evacuation_center->name
                . "\nClothes: " . $stock_level->clothes
                . "\nESA: " . $stock_level->emergency_shelter_assistance
                . "\nFood Packs: " . $stock_level->food_packs
                . "\nHygiene Kit: " . $stock_level->hygiene_kit
                . "\nMedicine: " . $stock_level->medicine
                . "\nWater: " . $stock_level->water;
        } else if ($user->officer_type == "Barangay Captain") {
            $barangay = BarangayCaptain::where('user_id', $user->id)->select('barangay')->first();
            $bc_inventory = Inventory::where('user_id', $user->id)->first();
            $reply = "Barangay " . $barangay->barangay
                . "\nClothes: " . $bc_inventory->total_no_of_clothes
                . "\nESA: " . $bc_inventory->total_no_of_emergency_shelter_assistance
                . "\nFood Packs: " . $bc_inventory->total_no_of_food_packs
                . "\nHygiene Kit: " . $bc_inventory->total_no_of_hygiene_kit
                . "\nMedicine: " . $bc_inventory->total_no_of_medicine
                . "\nWater: " . $bc_inventory->total_no_of_water;
        }
        return (new OutboundSmsController)->reply($sender, $reply);
    }
    public function viewNonEvacuees($sender, $message)
    {
        $user = User::where('id', $message[1])->first();
        $barangay_captain =  BarangayCaptain::where('user_id', $user->id)->first();

        $female = 0;
        $male = 0;
        $children = 0;
        $lactating = 0;
        $pwd = 0;
        $pregnant = 0;
        $senior_citizen  = 0;
        $solo_parent = 0;
        $evacuees = FamilyMember::leftJoin('affected_residents', 'family_members.family_code', '=', 'affected_residents.family_code')
            ->leftJoin('disaster_responses', 'affected_residents.disaster_response_id', '=', 'disaster_responses.id')
            ->whereNotNull('family_members.family_code')
            ->where('family_members.barangay', $barangay_captain->barangay)
            ->where('affected_residents.affected_resident_type', 'Evacuee')
            ->whereNull('disaster_responses.date_ended')
            ->select('name')
            ->get();
        $evac_names = [];
        foreach ($evacuees as $name) {
            $evac_names[] = array_push($evac_names, $name->name);
        }
        $non_evacuees = FamilyMember::where('barangay', $barangay_captain->barangay)
            ->whereNotNull('family_members.family_code')
            ->whereNotIn('name', $evac_names)
            ->get();

        $family_members = FamilyMember::where('barangay', $barangay_captain->barangay)
            ->whereNotNull('family_members.family_code')->get();
        if ($non_evacuees != null) {
            $female = $female + $non_evacuees->where('gender', 'Female')->count();
            $male = $male + $non_evacuees->where('gender', 'Male')->count();
            $children = $children + $non_evacuees->where('sectoral_classification', 'Children')->count();
            $lactating = $lactating + $non_evacuees->where('sectoral_classification', 'Lactating')->count();
            $pwd = $pwd + $non_evacuees->where('sectoral_classification', 'Person with Disability')->count();
            $pregnant = $pregnant + $non_evacuees->where('sectoral_classification', 'Pregnant')->count();
            $senior_citizen  = $senior_citizen + $non_evacuees->where('sectoral_classification', 'Senior Citizen')->count();
            $solo_parent = $solo_parent + $non_evacuees->where('sectoral_classification', 'Solo Parent')->count();
        }
        $reply = "Barangay " . $barangay_captain->barangay
            . " Non-evacuees Record"
            . "\n\nTotal Residents: " . $family_members->count()
            . "\nFemale: " . $female
            . "\nMale: " . $male
            . "\n\nSectoral Breakdown: "
            . "\nChildren: " . $children
            . "\nLactating: " . $lactating
            . "\nPWD: " . $pwd
            . "\nPregnant: " . $pregnant
            . "\nSenior Citizen: " . $senior_citizen
            . "\nSolo Parent: " . $solo_parent;
        return (new OutboundSmsController)->reply($sender, $reply);
    }
    public function addSupply($sender, $message)
    {
        $user  = User::where('contact_no', $sender)->first();
        $user_inventory_id = User::find($user->id)->user_inventory->id;
        $user_inventory_prev_stock = $user->user_inventory()->first();
        if ($message[2] == 'Food Packs') {
            $user->user_inventory()->update([
                'total_no_of_food_packs'                    => ($user_inventory_prev_stock->total_no_of_food_packs + $message[3]),
            ]);
        } else if ($message[2] == 'Water') {
            $user->user_inventory()->update([
                'total_no_of_water'                         => ($user_inventory_prev_stock->total_no_of_water + $message[3]),
            ]);
        } else if ($message[2] == 'Hygiene Kit') {
            $user->user_inventory()->update([
                'total_no_of_hygiene_kit'                   => ($user_inventory_prev_stock->total_no_of_hygiene_kit + $message[3]),
            ]);
        } else if ($message[2] == 'Medicine') {
            $user->user_inventory()->update([
                'total_no_of_medicine'                      => ($user_inventory_prev_stock->total_no_of_medicine + $message[3]),
            ]);
        } else if ($message[2] == 'Clothes') {
            $user->user_inventory()->update([
                'total_no_of_clothes'                       => ($user_inventory_prev_stock->total_no_of_clothes + $message[3]),
            ]);
        } else if ($message[2] == 'ESA') {
            $user->user_inventory()->update([
                'total_no_of_emergency_shelter_assistance'  => ($user_inventory_prev_stock->total_no_of_emergency_shelter_assistance + $message[3]),
            ]);
        }

        $supply = new Supply();
        $supply->inventory_id     = $user_inventory_id;
        $supply->date   = now()->format('F j, Y');
        $supply->supply_type   = $message[2];
        $supply->quantity = $message[3];
        $supply->source = $message[4];
        $supply->save();
        $reply = "Supply added succesfully";
        return (new OutboundSmsController)->reply($sender, $reply);
    }
    public function cancelRequest($sender, $message)
    {

        $delivery_request = DeliveryRequest::where('id', '=', $message[1])->first();
        $delivery_request->status = 'cancelled';
        $delivery_request->save();
        $reply = "Request with no. " . $delivery_request->id . " was cancelled successfully.";
        return (new OutboundSmsController)->reply($sender, $reply);
    }
    public function acceptRequest($sender, $message)
    {
        $user  = User::where('contact_no', $sender)->first();
        $delivery_request = DeliveryRequest::where('id', '=', $message[1])->first();

        if ($user->office_type  == "Courier") {
            $delivery_request->status = 'in-transit';
            $delivery_request->save();
        } else if ($user->office_type  == "Camp Manager") {
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
        }
        return response("accepted");
    }
}