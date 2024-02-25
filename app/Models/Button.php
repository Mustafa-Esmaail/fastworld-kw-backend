<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appended=[ 'icon_path'];
    protected $casts = [
        'text' => 'array',
    ];
    public function getIconPathAttribute() 
    { 
        return $this->icon != null ? asset('uploads/buttons/'.$this->icon) :null;
    }
    public function Icon_social()
    {
       return $this->hasOne(Icon::class,'button_id');
    }
}
