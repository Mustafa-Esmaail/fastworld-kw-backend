<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $guarded = [];
    // public function Design()
    // {
    //  return  $this->belongsTo(Design::class,'design_id');
    // }
    public function Information()
    {
     return  $this->belongsTo(Information::class,'information_id');
    }
    public function Owner()
    {
     return  $this->belongsTo(Owner::class,'owner_id');
    }
    public function Views()
    {
     return  $this->hasMany(View::class,'link_id');
    }
}
