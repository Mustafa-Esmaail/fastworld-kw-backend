<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            // 'view'=>array_sum($this->Views()->pluk('source_social')->toArray())
            'source_social'=>[
                'facebook'=>$this->Views()->where('source_social','!=',null)->where('source_social',1)->get()->count(),
                'instagram'=>$this->Views()->where('source_social','!=',null)->where('source_social',2)->get()->count(),
                'twitter'=>$this->Views()->where('source_social','!=',null)->where('source_social',3)->get()->count(),
                'direct'=>$this->Views()->where('source_social','!=',null)->where('source_social',4)->get()->count(),
                'other'=>$this->Views()->where('source_social','!=',null)->where('source_social',5)->get()->count(),
            ],
            'source_device'=>
            [
            'mobil'=>$this->Views()->where('source_device','!=',null)->where('source_device',1)->get()->count(),
            'pc'=>$this->Views()->where('source_device','!=',null)->where('source_device',2)->get()->count(),
            'tab'=>$this->Views()->where('source_device','!=',null)->where('source_device',3)->get()->count(),
            ],
            'source_system'=>[
                'ios'=>$this->Views()->where('source_system','!=',null)->where('source_system',1)->get()->count(),
                'android'=>$this->Views()->where('source_system','!=',null)->where('source_system',2)->get()->count(),
                'win'=>$this->Views()->where('source_system','!=',null)->where('source_system',3)->get()->count(),
                'mac'=>$this->Views()->where('source_system','!=',null)->where('source_system',4)->get()->count(),
            ],
    
            'source_location'=>[
                'EGY'=>$this->Views()->where('source_location','!=',null)->where('source_location',1)->get()->count(),
                'KSA'=>$this->Views()->where('source_location','!=',null)->where('source_location',2)->get()->count(),
                'UAE'=>$this->Views()->where('source_location','!=',null)->where('source_location',3)->get()->count(),
                'USA'=>$this->Views()->where('source_location','!=',null)->where('source_location',4)->get()->count(),
            ]
            ,
        ];

    }
}
