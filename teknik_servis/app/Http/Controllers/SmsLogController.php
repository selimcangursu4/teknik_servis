<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsLog;
use App\Models\ServiceActivities;



class SmsLogController extends Controller
{
    public function send(Request $request)
    {
        try {

            $sms = new SmsLog();
            $sms->phone = $request->phone;
            $sms->message = $request->message;
            $sms->save();

            $activity = new ServiceActivities();
            $activity->service_id = $request->serviceId;
            $activity->detail = `Sms Gönderildi ! Gönderilen Sms İçeriği : $request->message`;
            $activity->user_id = 1;
            $activity->status_id = 11;
            $activity->save();

            return response()->json(['success'=>true,'message'=>'SMS gönderildi']);

        } catch (Exception $error) {

            return response()->json(['success'=>false,'message'=>'SMS gönderme başarısız. Hata: ' . $error->getMessage()]);
        }
    }
}
