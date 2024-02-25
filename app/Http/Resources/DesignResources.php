<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              =>$this->id,
            'name'            =>$this->name,
            'public_id'       =>$this->public_id,
            'category_id'     =>$this->category_id,
            'image'           =>$this->image_path,
            'backgroundimage'  =>$this->backgroundimage_Path,
        ];
    }
}
