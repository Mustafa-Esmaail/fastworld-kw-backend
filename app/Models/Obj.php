<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as modele;

class Obj extends modele
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'objects';
    protected $casts = [
        'data'=> 'array',
        'Container'=> 'array',
        'Contact'=> 'array',
        'DivProfilePicture'=> 'array',
        'ProfilePicture'=> 'array',
        'StyledButton'=> 'array',
        'DivProfilePicture'=> 'array',

        // 'colors' => 'array',
        // 'FontFace' => 'array',
        // 'object' => 'array',
        // 'borderStyle' => 'array',
        // 'borderSize' => 'array',
        // 'outlineStyle' => 'array',
        // 'profileAlginment' => 'array',
        // 'socialAlginment' => 'array',
    ];
    protected $appended=['image_path','imgtwo_path'];
    public function getImagePathAttribute()
    { 
        return $this->img != null ? asset('uploads/Obj/'.$this->img) : asset('uploads/Obj/default.png');
    }
    public function getImgTwoPathAttribute()
    {
        return $this->imgtwo != null ? asset('uploads/Obj/'.$this->imgtwo) : asset('uploads/Obj/default.png');
    }
}
