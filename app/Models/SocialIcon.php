<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialIcon extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appended=[ 'icon_path'];
    public function getIconPathAttribute() 
    { 
        return $this->icon != null ? asset('uploads/social_icons/'.$this->icon) : asset('uploads/social_icons/default.png');
    }
}
