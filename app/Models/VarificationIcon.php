<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarificationIcon extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appended=[ 'icon_path'];
    public function getIconPathAttribute() 
    { 
        return $this->icon != null ? asset('uploads/varification_icons/'.$this->icon) : asset('uploads/varification_icons/default.png');
    }
}
