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
use App\Models\Category;
use App\Http\Resources\CategoryResources;
class CategoryController extends Controller
{
   protected $owner;
   protected $model;
   public function __construct(Category $model)
   {
          $this->owner=auth('owner')->user();
          $this->model=$model;
   }
   public function get(Request $request)
   {
      if (empty($this->owner)) 
      {
        return response()->json([
            'status'=>false,
            'message'=>__('site.user_not_found'),
          ],400); 
      }
      $validator = Validator::make($request->all(), [
            'id'   => 'required|exists:categories,id',
      ]);
      if($validator->fails())
      {
            return response()->json([
               'status'=>false,
               'message'=>$validator->errors(),
            ],400);
      }
      $category=$this->model->find($request->id);
      if (!empty($category)) 
      {
            return response()->json([
               'status'=>true,
               'category'=>new CategoryResources($category),
            ],200); 
      }
      return response()->json([
            'status'=>false,
            'message'=>__('site.not_found'),
      ],400); 

      
   }
   public function all()
   {
      if (empty($this->owner)) 
      {
        return response()->json([
            'status'=>false,
            'message'=>__('site.user_not_found'),
          ],400); 
      }

     $Categories=$this->model->get();
     return response()->json([
         'status'=>true,
         'Categories'=>CategoryResources::collection($Categories)->response()->getData(true)
     ],200); 
    
   }
    
}
