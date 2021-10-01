<?php

namespace App\Http\Controllers;

use App\Models\DisasterResponse;
use App\Models\EvacuationCenter;
use App\Models\Evacuee;
use App\Models\InboundSms;
use App\Models\ReliefGood;
use App\Models\ReliefRecipient;
use App\Models\User;

class InboundSmsController extends Controller
{
    public function decodesms($id)
    {
        $sms = InboundSms::where('id', $id)->first();
        $message = explode(',', $sms->message);
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
            default:

                break;
        };
    }
    public function admit($sender, $message)
    {
        $evac_center = EvacuationCenter::where('camp_manager_id', $message[1])->first();
        $families = ReliefRecipient::whereIn('family_code', $message)->get();
        if ($families != null) {
            foreach ($families as $family) {
                $relief_recipient = ReliefRecipient::find($family->id);
                $relief_recipient->recipient_type = 'Evacuee';
                $relief_recipient->save();

                $checkIf_DR_IsEnded = DisasterResponse::where('id', $relief_recipient->disaster_response_id)->first();
                $checkIfExistsInEvacuee = Evacuee::where('relief_recipient_id', $relief_recipient->id)->first();
                if ($checkIf_DR_IsEnded->date_ended == null) {
                    if ($checkIfExistsInEvacuee == null) {
                        $evacuee = new Evacuee();
                        $evacuee->relief_recipient_id = $relief_recipient->id;
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

        return (new OutboundSmsController)->successSms($sender, $reply);
    }
    public function discharge($sender, $message)
    {
        $families = ReliefRecipient::whereIn('family_code', $message)->get();
        if ($families != null) {
            foreach ($families as $family) {
                $relief_recipient = ReliefRecipient::find($family->id);
                $relief_recipient->recipient_type = 'Non-evacuee';
                $relief_recipient->save();
                $findEvacuee = Evacuee::where('relief_recipient_id', $relief_recipient->id)->first();

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

        return (new OutboundSmsController)->successSms($sender, $reply);
    }
    public function dispense($sender, $message)
    {
        $this_rr = ReliefRecipient::where('family_code', $message[3])
            ->where('disaster_response_id', $message[2])->first();

        $user = User::where('id', $message[1]);

        $relief_good = new ReliefGood();
        $relief_good->field_officer_id              = $user->id;
        $relief_good->disaster_response_id          = $message[2];
        $relief_good->relief_recipient_id           = $this_rr->id;
        $relief_good->date                          = now();
        $relief_good->food_packs                    = $message[4];
        $relief_good->water                         = $message[5];
        $relief_good->hygiene_kit                   = $message[6];
        $relief_good->medicine                      = $message[7];
        $relief_good->clothes                       = $message[8];
        $relief_good->emergency_shelter_assistance  = $message[9];
        $relief_good->save();

        $evacuation_center = EvacuationCenter::where('camp_manager_id', '=', $user->id)->first();
        $prev_stock = $evacuation_center->stock_level()->first();
        $evacuation_center->stock_level()->update([
            'food_packs'                    => ($prev_stock->food_packs - $relief_good->food_packs),
            'water'                         => ($prev_stock->water - $relief_good->water),
            'hygiene_kit'                   => ($prev_stock->hygiene_kit - $relief_good->hygiene_kit),
            'medicine'                      => ($prev_stock->medicine - $relief_good->medicine),
            'clothes'                       => ($prev_stock->clothes - $relief_good->clothes),
            'emergency_shelter_assistance'  => ($prev_stock->emergency_shelter_assistance - $relief_good->emergency_shelter_assistance),
        ]);
        return response("success");
    }
    public function request($sender, $message)
    {
        return;
    }
    public function viewEvacuees($sender, $message)
    {
        return;
    }
    public function viewSupply($sender, $message)
    {
        return;
    }
    public function viewNonEvacuees($sender, $message)
    {
        return;
    }
    public function addSupply($sender, $message)
    {
        return;
    }
}