<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded=[];

    // public function student()
    // {
    //     return $this->belongsTo(Student::class,'student_id');
    // }
    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class,'teacher_id');
    // }
    public function sendrS()
    {
        return $this->belongsTo(Student::class,'sender_id');
    }
    public function sendrT()
    {
        return $this->belongsTo(Teacher::class,'sender_id');
    }
    public function reciverS()
    {
        return $this->belongsTo(Student::class,'reciver_id');
    }
    public function reciverT()
    {
        return $this->belongsTo(Teacher::class,'reciver_id');
    }
}
