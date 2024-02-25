<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VarificationProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'                    =>$this->id,
            'position'              =>$this->position,
            'varification_icon_id'  =>$this->varification_icon_id ,
            // 'varification_icon'     =>$this->icon_path, 
        ];
    }
}
