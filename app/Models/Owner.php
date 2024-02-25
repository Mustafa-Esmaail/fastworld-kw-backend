<?php

namespace App\Models;
// 
// 
use App\Models\Setting;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;



class Owner extends Authenticatable implements JWTSubject
{
    use Notifiable,SoftDeletes;

    protected $guarded = [];
    protected $appended=['image_path'];

    protected $dates = ['deleted_at'];
    public function getImagePathAttribute()
    {
        return $this->avater != null ? asset('uploads/owners/'.$this->avater) : asset('uploads/owners/default.png');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'type'=>'owner',
        ];
    }
    
    public function Informations()
    {
     return  $this->hasMany(Information::class,'owner_id');
    }
    public function Links()
    {
     return  $this->hasMany(Link::class,'owner_id');
    }
    public function Contents()
    {
     return  $this->hasMany(Content::class,'owner_id');
    }
    public function Icon_profile()
    {
       return $this->hasOne(VarificationProfile::class,'owner_id');
    }

    public function Profile_setting()
    {
       return $this->hasOne(Setting::class,'owner_id');
    }
    // public function Advices()
    // {
    //  return  $this->hasMany(Advice::class);
    // }

}
