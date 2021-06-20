<?php

namespace App\Http\Controllers;

use App\User;

trait SendNotification {
    
    public function sendPushNotification($reciever_id, $sender_id, $message)
    {
        $firebaseToken = User::where('id', $reciever_id)->pluck('device_key')->all();
          
        $SERVER_API_KEY = 'AAAA7Df3Q_0:APA91bHYONms_tH_0RH60fjbrpWidT5GcMuRALe0QkgcDJqPcr8pnBpUPWko9s-FG47ghqT8xUwRDixVK7yS82A-8TSXZiTsGsPv_gau2T4i9eDtt5ZR_3k9009Au9T2WMFbsrZ2w57n';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "SaydaliZone",
                "body" => $message,
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);

        return $response;
    }
}