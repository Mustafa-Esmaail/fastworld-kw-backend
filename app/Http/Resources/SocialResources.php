<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Icon;
use App\Models\SocialIcon;

class SocialResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->image==null)
        {
            return [
                'id'              =>$this->id,
                'type' => $this->type,
                //'title' =>$this->title==null?SocialIcon::where('id',$this->Icon->social_icon_id)->first()->name:$this->title,
                'title' => $this->title==null && $this->social_icon_id !=null? SocialIcon::where('id',$this->Icon->social_icon_id)->first()->name:$this->title,
                'icon_name' =>$this->icon_name,
                'link' =>$this->link,
                'order' => $this->order,
                'pid'  => $this->pid,
                'content_id'   => $this->content_id,
                //'image'           =>$this->image==null?SocialIcon::where('id',$this->Icon->social_icon_id)->first()->icon_path:$this->image_path,
               'image'           =>$this->social_icon_id !=null ? SocialIcon::where('id',$this->Icon->social_icon_id)->first()->icon_path : null,
            ];
        } 
        return [
            'id'              =>$this->id,
            'type'            => $this->type,
            'title'           =>$this->title,
            'icon_name' =>$this->icon_name,
            'link'            =>$this->link,
            'order'           => $this->order,
            'pid'             => $this->pid,
            'content_id'      => $this->content_id,
            'image'           =>$this->image_path,
        ];
    }
}
