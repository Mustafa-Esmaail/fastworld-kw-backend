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
use App\Models\SocialIcon;
use App\Models\Icon;
use App\Http\Resources\InformationResources;
use App\Http\Resources\LinkResources;
use App\Http\Resources\LinkCustomResources;

use App\Http\Traits\UploadFilesTrait;
use App\Http\Traits\CreateCode;
use File;
class SocialController extends Controller
{
   
    use UploadFilesTrait;
    use CreateCode;
    protected $owner;
    protected $model;
    protected $contents_ids;
    public function __construct(Social $model)
    {
        $this->owner=auth('owner')->user();
        $this->model=$model;
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
              'type' => 'nullable|integer|min:0|max:5',
              'title' =>'nullable|string',
              'icon_name'=>'nullable|string',
            //   'title' =>[ Rule::requiredIf($request->social_icon_id==null),'string'],
              //'link' =>'required|url:http,https',
              'link' =>'nullable|url:http,https',
              'order' => 'nullable|integer|min:0|max:5',
              //'image' => [ Rule::requiredIf($request->social_icon_id==null),'image'],
              'image' => 'nullable|mimes:jpg,jpeg,png,gif,webp',
              'pid'  => 'nullable|string',
              'content_id'   =>['required', Rule::in($this->contents_ids)],
              //'social_icon_id'      =>[ Rule::requiredIf($request->image==null),'exists:social_icons,id'],
              'social_icon_id'      =>'nullable|exists:social_icons,id',
             ]);
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }
             $content=$this->owner->Contents->find($request->content_id);
             if ($content->type !='soial_icon') 
             {
                return response()->json([
                    'status'=>false,
                    'message'=>__('site.It is not available to add a social icon'),
                  ],400); 
             }

                if ($request->social_icon_id !=null)
                {

                    $Social=$this->model->create([
                        'type' => $request->type,
                        // 'title' =>$request->title,
                        //'icon_name' =>$request->icon_name,
                        'link' =>$request->link,
                        // 'order' => $request->order,
                        // 'image' => $request->image != null ? self::uploadImage($request->file('image'),'socials') : null,
                        // 'pid'  => $request->pid,
                        'content_id'   => $request->content_id,
                    ]);
                    $Icon=Icon::create([
                        'type'=>1,
                        'social_id'    =>  $Social->id,
                        'social_icon_id' => $request->social_icon_id,
                        // 'content_id'   => $request->content_id,
                    ]);
                    // return 4545;

                    $info=Content::find($request->content_id)->information;
                    return response()->json([
                        'status'=>true,
                        'message'=>__('site.add_successfuly'),
                        'Information'=>new InformationResources($info),
                        'link'=>new LinkCustomResources($info->Link ),
                         ],200);
       


                }

                $Social=$this->model->create([
                    'type' => $request->type,
                    'title' =>$request->title,
                    'icon_name' =>$request->icon_name,
                    'link' =>$request->link,
                    // 'order' => $request->order,
                    'image' => $request->image != null ? self::uploadImage($request->file('image'),'socials') : null,
                    // 'pid'  => $request->pid,
                    'content_id'   => $request->content_id,
                ]);
                $info=Content::find($request->content_id)->information;
                return response()->json([
                    'status'=>true,
                    'message'=>__('site.add_successfuly'),
                    'Information'=>new InformationResources($info),
                    'link'=>new LinkCustomResources($info->Link ),
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
              'content_id'   =>['required', Rule::in($this->contents_ids)],  
              'id'                => 'required|exists:socials,id',
              'type' => 'nullable|integer|min:0|max:5',
              'title' =>'nullable|string',
              'icon_name'=>'nullable|string',
            //   'title' =>[ Rule::requiredIf($request->social_icon_id==null),'string'],
              'link' =>'nullable|url:http,https',
              'order' => 'nullable|integer|min:0|max:5',
              'image' => 'nullable|image',
              'pid'      => 'nullable|string',
              'social_icon_id'      =>'nullable|exists:social_icons,id',
             ]);
              
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }
             
            $Social=$this->owner->contents->find($request->content_id)->socials()->find($request->id);
            if (!empty($Social))
            {
                if ($request->social_icon_id==null &&$request->image==null)
                {
                    
                    $Social->update([
                        'type'  => $request->type  !=null ? $request->type : $Social->type,
                        'title' =>$request->title  !=null ? $request->title: $Social->title,
                        'icon_name' =>$request->icon_name !=null ? $request->icon_name: $Social->icon_name,
                        // 'title' =>null,
                        'link'  =>$request->link   !=null ? $request->link : $Social->link,
                        // 'order' => $request->order,
                        //'image' => $request->image != null ? self::uploadImage($request->file('image'),'socials') : null,
                        // 'image' => null,
                        // 'pid'  => $request->pid,
                    ]);
                    $info=Content::find($request->content_id)->information;
                    return response()->json
                    ([
                        'status'=>true,
                        'message'=>__('site.update_successfuly'),
                        'Information'=>new InformationResources($info),
                        'link'=>new LinkCustomResources($info->Link ),
                    ],200);
                }
                if (!empty($request->social_icon_id))
                {
                    if (!empty($Social->Icon)) 
                    {
                        $Social->Icon->delete();
                    }
                    $Social->update([
                        'type'  => $request->type  !=null ? $request->type : $Social->type,
                        // 'title' =>$request->title  !=null ? $request->title: $Social->title,
                        'title' =>null,
                        'link'  =>$request->link   !=null ? $request->link : $Social->link,
                        // 'order' => $request->order,
                        //'image' => $request->image != null ? self::uploadImage($request->file('image'),'socials') : null,
                        // 'image' => null,
                        // 'pid'  => $request->pid,
                    ]);
                    if($Social->image != null)
                    {
                        if(File::exists(public_path('uploads/socials/'.$Social->image)))
                        {
                        File::delete(public_path('uploads/socials/'.$Social->image));
                        }
                        $Social->image=null;
                        $Social->save();
                    }
                    $Icon=Icon::create([
                        'type'=>1,
                        'social_id'    =>  $Social->id,
                        'social_icon_id' => $request->social_icon_id,
                        // 'content_id'   => $request->content_id,
                    ]);
                    $info=Content::find($request->content_id)->information;
                    return response()->json
                    ([
                        'status'=>true,
                        'message'=>__('site.update_successfuly'),
                        'Information'=>new InformationResources($info),
                        'link'=>new LinkCustomResources($info->Link ),
                    ],200);

                }
                if (!empty($Social->Icon)) 
                {
                    $Social->Icon->delete();
                }
                $Social->update([
                    'type'  => $request->type  !=null ? $request->type : $Social->type,
                    'title' =>$request->title  !=null ? $request->title: $Social->title,
                    'icon_name' =>$request->icon_name  !=null ? $request->icon_name: $Social->icon_name,
                    'link'  =>$request->link   !=null ? $request->link : $Social->link,
                    // 'order' => $request->order,
                    //'image' => $request->image != null ? self::uploadImage($request->file('image'),'socials') : null,
                    // 'pid'  => $request->pid,
                ]);
                if($request->hasFile('image'))
                {
                    
                    if($Social->image != null)
                    {
                    if(File::exists(public_path('uploads/socials/'.$Social->image)))
                    {
                        File::delete(public_path('uploads/socials/'.$Social->image));
                    }
                    
                    }
                    $Social->image=$request->image != null ? self::uploadImage($request->file('image'),'socials') : null;
                    $Social->save();
                }
                $info=Content::find($request->content_id)->information;
                return response()->json
                ([
                    'status'=>true,
                    'message'=>__('site.update_successfuly'),
                    'Information'=>new InformationResources($info),
                    'link'=>new LinkCustomResources($info->Link ),
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
                'content_id'   =>['required', Rule::in($this->contents_ids)],  
                'id'           => 'required|exists:socials,id',
             ]);
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }
             $Social=$this->owner->contents->find($request->content_id)->socials()->find($request->id);
            if (!empty($Social))
            {
                if($Social->image != null)
                {
                    if(File::exists(public_path('uploads/socials/'.$Social->image)))
                    {
                    File::delete(public_path('uploads/socials/'.$Social->image));
                    }
                     
                }
                if (!empty($Social->Icon))
                {
                    $Social->Icon->delete();
                }
                $Social->delete();
                return response()->json([
                    'status'=>true,
                    'message'=>__('site.delete_successfuly'),
                    // 'Information'=>new InformationResources($info),
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
