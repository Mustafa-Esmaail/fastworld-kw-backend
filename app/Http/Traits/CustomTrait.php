<?php
namespace App\Http\Traits;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;
trait CustomTrait
{
    protected static function getorders($orders)
    {
        $index=[];
        foreach ($orders as $order) 
        {
            $value=$order->type.'_'.$order->id;
            array_push($index,$value);
        }
        return $index;
    }
}