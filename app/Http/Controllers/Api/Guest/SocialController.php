<?php

namespace App\Http\Controllers\Api\Guest;
use App\Http\Resources\SocialResources;
use App\Http\Resources\SocialIconResources;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\UploadFilesTrait;
use App\Http\Traits\CreateCode;
use App\Models\Social;
use App\Models\Icon;
use App\Models\SocialIcon;
class SocialController extends Controller
{
   
    // use UploadFilesTrait;
    // use CreateCode;
    // protected $owner;
    protected $model;
    public function __construct(SocialIcon $model)
    {
            // $this->owner=auth('owner')->user();
            $this->model=$model;
    }
    
    public function get(Request $request)
    {
       $Social= $this->model->find($request->id);
       if (!empty($Social)) 
       {
             return response()->json([
                'status'=>true,
                'Social'=>new SocialIconResources($Social),
             ],200); 
       }
       return response()->json([
             'status'=>false,
             'message'=>__('site.not_found'),
       ],400); 
 
       
    }
    public function all()
    { 
       //$Socials=$this->model->get();
       $Socials=$this->model->where('social_categorie_id',1)->get();
       $online_store=$this->model->where('social_categorie_id',2)->get();
       $contact=$this->model->where('social_categorie_id',3)->get();
       //$uploaded_icon=$this->model->icons->first();
        return response()->json([
            'status'=>true,
            'Social-media'=>SocialIconResources::collection($Socials)->response()->getData(true),
            'online-store'=>SocialIconResources::collection($online_store)->response()->getData(true),
            'contact'=>SocialIconResources::collection($contact)->response()->getData(true),
            //'uploaded_icon'=>SocialIconResources::collection($uploaded_icon)->response()->getData(true),
            //'uploaded_icon1'=>SocialResources::collection($uploaded_icon)->response()->getData(true)
        ],200); 
       
    }
}
