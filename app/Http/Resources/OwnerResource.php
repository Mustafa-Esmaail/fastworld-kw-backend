<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Coin;
use App\Models\VarificationIcon;
use App\Models\VarificationProfile;
use App\Models\Setting;
class OwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id'                        =>$this->id,
            'email'                     =>$this->email,
            // 'Links'                  =>$this->Links,
            'image'                     =>$this->image_path,
            'varification_icon'         =>!empty($this->Icon_profile)?VarificationIcon::where('id',$this->Icon_profile->varification_icon_id)->first()->icon_path:$this->icon_path,
            'varification_icon_position'=>!empty($this->Icon_profile)?$this->Icon_profile->position :null,
        ];
    }
}
