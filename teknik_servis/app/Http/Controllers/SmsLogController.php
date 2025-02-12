<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsLog;
use App\Models\ServiceActivities;
use Exception;


class SmsLogController extends Controller
{
    public function send(Request $request)
    {
        try {

            // SMS Gönderme İşlemleri Burada Yapılacak.
            $sms = new SmsLog();
            $sms->phone = $request->input('smsPhone');
            $sms->message = $request->input('smsMessage');
            $sms->save();

            // SMS gönderildi Servis Activities Kaydı
            $activity = new ServiceActivities();
            $activity->service_id = $request->input('serviceId');
            $activity->detail = "Sms Gönderildi ! Gönderilen Sms İçeriği : " . $request->input('smsMessage');
            $activity->user_id = 1;
            $activity->status_id = 11;
            $activity->save();

            return response()->json(['success'=>true,'message'=>'SMS gönderildi']);

        } catch (Exception $error) {

            return response()->json(['success'=>false,'message'=>'SMS gönderme başarısız. Hata: ' . $error->getMessage()]);
        }
    }
}
