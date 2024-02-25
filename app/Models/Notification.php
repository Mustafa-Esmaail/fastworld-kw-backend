<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Models\Teacher;
use App\Models\Student;

class Notification extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes = ['title', 'body'];
    protected $guarded=[];
    public function sendert()
    {
        // if($this->reciver_type=='student'){
            return $this->belongsTo(Teacher::class,'sender_id');
        // }else{
        //     return $this->belongsTo(Student::class,'sender_id');
        // }
    }
 public function senders()
    {
       return $this->belongsTo(Student::class,'sender_id');
    }

}
