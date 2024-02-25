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
use App\Models\Link;
use App\Models\Information;
use App\Http\Resources\LinkResources;

class LinkController extends Controller
{ 
    protected $owner;
    protected $model;
    public function __construct(Link $model)
    {
            $this->owner=auth('owner')->user();
            $this->model=$model;
    }
   
    public function MyLinks()
    {
        if (empty($this->owner)) 
       {
         return response()->json([
             'status'=>false,
             'message'=>__('site.user_not_found'),
           ],400); 
       }
       
        $Links=  $this->owner->Links()->get();
        // $Links=  $this->owner->Links()->latest()->first();
        if (!empty($Links)) 
        {
            return response()->json([
                'status'=>true,  
                'Links'=>LinkResources::collection($Links)->response()->getData(true),
                // 'Links'=>new LinkResources($Links),
            ],200); 
        }
        return response()->json([
              'status'=>false,
              'message'=>__('site.not_found'),
        ],400); 
  
    }
    public function update_name(Request $request)
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
               'id'                       => 'required|exists:links,id',
               'name'                     => 'required|max:255|unique:links,public_id',

             ]);
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }
             $Link=$this->owner->Links
                                            //  ->where('design_id',$request->design_id)
                                             ->find($request->id);
              if (!empty($Link)) 
              {
              
                $Link->update([
                    'public_id' => $request->name,
                ]);
                return response()->json([
                    'status'=>true, 
                    'message'=>__('site.updat_successfuly'),
                     'Link'=>new LinkResources($Link),
                     ],200);
              }   else {
                return response()->json([
                    'status'=>false,
                    'message'=>__('site.not_found'),
                  ],400); 
              }                         
               
                              
         } catch (Exception $e) 
         {
             return response()->json([
                 'status'=>false,
                 'errors'=>$e->getMessage(),
                 ],400); 
         }
 
  
    }
}
