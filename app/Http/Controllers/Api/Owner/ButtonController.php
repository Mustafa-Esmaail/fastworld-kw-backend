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
class ButtonController extends Controller
{
   
    use UploadFilesTrait;
    use CreateCode;
    protected $owner;
    protected $model;
    protected $contents_ids;
    public function __construct(Button $model)
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
                //'link'         =>'nullable|url:http,https',
                'link'         =>'nullable|string',
                'title'        =>'nullable|string',
                'icon_name'        =>'nullable|string',
                'description'  =>'nullable|string',
                // 'icon'         => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
                // 'icon' => [ Rule::requiredIf($request->social_icon_id==null),'image'],
                // 'social_icon_id'      =>[ Rule::requiredIf($request->icon==null),'exists:social_icons,id'],
                'icon' => 'nullable|image',
                'social_icon_id'      =>'nullable|exists:social_icons,id',
                
                'type'           =>['required', Rule::in( [
                    'link_url'
                    ,'video'
                    ,'google_map'
                    ,'contact_details'
                    ,'form'
                ])],
                'subtype'      => 'nullable|integer|min:0|max:5',
                // 'source_id' =>'nullable|string',
                // 'featured'  =>'nullable|string',
                'tcolor'      =>'nullable|string',
                'bcolor'      =>'nullable|string',
                // 'link1'       =>'required|url:http,https',
                // 'link2'       =>'nullable|url:http,https',
                'link1'       =>'required|string',
                'link2'       =>'nullable|string',
                'state'       => 'nullable|integer|min:0|max:5',
                'scheduled'   => 'nullable|integer|min:0|max:5',
                'start'       =>'nullable|string',
                'end'         =>'nullable|string',
                'text'        =>'nullable|array',
                'path'        =>'nullable|string',
                'content_id'   =>['required', Rule::in($this->contents_ids)],


             ]);
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }      
             $content=$this->owner->Contents->find($request->content_id);
             if ($content->type !='buttons') 
             {
                return response()->json([
                    'status'=>false,
                    'message'=>__('site.It is not available to add a buttons'),
                  ],400); 
             }
             if ($request->social_icon_id !=null)
             {
                $Button=$this->model->create([
                    'title'        =>$request->title,
                    'icon_name'        =>$request->icon_name,
                    'description'  =>$request->description,
                    'type'         => $request->type, 
                    'subtype'      => $request->subtype,
                    // 'source_id' =>$request->source_id,
                    // 'featured'  =>$request->featured,
                    'tcolor'      =>$request->tcolor,
                    'bcolor'      =>$request->bcolor,
                    'link1'       =>$request->link1,
                    'link2'       =>$request->link2,
                    'state'       => $request->state,
                    'scheduled'   => $request->scheduled,
                    'start'       =>$request->start,
                    'end'         =>$request->end,
                    'text'        =>$request->text,
                    'path'        =>$request->path,
                    'content_id'   =>$request->content_id,
                ]);
                $Icon=Icon::create([
                    'type'=>2,
                    'button_id'    =>  $Button->id,
                    'social_icon_id' => $request->social_icon_id,
                ]);
                $info=Content::find($request->content_id)->information;
                return response()->json([
                    'status'=>true,
                    'message'=>__('site.add_successfuly'),
                    'Information'=>new InformationResources($info),
                    'link'=>new LinkCustomResources($info->Link),
                ],200);
             }
             $Button=$this->model->create([
                'title'        =>$request->title,
                'icon_name'        =>$request->icon_name,
                'description'  =>$request->description,
                'icon'         => $request->icon != null ? self::uploadImage($request->file('icon'),'buttons') : null,
                'type'         => $request->type, 
                'subtype'      => $request->subtype,
                // 'source_id' =>$request->source_id,
                // 'featured'  =>$request->featured,
                'tcolor'      =>$request->tcolor,
                'bcolor'      =>$request->bcolor,
                'link1'       =>$request->link1,
                'link2'       =>$request->link2,
                'state'       => $request->state,
                'scheduled'   => $request->scheduled,
                'start'       =>$request->start,
                'end'         =>$request->end,
                'text'        =>$request->text,
                'path'        =>$request->path,
                'content_id'   =>$request->content_id,
            ]);
            $info=Content::find($request->content_id)->information;
            return response()->json([
                'status'=>true,
                'message'=>__('site.add_successfuly'),
                'Information'=>new InformationResources($info),
                'link'=>new LinkCustomResources($info->Link),
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
                'content_id'         =>['required', Rule::in($this->contents_ids)],
                'id'                => 'required|exists:buttons,id',

                //'link'         =>'nullable|url:http,https',
                'link'         =>'nullable|string',
                'title'        =>'nullable|string',
                'icon_name'        =>'nullable|string',
                'description'  =>'nullable|string',
                'social_icon_id'      =>'nullable|exists:social_icons,id',
                'icon'         => 'nullable|image',
                'type'           =>['nullable', Rule::in( [
                    'link_url'
                    ,'video'
                    ,'google_map'
                    ,'contact_details'
                    ,'form'
                ])],
                'subtype'      => 'nullable|integer|min:0|max:5',
                // 'source_id' =>'nullable|string',
                // 'featured'  =>'nullable|string',
                'tcolor'      =>'nullable|string',
                'bcolor'      =>'nullable|string',
                // 'link1'       =>'nullable|url:http,https',
                // 'link2'       =>'nullable|url:http,https',
                'link1'       =>'nullable|string',
                'link2'       =>'nullable|string',
                'state'       => 'nullable|integer|min:0|max:5',
                'scheduled'   => 'nullable|integer|min:0|max:5',
                'start'       =>'nullable|string',
                'end'         =>'nullable|string',
                'text'        =>'nullable|array',
                'path'        =>'nullable|string',
             ]);
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }
            $Button=$this->owner->contents->find($request->content_id)->Buttons()->find($request->id);
            if (!empty($Button))
            {
                if ($request->social_icon_id==null &&$request->icon==null)
                {
                    $Button->update([
                        'title'         => $request->title !=null ? $request->title:$Button->title,
                        'icon_name'        =>$request->icon_name !=null ? $request->icon_name:$Button->icon_name,
                        'description'   => $request->description !=null ? $request->description:$Button->description,
                        'type'         => $request->type !=null ? $request->type:$Button->type,
                        'subtype'       => $request->subtype !=null ? $request->subtype:$Button->subtype,
                        // 'source_id'  => $request->source_id !=null ? $request->source_id:$Button->source_id,
                        // 'featured'   => $request->featured !=null ? $request->featured:$Button->featured,
                        'tcolor'       => $request->tcolor !=null ? $request->tcolor:$Button->tcolor,
                        'bcolor'       => $request->bcolor !=null ? $request->bcolor:$Button->bcolor,
                        'link1'        => $request->link1 !=null ? $request->link1:$Button->link1,
                        'link2'        => $request->link2 !=null ? $request->link2:$Button->link2,
                        'state'       => $request->state !=null ? $request->state:$Button->state,
                        'scheduled'   => $request->scheduled !=null ? $request->scheduled:$Button->scheduled,
                        'start'       => $request->start !=null ? $request->start:$Button->start,
                        'end'         => $request->end !=null ? $request->end:$Button->end,
                        'text'         => $request->text !=null ? $request->text:$Button->text,
                        'path'       => $request->path !=null ? $request->path:$Button->path,
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
                    if (!empty($Button->Icon_social)) 
                    {
                        $Button->Icon_social->delete();
                    }
                   
                    $Button->update([
                        'title'         => $request->title !=null ? $request->title:$Button->title,
                        'icon_name'        =>$request->icon_name !=null ? $request->icon_name:$Button->icon_name,
                        'description'   => $request->description !=null ? $request->description:$Button->description,
                        // 'icon'           => null, 
                        'type'         => $request->type !=null ? $request->type:$Button->type,
                        'subtype'       => $request->subtype !=null ? $request->subtype:$Button->subtype,
                        // 'source_id'  => $request->source_id !=null ? $request->source_id:$Button->source_id,
                        // 'featured'   => $request->featured !=null ? $request->featured:$Button->featured,
                        'tcolor'       => $request->tcolor !=null ? $request->tcolor:$Button->tcolor,
                        'bcolor'       => $request->bcolor !=null ? $request->bcolor:$Button->bcolor,
                        'link1'        => $request->link1 !=null ? $request->link1:$Button->link1,
                        'link2'        => $request->link2 !=null ? $request->link2:$Button->link2,
                        'state'       => $request->state !=null ? $request->state:$Button->state,
                        'scheduled'   => $request->scheduled !=null ? $request->scheduled:$Button->scheduled,
                        'start'       => $request->start !=null ? $request->start:$Button->start,
                        'end'         => $request->end !=null ? $request->end:$Button->end,
                        'text'         => $request->text !=null ? $request->text:$Button->text,
                        'path'       => $request->path !=null ? $request->path:$Button->path,
                    ]);
                    if($Button->icon != null)
                    {
                        if(File::exists(public_path('uploads/buttons/'.$Button->icon)))
                        {
                        File::delete(public_path('uploads/buttons/'.$Button->icon));
                        }
                        $Button->icon=null;
                        $Button->save();
                    }
                    $Icon=Icon::create([
                        'type'=>2,
                        'button_id'    =>  $Button->id,
                        'social_icon_id' => $request->social_icon_id,
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
                if (!empty($Button->Icon_social)) 
                {
                    $Button->Icon_social->delete();
                }
                $Button->update([
                    'title'         => $request->title !=null ? $request->title:$Button->title,
                    'description'   => $request->description !=null ? $request->description:$Button->description,
                    'type'         => $request->type !=null ? $request->type:$Button->type,
                    'subtype'       => $request->subtype !=null ? $request->subtype:$Button->subtype,
                    // 'source_id'  => $request->source_id !=null ? $request->source_id:$Button->source_id,
                    // 'featured'   => $request->featured !=null ? $request->featured:$Button->featured,
                    'tcolor'       => $request->tcolor !=null ? $request->tcolor:$Button->tcolor,
                    'bcolor'       => $request->bcolor !=null ? $request->bcolor:$Button->bcolor,
                    'link1'        => $request->link1 !=null ? $request->link1:$Button->link1,
                    'link2'        => $request->link2 !=null ? $request->link2:$Button->link2,
                    'state'       => $request->state !=null ? $request->state:$Button->state,
                    'scheduled'   => $request->scheduled !=null ? $request->scheduled:$Button->scheduled,
                    'start'       => $request->start !=null ? $request->start:$Button->start,
                    'end'         => $request->end !=null ? $request->end:$Button->end,
                    'text'         => $request->text !=null ? $request->text:$Button->text,
                    'path'       => $request->path !=null ? $request->path:$Button->path,
                ]);
                if($request->hasFile('icon'))
                {
                    if($Button->icon != null)
                    {
                    if(File::exists(public_path('uploads/buttons/'.$Button->icon)))
                    {
                        File::delete(public_path('uploads/buttons/'.$Button->icon));
                    }
                    
                    }
                    $Button->icon=$request->icon != null ? self::uploadImage($request->file('icon'),'buttons') : null;
                    $Button->save();
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
                'content_id'         =>['required', Rule::in($this->contents_ids)],
                'id'                => 'required|exists:buttons,id',
             ]);
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }
             $Button=$this->owner->contents->find($request->content_id)->Buttons()->find($request->id);
             
            if (!empty($Button))
            {
                if($Button->icon != null)
                    {
                      if(File::exists(public_path('uploads/buttons/'.$Button->icon)))
                      {
                        File::delete(public_path('uploads/buttons/'.$Button->icon));
                      }
                     
                }
                $info=Content::find($request->content_id)->information;
                $Button->delete();
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
