<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appended=[ 'image_path'];
    protected $casts = [
        'text' => 'array',
    ]; 
    public function getImagePathAttribute() 
    { 
        return $this->image != null ? asset('uploads/informations/'.$this->image) : asset('uploads/informations/default.png');
    }
    public function Buttons()
    {
     return  $this->hasMany(Button::class,'content_id');
    }
    public function Socials()
    {
     return  $this->hasMany(Social::class,'content_id');
    }
    public function information()
    {
     return  $this->belongsTo(Information::class,'information_id');
    }
}
