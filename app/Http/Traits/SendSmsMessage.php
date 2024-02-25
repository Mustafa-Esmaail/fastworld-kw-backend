<?php
namespace App\Http\Traits;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;
trait SendSmsMessage{

    public static function sendMobileMessage($phone,$message)
    {
        try {

                $client = new Client([
                    'base_uri' => "https://6j84pz.api.infobip.com/",
                    'headers' => [
                        'Authorization' => "App bbb116230e6d2af9fd5a7e80e773dc05-c8a0be8b-c972-4da6-9842-64958c66cac5",
                        'Content-Type'  => 'application/json',
                        'Accept'        => 'application/json',
                    ]
                ]);
                $response = $client->request(
                    'POST',
                    'sms/2/text/advanced',
                    [
                        RequestOptions::JSON => [
                            'messages' => [
                                [
                                    'from' => 'Talqen',
                                    'destinations' => [
                                        ['to' => $phone]
                                    ],
                                    'text' => $message,
                                ]
                            ]
                        ],
                    ]
                );

        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

}
