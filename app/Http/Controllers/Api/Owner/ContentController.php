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
use App\Models\Obj;
use App\Models\Content;
use App\Models\Button;
use App\Models\Social;
use App\Http\Resources\InformationResources;
use App\Http\Resources\LinkResources;
use App\Http\Resources\LinkCustomResources;

use App\Http\Traits\UploadFilesTrait;
use App\Http\Traits\CreateCode;
use File;
class ContentController extends Controller
{
   
    use UploadFilesTrait;
    use CreateCode;
    protected $owner;
    protected $model;
    protected $informations_ids;
    protected $contents_ids;
    public function __construct(Content $model)
    {
        $this->owner=auth('owner')->user();
        $this->model=$model;
        $this->informations_ids=!empty($this->owner->Informations)?$this->owner->Informations->pluck('id')->toArray():[];
        $this->contents_ids=!empty($this->owner->Contents)?$this->owner->Contents->pluck('id')->toArray():[];

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

             $validator = Validator::make($request->all(), [
                'information_id'    =>['required', Rule::in($this->informations_ids)],
                'type'           =>['required', Rule::in(['buttons' ,'header' ,'video','form','soial_icon' ,'youtub_subscibe','music' ,'tiktok'
                ,'request','graphext','facebook_page' ,'podcast'  ,'typeform' ,'divider'
                 ])],
                'state' => 'nullable|integer|min:0|max:5',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
                'link' => 'nullable|url:http,https',
                // 'embed' => 'nullable|string',
                'text' => 'nullable|array',
                //'order' => 'nullable|integer|min:0|max:5',
                'title' => 'nullable|string',
                'subtitle' => 'nullable|string',
                'description' => 'nullable|string',
                'subtype' => 'nullable|string',
                'path' => 'nullable|string',

             ]);
             
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }
                $Content=$this->model->create([
                    'type'             => $request->type,
                    // 'state'            => $request->state,
                    'image'            => $request->image != null ? self::uploadImage($request->file('image'),'Contents') : null,
                    'link'             => $request->link,
                    // 'embed'            => $request->embed,
                    'text'             => $request->text,
                    // 'order'            => $request->order,
                    'title'            => $request->title,
                    'subtitle'         => $request->subtitle,
                    'description'      => $request->description,
                    'subtype'          => $request->subtype,
                    'path'             => $request->path,
                    'information_id'   => $request->information_id,
                    'owner_id'       =>$this->owner->id,

                ]);
                  
                $info=Information::find($request->information_id);
                // $Link=Link::where('information_id',$info->id)->first();
                //return $info->Link;
                $order=$info->Contents()->orderBy('created_at', 'ASC')->get()->pluck('id')->toArray();
                return response()->json([
                    'status'=>true,
                    'message'=>__('site.add_successfuly'),
                    'Information'=>new InformationResources($info),
                    //'link'=>new LinkCustomResources($info->Link),
                ],200);
                
   
           
         } catch (Exception $e) 
         {
             return response()->json([
                 'status'=>false,
                 'errors'=>$e->getMessage(),
                 ],400); 
         }
 
    }

    public function update(Request $request)
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
                'id'                =>['required', Rule::in($this->contents_ids)],
                'type'           =>['required', Rule::in(['buttons' ,'header' ,'video','form','soial_icon' ,'youtub_subscibe','music' ,'tiktok'
                ,'request','graphext','facebook_page' ,'podcast'  ,'typeform' ,'divider'
                 ])],
                'state' => 'nullable|integer|min:0|max:5',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
                'link' => 'nullable|url:http,https',
                // 'embed' => 'nullable|string',
                'text' => 'nullable|array',
                //'order' => 'nullable|integer|min:0|max:5',
                'title' => 'nullable|string',
                'subtitle' => 'nullable|string',
                'description' => 'nullable|string',
                'subtype' => 'nullable|string',
                'path' => 'nullable|string',

             ]);
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }

             $Content=$this->owner->contents->find($request->id);
             
             if (!empty($Content))
            {
                $Content->update([
                    'type'             => $request->type !=null ? $request->type:$Content->type,
                    // 'state'            => $request->state !=null ? $request->state:$Content->state,
                    // 'image'            => $request->image != null ? self::uploadImage($request->file('image'),'Contents') : null,
                    'link'             =>$request->link !=null ? $request->link:$Content->link,
                    // 'embed'            =>$request->embed !=null ? $request->embed:$Content->embed,
                    'text'             => $request->text !=null ? $request->text:$Content->text,
                    // 'order'            => $request->order !=null ? $request->order:$Content->order,
                    'title'            => $request->title !=null ? $request->title:$Content->title,
                    'subtitle'         =>$request->subtitle !=null ? $request->subtitle:$Content->subtitle,
                    'description'      => $request->description !=null ? $request->description:$Content->description,
                    'subtype'          =>$request->subtype !=null ? $request->subtype:$Content->subtype,
                    'path'             => $request->path !=null ? $request->path:$Content->path,
                    // 'information_id'   => $request->information_id,
                    // 'owner_id'         =>$this->owner->id,
    
                ]);
                if($request->hasFile('image'))
                {
                    if($Content->image != null)
                    {
                      if(File::exists(public_path('uploads/Contents/'.$Content->image)))
                      {
                        File::delete(public_path('uploads/Contents/'.$Content->image));
                      }
                     
                    }
                    $Content->image=$request->image != null ? self::uploadImage($request->file('image'),'Contents') : null;
                    $Content->save();
                }
                $info=Information::find($Content->information_id);
                $order=$info->Contents()->orderBy('created_at', 'ASC')->get()->pluck('id')->toArray();
                return response()->json([
                    'status'=>true,
                    'message'=>__('site.update_successfuly'),
                    'Information'=>new InformationResources($info),
                    //'link'=>new LinkCustomResources($info->Link),
                    'orders'=>$order,

                     ],200);
            } else
            {
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

    public function delete(Request $request)
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
                'id'                =>['required', Rule::in($this->contents_ids)],
             ]);
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }
             
             $Content=$this->owner->contents->find($request->id);
             if (!empty($Content))
            {
                
                $Socials=$Content->socials;
                if (!empty($Socials))
                {
                    foreach ($Socials as $Social) 
                    {
                        if($Social->image != null)
                        {
                            if(File::exists(public_path('uploads/socials/'.$Social->image)))
                            {
                                File::delete(public_path('uploads/socials/'.$Social->image));
                            }
                            
                        }
                        $icon = $Social->Icon;
                        if (!empty($icon))
                        {
                            $icon->delete();
                        }
                        //$Social->Icon->delete();
                        $Social->delete();
                    }
                } 
                
                $Buttons=$Content->buttons;
                if (!empty($Buttons))
                {
                    foreach ($Buttons as $Button) 
                    {
                        if($Button->icon != null)
                        {
                            if(File::exists(public_path('uploads/buttons/'.$Button->icon)))
                            {
                                File::delete(public_path('uploads/buttons/'.$Button->icon));
                            }
                        }    
                        $Button->delete();
                    }
                }
                    
                if($Content->image != null)
                {
                    if(File::exists(public_path('uploads/Contents/'.$Content->image)))
                    {
                    File::delete(public_path('uploads/Contents/'.$Content->image));
                    }
                    
                }
                $Content->delete();
                
                return response()->json([
                    'status'=>true,
                    'message'=>__('site.delete_successfuly'),
                ],200);
            } 
            else
            {
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
