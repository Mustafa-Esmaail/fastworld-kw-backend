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

use App\Models\View;
use App\Models\Owner;
use App\Models\Link;
use App\Models\Information;
use App\Http\Resources\LinkResources;

class LinkController extends Controller
{ 
    // protected $owner;
    protected $model;
    public function __construct(Link $model)
    {
            // $this->owner=auth('owner')->user();
            $this->model=$model;
    }
    public function View_Link(Request $request)
    {
            //    if (empty($this->owner)) 
            //    {
            //      return response()->json([
            //          'status'=>false,
            //          'message'=>__('site.user_not_found'),
            //        ],400); 
            //    }
            $validator = Validator::make($request->all(), [
                  'public_id'      => 'required|exists:links,public_id',
                  'source_social'  => 'nullable|integer|min:0|max:5',
                  'source_device'  => 'nullable|integer|min:0|max:5',
                  'source_system'  => 'nullable|integer|min:0|max:5',
                  'source_location'=> 'nullable|integer|min:0|max:5',
            ]);
            if($validator->fails())
            {
                  return response()->json([
                  'status'=>false,
                  'message'=>$validator->errors(),
                  ],400);
            }
            $link=Link::where('public_id',$request->public_id)->first();
            if (!empty($link)) 
            {     
                  if($request->source_social != null ){
                        $view=View::create([
                              'link_id'      => $link->id,
                              'source_social' =>$request->source_social,
                        ]);
                  }
                  if($request->source_device != null ){
                        $view=View::create([
                              'link_id'       => $link->id,
                              'source_device' =>$request->source_device,
                        ]);
                  }
                  if($request->source_system != null){
                        $view=View::create([
                              'link_id'       => $link->id,
                              'source_system' =>$request->source_system,
                        ]);
                  }
                  if($request->source_location != null){
                        $view=View::create([
                              'link_id'         => $link->id,
                              'source_location' =>$request->source_location,
                        ]);
                  }
                  return response()->json([
                  'status'=>true,
                  'link'=>new LinkResources($link),
                  ],200); 
            }
            return response()->json([
                  'status'=>false,
                  'message'=>__('site.not_found'),
            ],400); 


      }
   
}
