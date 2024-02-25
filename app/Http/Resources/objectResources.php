<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class objectResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    =>  $this->id,
            'name'    =>  $this->name,
            'data'  =>  $this->data,
            'Container'  =>  $this->Container,
            'Contact'  =>  $this->Contact,
            'DivProfilePicture'  =>  $this->DivProfilePicture,
            'ProfilePicture'  =>  $this->ProfilePicture,
            'StyledButton'  =>  $this->StyledButton,
            'DivProfilePicture'  =>  $this->DivProfilePicture,
            'img'               =>  $this->image_path,
            'imgtwo'         =>  $this->imgtwo_path,

            // 'name'    =>  $this->name,
            // 'colors'    =>  $this->colors,
            // 'FontFace'  =>  $this->FontFace,
            // 'object'    =>  $this->object,
            // 'borderStyle'    =>  $this->borderStyle,
            // 'borderSize'    =>  $this->borderSize,
            // // 'borderStyle'      =>  $this->borderStyle,
            // 'outlineStyle'     =>  $this->outlineStyle,
            // 'profileAlginment' =>  $this->profileAlginment,
            // 'socialAlginment'  =>  $this->socialAlginment,
        ];
    }
}
