<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\StudentResource;
class notificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            =>  $this->id,
            'title'         =>  $this->title,
            'body'          =>  $this->body,
            'read'          =>  $this->read_at != null ? true : false ,
              'type'        =>  $this->reciver_type=='student'?'student':'teacher',
            // 'sender'        =>  $this->reciver_type=='student' ? new TeacherResource($this->sendert) : new StudentResource($this->senders),
            'sender'        =>  $this->sender_type=='student' ?new StudentResource($this->senders): new TeacherResource($this->sendert) ,
            'date'          =>  date('Y-m-d h:i:s'),
        ];
    } 
}
