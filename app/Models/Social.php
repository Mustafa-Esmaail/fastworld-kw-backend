<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appended=['image_path'];
    
    public function getImagePathAttribute()
    {
        return $this->image != null ? asset('uploads/socials/'.$this->image) : asset('uploads/socials/default.png');
    }
    public function Icon() 
    {
       return $this->hasOne(Icon::class);
    }
}
 