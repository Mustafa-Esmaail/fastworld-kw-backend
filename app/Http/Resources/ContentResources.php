<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'               => $this->id,
            'type'             => $this->type,
            'state'            => $this->state,
            'image'            => $this->image_path,
            'link'             => $this->link,
            'embed'            => $this->embed,
            'themeid'          => $this->design_id,
            'text'             => json_encode($this->text),
            'order'            => $this->order,
            'title'            => $this->title,
            'subtitle'         => $this->subtitle,
            'description'      => $this->description,
            'subtype'          => $this->subtype,
            'path'             => $this->path,  
            'information_id'   => $this->information_id,
            'Buttons'          => ButtonResources::collection($this->Buttons),
            'Socials'          => SocialResources::collection($this->Socials),

        ];
    }
}
