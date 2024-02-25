<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Icon;
use App\Models\SocialIcon;
class ButtonResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // if ($this->Icon_social!=null)
        // {
        //     return [
        //         'id'         =>$this->id,
        //         'link'         =>$this->link,
        //         // 'title' =>$this->title==null?SocialIcon::where('id',$this->Icon->social_icon_id)->first()->name:$this->title,
        //         'title'        =>$this->title,
        //         'description'  =>$this->description,
        //         // 'icon'         => $this->icon==null?SocialIcon::where('id',$this->Icon_social->social_icon_id)->first()->icon_path:$this->image_path,
        //         'icon'         => SocialIcon::where('id',$this->Icon_social->social_icon_id)->first()->icon_path:$this->image_path,
        //         'type'         => $this->type, 
        //         'subtype'      => $this->subtype,
        //         // 'source_id' =>$this->source_id,
        //         // 'featured'  =>$this->featured, 
        //         'tcolor'      =>$this->tcolor,
        //         'bcolor'      =>$this->bcolor,
        //         'link1'       =>$this->link1,
        //         'link2'       =>$this->link2,
        //         'state'       => $this->state,
        //         'scheduled'   => $this->scheduled,
        //         'start'       =>$this->start,
        //         'end'         =>$this->end,
        //         'text'        =>json_encode($this->text),
        //         'path'        =>$this->path,
        //         'content_id'   =>$this->content_id,
        //     ];
        // } 
        return [ 
            'id'         =>$this->id,
            'link'         =>$this->link,
            'title'        =>$this->title,
            'icon_name'     =>$this->icon_name,
            'description'  =>$this->description,
            'icon'         =>!empty($this->Icon_social)?SocialIcon::where('id',$this->Icon_social->social_icon_id)->first()->icon_path:$this->icon_path,
            'type'         => $this->type, 
            'subtype'      => $this->subtype,
            // 'source_id' =>$this->source_id,
            // 'featured'  =>$this->featured, 
            'tcolor'      =>$this->tcolor,
            'bcolor'      =>$this->bcolor,
            'link1'       =>$this->link1,
            'link2'       =>$this->link2,
            'state'       => $this->state,
            'scheduled'   => $this->scheduled,
            'start'       =>$this->start,
            'end'         =>$this->end,
            'text'        =>json_encode($this->text),
            'path'        =>$this->path,
            'content_id'   =>$this->content_id,
        ];
    }
}
