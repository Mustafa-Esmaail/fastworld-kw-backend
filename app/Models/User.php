<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laratrust\LaratrustUserTrait;1
// use Laratrust\Traits\LaratrustUserTrait;2
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

 
class User extends Authenticatable implements LaratrustUser
{
    // use LaratrustUserTrait, Notifiable,  HasApiTokens;
    use HasRolesAndPermissions, Notifiable,  HasApiTokens;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $append = ['image_path'];

    public function getImagePathAttribute(){
        return $this->image != null ? asset('uploads/users_images/'.$this->image) :  asset('uploads/users_images/default.png') ;
    }


    public function ScopeAdmin($query)
    {
        return $query->where('type', 'admin');
    }
    public function ScopeEmployee($query)
    {
        return $query->where('type', 'emp');
    }
    public function ScopeDelivery($query)
    {
        return $query->where('type', 'delivery');
    }

    public function scopeStudent()
    {
        return $this->where('type', 2);
    }


    public function ScopeUser($query)
    {
        return $query->where('type', 'user');
    }

    public function ScopeDeliveryActive($query)
    {
        return $query->where('type', 2)->where('delivery_status', 1);
    }
}
 // use HasApiTokens, HasFactory, Notifiable;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // /**
    //  * The attributes that should be cast.
    //  *
    //  * @var array<string, string>
    //  */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];