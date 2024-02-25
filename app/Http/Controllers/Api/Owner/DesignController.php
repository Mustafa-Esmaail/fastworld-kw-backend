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
use Exception;

use App\Models\Owner;
use App\Models\Design;
use App\Http\Resources\DesignResources;
use App\Http\Traits\UploadFilesTrait;
use App\Http\Traits\CreateCode;

class DesignController extends Controller
{
   use UploadFilesTrait;
   use CreateCode;
   protected $owner;
   protected $model;
   public function __construct(Design $model)
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
            'id'   => 'required|exists:designs,id',
      ]);
      if($validator->fails())
      {
            return response()->json([
               'status'=>false,
               'message'=>$validator->errors(),
            ],400);
      }
      $Design=$this->model->find($request->id);
      if (!empty($Design)) 
      {
            return response()->json([
               'status'=>true,
               'Design'=>new DesignResources($Design),
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
         'Categories'=>DesignResources::collection($Categories)->response()->getData(true)
     ],200); 
    
   }
   public function store(Request $request)
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
            //   public_id
            $validator = Validator::make($request->all(), [
                'name'           => 'required|string|max:255|unique:designs,name' ,
                'category_id'    => 'required|exists:categories,id',
                'image'          => 'required|mimes:jpg,jpeg,png,gif,webp',
                'backgroundimage'=> 'nullable|mimes:jpg,jpeg,png,gif,webp',
            ]);
            if($validator->fails())
            {
                return response()->json([
                'status'=>false,
                'message'=>$validator->errors(),
                ],400);
            }
            $Design=$this->model->create([
                'name'            => $request->name,
                'category_id'     => $request->category_id,
                'image'           => $request->image != null ? self::uploadImage($request->file('image'),'designs') : null,
                'backgroundimage'           => $request->backgroundimage != null ? self::uploadImage($request->file('backgroundimage'),'designs') : null,
            ]);
            $Design->public_id=self::createCode(10);
            $Design->save();
            return response()->json([
            'status'=>true,
            'message'=>__('site.add_successfuly'),
            'Design'=>new DesignResources($Design),
             ],200);
        } catch (Exception $e) 
        {
            return response()->json([
                'status'=>false,
                'errors'=>$e->getMessage(),
                ],400); 
        }

   }
    
}


// export const light = 
// {
//     name: "light-theme",
//     colors: {
//       screenBgc: "hsl(60, 40%, 100%)",
//       generalText: "hsl(0, 0%, 93%)",
//       borderColor: "hsl(0, 0%, 87%)",
//       fieldsBgc: "hsl(0, 1%, 38%)",
//       fieldsText: "hsl(0, 1%, 16%)",
//       socialIcons: "hsl(0, 1%, 38%)",
//       boxShadows: "hsl(0, 1%, 38%)",
//     },
//     FontFace: {
//       textStyle: "Franklin Gothic Medium, Arial Narrow, Arial, sans-serif",
//     },
//     object: {
//       img: "url",
//       video: "url",
//       gradient: "",
//     },
//       borderStyle: {
//       borderType: "",
//       borderRidus: "",
//       borderSize: {
//         T: "",
//         R: "",
//         B: "",
//         L: "",
//       },
//       borderColor: "",
//     },
//     outlineStyle: {
//       outlineType: "",
//       outlineRidus: "",
//       outlineSize: {
//         T: "",
//         R: "",
//         B: "",
//         L: "",
//       },
//       outlineColor: "",
//     },
//     profileAlginment:{
//       justifyContent:"",
//       alignItems:"",
//       flexDirection:"",
//     },
//     socialAlginment:{
//       justifyContent:"",
//     },
// };
  
  
  
  
  