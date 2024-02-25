<?php


namespace App\Http\Controllers\Api\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Controllers\Controller;

use App\Models\Owner;
use App\Models\Information;
use App\Http\Resources\InformationResources;

class InformationController extends Controller
{
    // use UploadFilesTrait;
    // use CreateCode;
    // protected $owner;
    protected $model;
    public function __construct(Information $model)
    {
            // $this->owner=auth('owner')->user();
            $this->model=$model;
    }
    
    public function get(Request $request)
    {
       
       $validator = Validator::make($request->all(), [
             'id'   => 'required|exists:informations,id',
       ]);
       if($validator->fails())
       {
             return response()->json([
                'status'=>false,
                'message'=>$validator->errors(),
             ],400);
       }
       $information=$this->model->find($request->id);
       if (!empty($information)) 
       {
             return response()->json([
                'status'=>true,
                'information'=>new InformationResources($information),
             ],200); 
       }
       return response()->json([
             'status'=>false,
             'message'=>__('site.not_found'),
       ],400); 
 
       
    }
   
}
