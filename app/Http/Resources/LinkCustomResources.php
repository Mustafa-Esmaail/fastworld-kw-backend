<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkCustomResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id'                    =>$this->id,
        'public_id'             =>$this->public_id, 
        'visits'                =>$this->Views()->where('link_id',$this->id)->get()->count(),
        //$Link->Views()->where('link_id',$Link->id)->get()->count();
        // 'Information'            => new InformationResources($this->Information), 

       ];
    }
}
