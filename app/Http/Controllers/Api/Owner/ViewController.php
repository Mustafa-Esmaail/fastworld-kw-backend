<?php
namespace App\Http\Controllers\Api\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use App\Http\Controllers\Controller;

use App\Models\Owner;
use App\Models\View;
use App\Models\Link;
use App\Http\Resources\LinkResources;
use App\Http\Resources\ViewResource;
use App\Http\Resources\LinkCustomResources;

use App\Http\Traits\UploadFilesTrait;
use App\Http\Traits\CreateCode;
use File;
class ViewController extends Controller
{
    protected $owner;
    protected $model;
    protected $links_ids;
    public function __construct(View $model)
    {
        $this->owner=auth('owner')->user();
        $this->model=$model;
        $this->links_ids=!empty($this->owner->links)?$this->owner->links->pluck('id')->toArray():[];
    }
    public function getviews(Request $request)
    {
        if (empty($this->owner)) 
       {
         return response()->json([
             'status'=>false,
             'message'=>__('site.user_not_found'),
           ],400); 
       }
       
       try
        {
            $validator = Validator::make($request->all(), [
                'link_id'   =>['required', Rule::in($this->links_ids)],
            ]);

            if($validator->fails())
            {
                return response()->json([
                'status'=>false,
                'message'=>$validator->errors(),
                ],400);
            }

            
            $link=$this->owner->Links->find($request->link_id);
            //return $link;
            if (!empty($link)) 
            {
               // $views = $link->views ;
                //return $views ;
                return response()->json([
                    'status'=>true,
                    'statistics'=>new ViewResource($link),
                    //'statistics'=>ViewResource::collection($Link)->response()->getData(true),
                ],200); 
            }
            return response()->json([
                'status'=>false,
                'message'=>__('site.not_found'),
            ],400); 
        } catch (Exception $e) 
        {
            return response()->json([
                'status'=>false,
                'errors'=>$e->getMessage(),
                ],400); 
        }    
    }
}
