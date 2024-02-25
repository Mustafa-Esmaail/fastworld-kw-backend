<?php

namespace App\Http\Traits;

use App\Models\Notification;
use App\Models\Student; 
use App\Models\Teacher;
use Illuminate\Support\Facades\Http;
trait NotificationTrait{
    protected function sendNotification($title_ar="تلقين",$title_en="Talqen",$body_ar,$body_en,$sender,$reciver,$type,$send)
    {
      $notify=Notification::create([
        'ar'                =>['title'=>$title_ar,'body'=>$body_ar],
        'en'                =>['title'=>$title_en,'body'=>$body_en],
        'sender_id'         =>$sender,
        'reciver_id'        =>$reciver,
        'reciver_type'              =>$type,
        'sender_type'     =>$send,
    ]);
 

      if($type=='student')
      {
        $reciver=Student::find($reciver);
      }else{
        $reciver=Teacher::find($reciver);
      }
      $mobile_token=$reciver->mobile_token;
     if($mobile_token != null)
      {
          $FIREBASE_SERVER_API_KEY ='AAAAGD9RS80:APA91bFFZAVybSwJoYtTGGtEQBn59vPttaDVdlczHF4zPDa619qUxGa-JZU2by4vfuefP7Iy9iYrF8dWk2P0gaMXSmyKRR11AwtdMmFJw_5lo8ijVFc4KFJilOIwFDgMILMOZIu9SxTG';
          $apiURL = 'https://fcm.googleapis.com/fcm/send';
          $postInput = [
                      "to" =>$mobile_token,
                      "notification"       =>[
                        "title"   => $title_en,
                        "body"    => $body_en,
                        "mutable_content" =>true,
                        "soun"            =>"default"
                      ],
                    "andriod"=>[
                        "priority"    =>"HIGH",
                        "notification"=>[
                            "notification_priority"    =>"PRIORITY_MAX",
                            "sound"                    =>"default",
                            "default_sound"            =>true,
                            "default_vibrate_timings"  =>true,
                            "default_light_settings"   =>true
                        ]
                    ],
                      "data"=>[
                        'id'            =>$notify->id,
                        'title'         =>$title_en,
                        'body'          =>$body_en,
                        'read'          =>$notify->read_at != null ? true : false ,
                        'date'          =>date('Y-m-d h:i:s' , strtotime($notify->created_at)),
                      ]
                  ];
          $headers = [
              'Authorization'=>'key='.$FIREBASE_SERVER_API_KEY,
              ];
            $response = Http::withHeaders($headers)->post($apiURL, $postInput);
      }

    }
}
