<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResources extends JsonResource
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
        //'created_at'            =>$this->created_at,    
        'Information'           => new InformationResources($this->Information), 

       ];
        
    }
}
