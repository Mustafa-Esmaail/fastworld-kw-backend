<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appended=[ 'video_path', 'image_path','backgroundimage_Path','cover_path','background_image_path'];
    protected $table = 'informations';

    protected $casts = [ 
        
        'theme' => 'array',
        // 'socials' => 'array',
    ];
    public function getCoverPathAttribute() 
    { 
        return $this->cover != null ? asset('uploads/informations/'.$this->cover) : asset('uploads/informations/default.png');
    }

    public function getbackground_imagePathAttribute() 
    { 
        return $this->background_image != null ? asset('uploads/informations/'.$this->background_image) : null;
    }

    public function getVideoPathAttribute()
    {
        return $this->video != null ? asset('videos/' . $this->video) : null;
    }
    public function getImagePathAttribute() 
    { 
        return $this->image != null ? asset('uploads/informations/'.$this->image) : asset('uploads/informations/default.png');
    }
    public function getBackgroundImagePathAttribute()
    {
        return $this->background_image != null ? asset('uploads/informations/'.$this->background_image) : asset('uploads/informations/default.png');
        //return $this->backgroundimage != null ? asset('uploads/informations/'.$this->backgroundimage) : null;
    }
    public function Design()
    {
     return  $this->belongsTo(Design::class,'design_id');
    }
       
    // public function Object()
    // {
    //  return  $this->belongsTo(Obj::class,'design_id');
    // }
    public function Link()
    {
       return $this->hasOne(Link::class);
    }
    public function Contents()
    {
     return  $this->hasMany(Content::class,'information_id');
    }
    public function Owner()
    {
     return  $this->belongsTo(Owner::class,'owner_id');
    }
}
