<?php

namespace App\Http\Traits;

use App\Models\Notification;
use App\Models\Student; 
use App\Models\Teacher;
use App\Models\Visitor;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManagerStatic as Image;

trait UploadFilesTrait{
  protected static function uploadImage($image, $path)
  {
      $imageName = $image->hashName();
      Image::make($image)->resize(360, 270)->save(public_path('uploads/' . $path . '/' . $imageName));
      return $imageName;
  }
  protected static function uploadFile($fill, $path)
  {
      $fileName =time() . '.'. $fill->extension();  
      
      $fill->move(public_path('/uploads/files/'.$path), $fileName);

      return $fileName;
  }
  protected static function uploadvideo($video, $path)
  {
      $filename = $video->hashName();
      $video->move(public_path('uploads/'.$path), $filename);
      return $filename;
  }
   
}