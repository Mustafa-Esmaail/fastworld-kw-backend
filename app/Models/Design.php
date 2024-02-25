<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appended=['image_path','backgroundimage_Path'];

    public function category()
    {
     return  $this->belongsTo(Category::class,'category_id');
    }

    public function getImagePathAttribute()
    {
        return $this->image != null ? asset('uploads/designs/'.$this->image) : asset('uploads/designs/default.png');
    }
    public function getBackgroundImagePathAttribute()
    {
        return $this->backgroundimage != null ? asset('uploads/designs/'.$this->backgroundimage) : asset('uploads/designs/default.png');
    }
}
