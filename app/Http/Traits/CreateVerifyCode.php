<?php
namespace App\Http\Traits;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;
trait CreateVerifyCode{
    protected static function createCode($model)
    {
        $code= random_int(100000, 999999);

        if($model->where('code',$code)->get()->count()>0)
        {
            self::createCode($model);
        }
        return $code;
    }
    protected function createToken($model)
    {
        $token=Str::random(6);
        if($model->where('token',$token)->get()->count()>0)
        {
            self::createToken($model);
        }
        return $token;
    }


}