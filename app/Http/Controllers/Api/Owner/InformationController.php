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
use App\Models\Setting;
use App\Models\Link;
use App\Models\Information;
use App\Models\Obj;
use App\Http\Resources\InformationResources;
use App\Http\Resources\LinkResources;
use App\Http\Resources\LinkCustomResources;
use App\Http\Traits\UploadFilesTrait;
use App\Http\Traits\CreateCode;
use File;
class InformationController extends Controller
{
    use UploadFilesTrait;
    use CreateCode;
    protected $owner;
    protected $model;
    protected $informations_ids;
    public function __construct(Information $model)
    {
        $this->owner=auth('owner')->user();
        $this->model=$model;
        $this->informations_ids=!empty($this->owner->Informations)?$this->owner->Informations->pluck('id')->toArray():[];

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
             'id'   => 'required|exists:informations,id',
       ]);
       if($validator->fails())
       {
             return response()->json([
                'status'=>false,
                'message'=>$validator->errors(),
             ],400);
       }
       $information=$this->owner->Informations->find($request->id);
       if (!empty($information))  
       {
             $Link=Link::where('information_id',$information->id)->first();
             //$visits = $Link->Views()->where('link_id',$Link->id)->get()->count();
             return response()->json([
                 'status'=>true,
                 'message'=>__('site.add_successfuly'),
                 'Information'=>new InformationResources($information),
                 'link'=>new LinkCustomResources($information->Link),
                  ],200);   
       }
       return response()->json([
             'status'=>false,
             'message'=>__('site.not_found'),
       ],400); 
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
          // 'source'            => 'nullable|string',
          // 'domain'         => 'nullable|string',
          // 'link'           => 'nullable|url:http,https',
          // 'substate'       => 'nullable|integer|min:0|max:5',
          // 'dnstate'        => 'nullable|integer|min:0|max:5',
          // 'suffix'         => 'nullable|integer|min:0|max:5',
          'title'             => 'nullable|string', 
          // 'themeid'        => 'nullable|string',
          // 'path'           => 'nullable|string',
          // 'part'           => 'nullable|string',
          'description'       => 'nullable|string',
          'theme'             => 'nullable|array',
          // 'verified'          => 'nullable|string',
          // 'uid'               => 'nullable|string',
          // 'discover_state'    => 'nullable|integer|min:0|max:5',
          // 'state'             => 'nullable|integer|min:0|max:5',
          // 'version_state'     => 'nullable|integer|min:0|max:5',
          'img'                     => 'nullable|mimes:jpg,jpeg,png,gif,webp',
          'imgtwo'                    => 'nullable|mimes:jpg,jpeg,png,gif,webp',
          'image'             => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
          'background_image'             => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',

          // 'design_id'
          // 'owner_id'

          ]);
          if($validator->fails())
          {
              return response()->json([
              'status'=>false,
              'message'=>$validator->errors(),
              ],400);
          }//->Profile_setting->remove_brand 
          // return $this->owner->Profile_setting;
            $info=$this->model->create([
                            
              'source'            => $request->source,
              'substate'          => $request->substate,
              'dnstate'           => $request->dnstate,
              'suffix'            => $request->suffix,
              'title'             => $request->title,
              'path'              => $request->path,
              'part'              => $request->part,
              'description'       => $request->description,
              'theme'             => $request->theme,
              'verified'          => $request->verified,
              'uid'               => $request->uid,
              'discover_state'    => $request->discover_state,
              'state'             => $request->state,
              'version_state'     => $request->version_state,
              'cover'             => $request->image != null ? self::uploadImage($request->file('image'),'informations') : null,
              'background_image'  => $request->background_image != null ? self::uploadImage($request->file('background_image'),'informations') : null,
              'design_id'         => $request->design_id,
              'owner_id'          =>$this->owner->id,
            ]);
            $Link=Link::create([
                'public_id'      =>self::createCode(10),
                'information_id' =>$info->id,
                'owner_id'       =>$this->owner->id,
            ]);

            $Obj=Obj::create([
                'name'    =>  $request->name,
                'data'  =>  $request->data,
                'Container'  =>  $request->Container,
                'Contact'  =>  $request->Contact,
                'DivProfilePicture'  =>  $request->DivProfilePicture,
                'ProfilePicture'  =>  $request->ProfilePicture,
                'StyledButton'  =>  $request->StyledButton,
                'DivProfilePicture'  =>  $request->DivProfilePicture,
                'img'                    =>  $request->img != null ? self::uploadImage($request->file('img'),'Obj') : null,
                'imgtwo'                    =>  $request->imgtwo != null ? self::uploadImage($request->file('imgtwo'),'Obj') : null,
                'information_id'    =>$info->id,
            ]);
            $Link=Link::where('information_id',$info->id)->first();
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
    // public function store(Request $request)
    // {
    //   if (empty($this->owner)) 
    //   {
    //     return response()->json([
    //       'status'=>false,
    //       'message'=>__('site.user_not_found'),
    //     ],400); 
    //   }
    //   try
    //   {
    //       $validator = Validator::make($request->all(), [
    //       // 'source'            => 'nullable|string',
    //       // 'domain'         => 'nullable|string',
    //       // 'link'           => 'nullable|url:http,https',
    //       // 'substate'       => 'nullable|integer|min:0|max:5',
    //       // 'dnstate'        => 'nullable|integer|min:0|max:5',
    //       // 'suffix'         => 'nullable|integer|min:0|max:5',
    //       'title'             => 'nullable|string', 
    //       // 'themeid'        => 'nullable|string',
    //       // 'path'           => 'nullable|string',
    //       // 'part'           => 'nullable|string',
    //       'description'       => 'nullable|string',
    //       'theme'             => 'nullable|array',
    //       // 'verified'          => 'nullable|string',
    //       // 'uid'               => 'nullable|string',
    //       // 'discover_state'    => 'nullable|integer|min:0|max:5',
    //       // 'state'             => 'nullable|integer|min:0|max:5',
    //       // 'version_state'     => 'nullable|integer|min:0|max:5',
    //       'img'                     => 'nullable|mimes:jpg,jpeg,png,gif,webp',
    //       'imgtwo'                    => 'nullable|mimes:jpg,jpeg,png,gif,webp',
    //       'image'             => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
    //       'background_image'             => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',

    //       // 'design_id'
    //       // 'owner_id'

    //       ]);
    //       if($validator->fails())
    //       {
    //           return response()->json([
    //           'status'=>false,
    //           'message'=>$validator->errors(),
    //           ],400);
    //       }
    //         $info=$this->model->create([
                            
    //           'source'            => $request->source,
    //           'substate'          => $request->substate,
    //           'dnstate'           => $request->dnstate,
    //           'suffix'            => $request->suffix,
    //           'title'             => $request->title,
    //           'path'              => $request->path,
    //           'part'              => $request->part,
    //           'description'       => $request->description,
    //           'theme'             => $request->theme,
    //           'verified'          => $request->verified,
    //           'uid'               => $request->uid,
    //           'discover_state'    => $request->discover_state,
    //           'state'             => $request->state,
    //           'version_state'     => $request->version_state,
    //           'cover'             => $request->image != null ? self::uploadImage($request->file('image'),'informations') : null,
    //           'background_image'  => $request->background_image != null ? self::uploadImage($request->file('background_image'),'informations') : null,
    //           'design_id'         => $request->design_id,
    //           'owner_id'          =>$this->owner->id,
    //         ]);
    //         $Link=Link::create([
    //             'public_id'      =>self::createCode(10),
    //             'information_id' =>$info->id,
    //             'owner_id'       =>$this->owner->id,
    //         ]);

    //         $Obj=Obj::create([
    //             'name'    =>  $request->name,
    //             'data'  =>  $request->data,
    //             'Container'  =>  $request->Container,
    //             'Contact'  =>  $request->Contact,
    //             'DivProfilePicture'  =>  $request->DivProfilePicture,
    //             'ProfilePicture'  =>  $request->ProfilePicture,
    //             'StyledButton'  =>  $request->StyledButton,
    //             'DivProfilePicture'  =>  $request->DivProfilePicture,
    //             'img'                    =>  $request->img != null ? self::uploadImage($request->file('img'),'Obj') : null,
    //             'imgtwo'                    =>  $request->imgtwo != null ? self::uploadImage($request->file('imgtwo'),'Obj') : null,
    //             'information_id'    =>$info->id,
    //         ]);
    //         $Link=Link::where('information_id',$info->id)->first();
    //         return response()->json([
    //           'status'=>true,
    //           'message'=>__('site.add_successfuly'),
    //           'Information'=>new InformationResources($info),
    //           'link'=>new LinkCustomResources($info->Link),
    //         ],200);

        
    //   } catch (Exception $e) 
    //   {
    //     return response()->json([
    //       'status'=>false,
    //       'errors'=>$e->getMessage(),
    //     ],400); 
    //   }
    // }



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
                    'id'                      =>['required', Rule::in($this->informations_ids)],
                    // 'source'            => 'nullable|string',
                    // 'domain'         => 'nullable|string',
                    // 'link'           => 'nullable|url:http,https',
                    // 'substate'       => 'nullable|integer|min:0|max:5',
                    // 'dnstate'        => 'nullable|integer|min:0|max:5',
                    // 'suffix'         => 'nullable|integer|min:0|max:5',
                    'title'             => 'nullable|string', 
                    // 'themeid'        => 'nullable|string',
                    // 'path'           => 'nullable|string',
                    // 'part'           => 'nullable|string',
                    'description'       => 'nullable|string',
                    'theme'             => 'nullable|array',
                    // 'verified'          => 'nullable|string',
                    // 'uid'               => 'nullable|string',
                    // 'discover_state'    => 'nullable|integer|min:0|max:5',
                    // 'state'             => 'nullable|integer|min:0|max:5',
                    // 'version_state'     => 'nullable|integer|min:0|max:5',
                    'img'                     => 'nullable|mimes:jpg,jpeg,png,gif,webp',
                    'imgtwo'                    => 'nullable|mimes:jpg,jpeg,png,gif,webp',
                    'image'             => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
                    'background_image'             => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
             ]);
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }
             $info=$this->owner->Informations->where('owner_id',$this->owner->id)
                                            //  ->where('design_id',$request->design_id)
                                             ->find($request->id);
              if (!empty($info)) 
              {
                    $info->update([
                      'source'            => $request->source != null ?$request->source:$info->source,
                      'substate'          => $request->substate != null ?$request->substate:$info->substate,
                      'dnstate'           =>$request->dnstate != null ?$request->dnstate:$info->dnstate,
                      'suffix'            => $request->suffix != null ?$request->suffix:$info->suffix,
                      'title'             => $request->title != null ?$request->title:$info->title,
                      'path'              => $request->path != null ?$request->path:$info->path,
                      'part'              => $request->part != null ?$request->part:$info->part,
                      'description'       => $request->description != null ?$request->description:$info->description,
                      'theme'             => $request->theme != null ?$request->theme:$info->theme,
                      'verified'          => $request->verified != null ?$request->verified:$info->verified,
                      'uid'               => $request->uid != null ?$request->uid:$info->uid,
                      'discover_state'    => $request->discover_state != null ?$request->discover_state:$info->discover_state,
                      'state'             => $request->state != null ?$request->state:$info->state,
                      'version_state'     => $request->version_state != null ?$request->version_state:$info->version_state,
                      // 'cover'             => $request->image != null ? self::uploadImage($request->file('image'),'informations') : null,
                    ]);
                    $Obj=Obj::where('information_id',$info->id)->first();
                    $Obj->update([
                        'name'    => $request->name != null ?$request->name:$Obj->name,
                        'data'  =>  $request->data != null ?$request->data:$Obj->data,
                        'Container'  =>  $request->Container != null ?$request->Container:$Obj->Container,
                        'Contact'  => $request->Contact != null ?$request->Contact:$Obj->Contact,
                        'DivProfilePicture'  => $request->DivProfilePicture != null ?$request->DivProfilePicture:$Obj->DivProfilePicture,
                        'ProfilePicture'  => $request->ProfilePicture != null ?$request->ProfilePicture:$Obj->ProfilePicture,
                        'StyledButton'  => $request->StyledButton != null ?$request->StyledButton:$Obj->StyledButton,
                        'DivProfilePicture'  => $request->DivProfilePicture != null ?$request->DivProfilePicture:$Obj->DivProfilePicture,
                    ]);
                    if($request->hasFile('image'))
                    {
                        if($info->cover != null)
                        {
                          if(File::exists(public_path('uploads/informations/'.$info->cover)))
                          {
                            File::delete(public_path('uploads/informations/'.$info->cover));
                          }
                        
                        }
                        $info->cover=$request->image != null ? self::uploadImage($request->file('image'),'informations') : null;
                        $info->save();
                    }
                    
                    if ($request->background_image=='delete') 
                    {
                      if($info->background_image != null)
                      {
                        if(File::exists(public_path('uploads/informations/'.$info->background_image)))
                        {
                          File::delete(public_path('uploads/informations/'.$info->background_image));
                        }
                        $info->background_image = null;
                        $info->save();

                      }
                    }
                    if($request->hasFile('background_image'))
                    {
                        if($info->background_image != null)
                        {
                          if(File::exists(public_path('uploads/informations/'.$info->background_image)))
                          {
                            File::delete(public_path('uploads/informations/'.$info->background_image));
                          }
                        
                        }
                        $info->background_image=$request->background_image != null ? self::uploadImage($request->file('background_image'),'informations') : null;
                        $info->save();
                    }
                    // if ($request->backgroundimage=='delete') 
                    // {
                    //   if($info->backgroundimage != null)
                    //   {
                    //     if(File::exists(public_path('uploads/informations/'.$info->backgroundimage)))
                    //     {
                    //       File::delete(public_path('uploads/informations/'.$info->backgroundimage));
                    //     }
                    //     $info->backgroundimage = null;
                    //     $info->save();

                    //   }
                    // }
                    // if($request->hasFile('backgroundimage'))
                    // {
                    //     if($info->backgroundimage != null)
                    //     {
                    //       if(File::exists(public_path('uploads/informations/'.$info->backgroundimage)))
                    //       {
                    //         File::delete(public_path('uploads/informations/'.$info->backgroundimage));
                    //       }
                        
                    //     }
                    //     $info->backgroundimage=$request->backgroundimage != null ? self::uploadImage($request->file('backgroundimage'),'informations') : null;
                    //     $info->save();
                    // }
                    
                    if($request->hasFile('imgtwo'))
                    {
                        if($Obj->imgtwo != null)
                        {
                          if(File::exists(public_path('uploads/Obj/'.$Obj->imgtwo)))
                          {
                            File::delete(public_path('uploads/Obj/'.$Obj->imgtwo));
                          }
                          
                        }
                        $Obj->imgtwo=$request->imgtwo != null ? self::uploadImage($request->file('imgtwo'),'Obj') : null;
                        $Obj->save();
                    }
                    if($request->hasFile('img'))
                    {
                        if($Obj->img != null)
                        {
                          if(File::exists(public_path('uploads/Obj/'.$Obj->img)))
                          {
                            File::delete(public_path('uploads/Obj/'.$Obj->img));
                          }
                        
                        }
                        $Obj->img=$request->img != null ? self::uploadImage($request->file('img'),'Obj') : null;
                        $Obj->save();
                    }
                    $Link=Link::where('information_id',$info->id)->first();
                    return response()->json([
                        'status'=>true,
                        'message'=>__('site.update_successfuly'),
                        'Information'=>new InformationResources($info),
                        'link'=>new LinkCustomResources($info->Link),
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
               'id'                       => 'required|exists:informations,id',
             ]);
             if($validator->fails())
             {
                 return response()->json([
                 'status'=>false,
                 'message'=>$validator->errors(),
                 ],400);
             }
             $info=$this->owner->Informations->where('owner_id',$this->owner->id)
                                            //  ->where('design_id',$request->design_id)
                                             ->find($request->id);
              if (!empty($info)) 
              {
                $Obj=Obj::where('information_id',$info->id)->first();
                $Link=Link::where('information_id',$info->id)->first();
                $Link->delete();
                $Obj->delete();
                $info->delete();
                return response()->json([
                    'status'=>true,
                    'message'=>__('site.delete_successfuly'),
                    // 'Information'=>new InformationResources($info),
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








































































    // public function get(Request $request)
    // {
    //    if (empty($this->owner)) 
    //    {
    //      return response()->json([
    //          'status'=>false,
    //          'message'=>__('site.user_not_found'),
    //        ],400); 
    //    }
    //    $validator = Validator::make($request->all(), [
    //          'id'   => 'required|exists:informations,id',
    //    ]);
    //    if($validator->fails())
    //    {
    //          return response()->json([
    //             'status'=>false,
    //             'message'=>$validator->errors(),
    //          ],400);
    //    }
    //    $information=$this->owner->Informations->find($request->id);
    //    if (!empty($information)) 
    //    {
    //          $Link=Link::where('information_id',$information->id)->first();
    //          return response()->json([
    //              'status'=>true,
    //              'message'=>__('site.add_successfuly'),
    //              'Information'=>new InformationResources($information),
    //              'link'=>new LinkResources($Link),
    //               ],200);
    //    }
    //    return response()->json([
    //          'status'=>false,
    //          'message'=>__('site.not_found'),
    //    ],400); 
 
       
    // }
    // public function store(Request $request)
    // {
    //    if (empty($this->owner)) 
    //    {
    //      return response()->json([
    //          'status'=>false,
    //          'message'=>__('site.user_not_found'),
    //        ],400); 
    //    }
     
    //    try
    //      {
           
    //          $validator = Validator::make($request->all(), [
    //                 'title'                    => 'nullable|string',
    //                 'second_title'             => 'nullable|string',
    //                 'description'              => 'nullable|string',
    //                 'image'                    => 'nullable|mimes:jpg,jpeg,png,gif,webp',
    //                 'backgroundimage'          => 'nullable|mimes:jpg,jpeg,png,gif,webp',
                    
    //                 'img'                     => 'nullable|mimes:jpg,jpeg,png,gif,webp',
    //                 'imgtwo'                    => 'nullable|mimes:jpg,jpeg,png,gif,webp',
                    
    //                 'socials'	               =>'nullable|array' ,
    //                 'socials.*'                =>'nullable|url:http,https' ,
                    
    //                 'facebook'                 => 'nullable|url:http,https',
    //                 'youtube'                  => 'nullable|url:http,https',
    //                 'instgram'                 => 'nullable|url:http,https',
    //                 'x'                        => 'nullable|url:http,https',
    //                 'tiktok'                   => 'nullable|url:http,https',
    //                 'gmail'                    => 'nullable|url:http,https',
                    
    //                 'our_store'                => 'nullable|url:http,https',
    //                 'monicur_store'            => 'nullable|url:http,https',
    //                 'online_shop'              => 'nullable|url:http,https',
    //                 'online_store'             => 'nullable|url:http,https',
    //                 'shop'                     => 'nullable|url:http,https',
    //                 'shopee'                   => 'nullable|url:http,https',
    //                 'shop_products'            => 'nullable|url:http,https',
    //                 'shop_new'                 => 'nullable|url:http,https',
                    
    //                 'website'                  => 'nullable|url:http,https',
    //                 'video'                    => 'nullable|url:http,https',
    //                 'videos_title'             => 'nullable|string',
    //                 'videos_description'       => 'nullable|string',
                    
    //                 'services'                 => 'nullable|string',
    //                 'our_services'             => 'nullable|string',
                    
    //                 'about_studio'             => 'nullable|string',
    //                 'about_the_farm'           => 'nullable|string',
    //                 'about_us'                 => 'nullable|string',
    //                 'about_me'                 => 'nullable|string',
    //                 'about'                    => 'nullable|string',
                    
    //                 'contact_us'               => 'nullable|string',
    //                 'contact'                  => 'nullable|string',
                    
    //                 'plans_and_pricing'        => 'nullable|string',
    //                 'plans'                    => 'nullable|string',
                    
    //                 'book_online'              => 'nullable|string',
    //                 'book_aclass'              => 'nullable|string',
                    
    //                 'activities'               => 'nullable|string',
                    
    //                 'facilities'               => 'nullable|string',
    //                 'treatments'               => 'nullable|string',
    //                 'specials'                 => 'nullable|string',
    //                 'challenges'               => 'nullable|string',
    //                 'new_inventory'            => 'nullable|string',
    //                 'per_owned'                => 'nullable|string',
    //                 'financing'                => 'nullable|string',
    //                 'testimonials'             => 'nullable|string',
    //                 'faq'                      => 'nullable|string',
    //                 'workpalces'               => 'nullable|string',
    //                 'models'                   => 'nullable|string',
    //                 'info'                     => 'nullable|string',
    //                 'album'                    => 'nullable|string',
    //                 'vlog'                     => 'nullable|string',
    //                 'location'                 => 'nullable|string',
    //                 'phone'                    => 'nullable|string',
    //                 'our_member'               => 'nullable|string',
    //                 'sale_up_to_value'         => 'nullable|string',
    //                 'buy_one_get_one_free'     => 'nullable|string',
    //                 'get_discount'             => 'nullable|string',
    //                 'items'                    => 'nullable|string',
    //                 'contest'                  => 'nullable|string',
    //                 'follow_me'                => 'nullable|string',
    //                 'jouney'                   => 'nullable|string',
    //                 'strength'                 => 'nullable|string',
    //                 'bukalapak'                => 'nullable|string',
    //                 'lazada'                   => 'nullable|string',
    //                 'say_hello'                => 'nullable|string',
    //                 'training'                 => 'nullable|string',
    //                 'why_naturopathy'          => 'nullable|string',
    //                 'riders'                   => 'nullable|string',
    //                 'tokyo'                    => 'nullable|string',
    //                 'spotify'                  => 'nullable|string',
    //                 'soundcloud'               => 'nullable|string',
    //                 'vibe'                     => 'nullable|string',
    //                 'apple_music'              => 'nullable|string',
    //                 'tickets'                  => 'nullable|string',
    //                 'epk'                      => 'nullable|string',
    //                 'tour'                     => 'nullable|string',
    //                 'media'                    => 'nullable|string',
    //                 'seoul'                    => 'nullable|string',
    //                 'buy_me_ticket'            => 'nullable|string',
    //                 'deezer'                   => 'nullable|string',
    //                 'bandcamp'                 => 'nullable|string',
    //                 'audiomack'                => 'nullable|string',
    //                 'collection'               => 'nullable|string',
                    
    //                 'introduction'             => 'nullable|string',
                    
    //                 'photographer'             => 'nullable|string',
    //                 'our_team'                 => 'nullable|string',
    //                 'menu'                     => 'nullable|string',
    //                 'order'                    => 'nullable|string',
    //                 'rate_us'                  => 'nullable|string',
    //                 'store_address'            => 'nullable|string',
    //                 'relax'                    => 'nullable|string',
    //                 'pinterest'                => 'nullable|string',
    //                 'skype'                    => 'nullable|string',
    //                 'travel_vlog'              => 'nullable|string',
    //                 'homestay'                 => 'nullable|string',
    //                 'traveling'                => 'nullable|string',
    //                 'google_map'               => 'nullable|string',
    //                 'travel_resources'         => 'nullable|string',
                    
    //                 'portfolio'                => 'nullable|string',
    //                 'style'                    => 'nullable|string',
    //                 'discount'                 => 'nullable|string',
    //                 'show'                     => 'nullable|string',
    //                 'band'                     => 'nullable|string',
    //                 'summer_band'              => 'nullable|string',
    //                 'socials_description'      => 'nullable|string',
    //                 'blog'                     => 'nullable|string',
                    
    //                 'full_name'                => 'nullable|string',
    //                 'email'                    => 'nullable|string',
    //                 'title_of_send_email'      => 'nullable|string',
    //                 'footer_of_send_email'     => 'nullable|string',
    //                 'follower_and_style_list'  => 'nullable|string',
    //                 'design_id'                => 'nullable|exists:designs,id',
    //             //  'title'              => 'nullable|string|max:255' ,
    //             //  'description'        => 'nullable|string',
    //             //  'image'              => 'nullable|mimes:jpg,jpeg,png,gif,webp',
    //             // //  'facebook'           => 'nullable|url:http,https|max:255' ,
    //             // //  'instgram'           => 'nullable|url:http,https|max:255' ,
    //             // //  'x'                  => 'nullable|url:http,https|max:255' ,
    //             // //  'gmail'              => 'nullable|url:http,https|max:255' ,
    //             // //  'socials'
    //             // //  'socials'	             =>'nullable|array' ,
    //             // //  'socials.*'             =>'required',
    //             // //  'socials.*.id'          => 'required|exists:socials,id' ,
    //             // //  'socials.*.url'         => 'required|url:http,https' ,
                 
    //             //  'socials'	          =>'nullable|array' ,
    //             //  'socials.*'          =>'nullable|url:http,https' ,
    //             //  'online_store'       => 'nullable|url:http,https' ,
    //             //  'website'            => 'nullable|url:http,https' ,
    //             //  'videos'             => 'nullable|file|max:40000',
    //             //  'videos_description' => 'nullable|string' ,
    //             //  'contact_us'         => 'nullable|string|max:255' ,
    //             //  'design_id'          => 'required|exists:designs,id',

    //          ]);
    //          if($validator->fails())
    //          {
    //              return response()->json([
    //              'status'=>false,
    //              'message'=>$validator->errors(),
    //              ],400);
    //          }
    //         //  $info=$this->owner->Informations->where('owner_id',$this->owner->id)
    //         //                                  ->where('design_id',$request->design_id)
    //         //                                  ->first();
    //         //   if (empty($info)) 
    //         //   {
    //             $info=$this->model->create([
                                
    //                     'title'                    =>  $request->title,
    //                     'second_title'             =>  $request->second_title,
    //                     'description'              =>  $request->description,
    //                     'image'                    =>  $request->image != null ? self::uploadImage($request->file('image'),'informations') : null,
    //                     'backgroundimage'          =>  $request->backgroundimage != null ? self::uploadImage($request->file('backgroundimage'),'informations') : null,
    //                     'socials'	                 => $request->socials,

    //                     'facebook'                 =>  $request->facebook,
    //                     'youtube'                  =>  $request->youtube,
    //                     'instgram'                 =>  $request->instgram,
    //                     'x'                        =>  $request->x,
    //                     'tiktok'                   =>  $request->tiktok,
    //                     'gmail'                    =>  $request->gmail,

    //                     'our_store'                =>  $request->our_store,
    //                     'monicur_store'            =>  $request->monicur_store,
    //                     'online_shop'              =>  $request->online_shop,
    //                     'online_store'             =>  $request->online_store,
    //                     'shop'                     =>  $request->shop,
    //                     'shopee'                   =>  $request->shopee,
    //                     'shop_products'            => $request->shop_products,
    //                     'shop_new'                 =>  $request->shop_new,

    //                     'website'                  =>  $request->website,
    //                     'video'                    =>  $request->video,
    //                     'videos_title'             =>  $request->videos_title,
    //                     'videos_description'       =>  $request->videos_description,

    //                     'services'                 =>  $request->services,
    //                     'our_services'             =>  $request->our_services,

    //                     'about_studio'             =>  $request->about_studio,
    //                     'about_the_farm'           =>  $request->about_the_farm,
    //                     'about_us'                 =>  $request->about_us,
    //                     'about_me'                 =>  $request->about_me,
    //                     'about'                    =>  $request->about,

    //                     'contact_us'               =>  $request->contact_us,
    //                     'contact'                  =>  $request->contact,

    //                     'plans_and_pricing'        =>  $request->plans_and_pricing,
    //                     'plans'                    =>  $request->plans,

    //                     'book_online'              =>  $request->book_online,
    //                     'book_aclass'              =>  $request->book_aclass,

    //                     'activities'               =>  $request->activities,

    //                     'facilities'               =>  $request->facilities,
    //                     'treatments'               =>   $request->treatments,
    //                     'specials'                 =>  $request->specials,
    //                     'challenges'               =>  $request->challenges,
    //                     'new_inventory'            =>  $request->new_inventory,
    //                     'per_owned'                =>  $request->per_owned,
    //                     'financing'                =>  $request->financing,
    //                     'testimonials'             =>  $request->testimonials,
    //                     'faq'                      =>  $request->faq,
    //                     'workpalces'               =>  $request->workpalces,
    //                     'models'                   =>  $request->models,
    //                     'info'                     =>  $request->info,
    //                     'album'                    =>  $request->album,
    //                     'vlog'                     =>  $request->vlog,
    //                     'location'                 =>  $request->location,
    //                     'phone'                    =>  $request->phone,
    //                     'our_member'               =>  $request->our_member,
    //                     'sale_up_to_value'         =>  $request->sale_up_to_value,
    //                     'buy_one_get_one_free'     =>  $request->buy_one_get_one_free,
    //                     'get_discount'             =>  $request->get_discount,
    //                     'items'                    =>  $request->items,
    //                     'contest'                  =>  $request->contest,
    //                     'follow_me'                =>  $request->follow_me,
    //                     'jouney'                   =>  $request->jouney,
    //                     'strength'                 =>  $request->strength,
    //                     'bukalapak'                =>  $request->bukalapak,
    //                     'lazada'                   =>  $request->lazada,
    //                     'say_hello'                =>  $request->say_hello,
    //                     'training'                 =>  $request->training,
    //                     'why_naturopathy'          =>  $request->why_naturopathy,
    //                     'riders'                   =>  $request->riders,
    //                     'tokyo'                    =>  $request->tokyo,
    //                     'spotify'                  =>  $request->spotify,
    //                     'soundcloud'               =>  $request->soundcloud,
    //                     'vibe'                     =>  $request->vibe,
    //                     'apple_music'              =>  $request->apple_music,
    //                     'tickets'                  =>  $request->tickets,
    //                     'epk'                      =>  $request->epk,
    //                     'tour'                     =>  $request->tour,
    //                     'media'                    =>  $request->media,
    //                     'seoul'                    =>  $request->seoul,
    //                     'buy_me_ticket'            =>  $request->buy_me_ticket,
    //                     'deezer'                   =>  $request->deezer,
    //                     'bandcamp'                 =>  $request->bandcamp,
    //                     'audiomack'                =>  $request->audiomack,
    //                     'collection'               =>  $request->collection,

    //                     'introduction'             =>  $request->introduction,

    //                     'photographer'             =>  $request->photographer,
    //                     'our_team'                 =>  $request->our_team,
    //                     'menu'                     =>  $request->menu,
    //                     'order'                    =>  $request->order,
    //                     'rate_us'                  =>  $request->rate_us,
    //                     'store_address'            =>  $request->store_address,
    //                     'relax'                    =>  $request->relax,
    //                     'pinterest'                =>  $request->pinterest,
    //                     'skype'                    =>  $request->skype,
    //                     'travel_vlog'              =>  $request->travel_vlog,
    //                     'homestay'                 =>  $request->homestay,
    //                     'traveling'                =>  $request->traveling,
    //                     'google_map'               =>  $request->google_map,
    //                     'travel_resources'         =>  $request->travel_resources,

    //                     'portfolio'                =>  $request->portfolio,
    //                     'style'                    =>  $request->style,
    //                     'discount'                 =>  $request->discount,
    //                     'show'                     =>  $request->show,
    //                     'band'                     =>  $request->band,
    //                     'summer_band'              =>  $request->summer_band,
    //                     'socials_description'      =>  $request->socials_description,
    //                     'blog'                     =>  $request->blog,

    //                     'full_name'                =>  $request->full_name,
    //                     'email'                    =>  $request->email,
    //                     'title_of_send_email'      =>  $request->title_of_send_email,
    //                     'footer_of_send_email'     =>  $request->footer_of_send_email,
    //                     'follower_and_style_list'  =>  $request->follower_and_style_list,
    //                     'design_id'                 => $request->design_id,
    //                     'owner_id'                   =>$this->owner->id,
    //             ]);
    //             $Link=Link::create([
    //                'public_id'      =>self::createCode(10),
    //                'information_id' =>$info->id,
    //                'owner_id'       =>$this->owner->id,
    //             ]);

    //             $Obj=Obj::create([
    //                 'name'    =>  $request->name,
    //                 'data'  =>  $request->data,
    //                 'Container'  =>  $request->Container,
    //                 'Contact'  =>  $request->Contact,
    //                 'DivProfilePicture'  =>  $request->DivProfilePicture,
    //                 'ProfilePicture'  =>  $request->ProfilePicture,
    //                 'StyledButton'  =>  $request->StyledButton,
    //                 'DivProfilePicture'  =>  $request->DivProfilePicture,
    //                 'img'                    =>  $request->img != null ? self::uploadImage($request->file('img'),'Obj') : null,
    //                 'imgtwo'                    =>  $request->imgtwo != null ? self::uploadImage($request->file('imgtwo'),'Obj') : null,
    //                 'information_id'    =>$info->id,
    //                 // 'name'             =>  $request->name,
    //                 // 'colors'           =>  $request->colors,
    //                 // 'FontFace'         =>  $request->FontFace,
    //                 // 'object'           =>  $request->object,
    //                 // 'borderStyle'      =>  $request->borderStyle,
    //                 // 'outlineStyle'     =>  $request->outlineStyle,
    //                 // 'profileAlginment' =>  $request->profileAlginment,
    //                 // 'socialAlginment'  =>  $request->socialAlginment,
    //                 // 'owner_id'       =>$this->owner->id,

    //             ]);
    //             $Link=Link::where('information_id',$info->id)->first();
    //             return response()->json([
    //                 'status'=>true,
    //                 'message'=>__('site.add_successfuly'),
    //                 'Information'=>new InformationResources($info),
    //                 'link'=>new LinkResources($Link),
    //                  ],200);
   
    //         //   }else
    //         //   {

    //         //     // $request_data = $request->except(['image','design_id','owner_id']);
    //         //     if (!empty($info->image)) 
    //         //     {
    //         //         if ($request->image != null) 
    //         //         {
    //         //             if(file_exists(public_path('uploads/informations/'.$info->image)))
    //         //             {
    //         //                 unlink(public_path('uploads/informations/'.$info->image));
    //         //             }
    //         //         //   $request->image =$request->image != null ? self::uploadImage($request->file('image'),'informations'):null;
    //         //         }
    //         //     } 
    //         //     $info->update([
    //         //         'title'                    =>  $request->title,
    //         //        
    //         //     ]);
    //         //     $Obj=Obj::where('information_id',$info->id)->first();
    //         //     $Obj->update([
    //         //         'name'    =>  $request->name,
    //         //         'data'  =>  $request->data,
    //         //         'Container'  =>  $request->Container,
    //         //         'Contact'  =>  $request->Contact,
    //         //         'DivProfilePicture'  =>  $request->DivProfilePicture,
    //         //         'ProfilePicture'  =>  $request->ProfilePicture,
    //         //         'StyledButton'  =>  $request->StyledButton,
    //         //         'DivProfilePicture'  =>  $request->DivProfilePicture,
    //         //         // 'name'             =>  $request->name,
    //         //         // 'colors'           =>  $request->colors,
    //         //         // 'FontFace'         =>  $request->FontFace,
    //         //         // 'object'           =>  $request->object,
    //         //         // 'borderStyle'      =>  $request->borderStyle,
    //         //         // 'outlineStyle'     =>  $request->outlineStyle,
    //         //         // 'profileAlginment' =>  $request->profileAlginment,
    //         //         // 'socialAlginment'  =>  $request->socialAlginment,
    //         //     ]);
    //         //     return response()->json([
    //         //         'status'=>true,
    //         //         'message'=>__('site.add_successfuly'),
    //         //         'Information'=>new InformationResources($info),
    //         //          ],200);
    //         //   }                              
    //      } catch (Exception $e) 
    //      {
    //          return response()->json([
    //              'status'=>false,
    //              'errors'=>$e->getMessage(),
    //              ],400); 
    //      }
 
    // }

   

}



// 'title'                    =>  $request->title,
// 'second_title'             =>  $request->second_title,
// 'description'              =>  $request->description,
// 'image'                    =>  $request->image,

// 'socials'	               => $request->socials,

// 'facebook'                 =>  $request->facebook,
// 'youtube'                  =>  $request->youtube,
// 'instgram'                 =>  $request->instgram,
// 'x'                        =>  $request->x,
// 'tiktok'                   =>  $request->tiktok,
// 'gmail'                    =>  $request->gmail,

// 'our_store'                =>  $request->our_store,
// 'monicur_store'            =>  $request->monicur_store,
// 'online_shop'              =>  $request->online_shop,
// 'online_store'             =>  $request->online_store,
// 'shop'                     =>  $request->shop,
// 'shopee'                   =>  $request->shopee,
// 'shop_products'            => $request->shop_products,
// 'shop_new'                 =>  $request->shop_new,

// 'website'                  =>  $request->website,
// 'video'                    =>  $request->video,
// 'videos_title'             =>  $request->videos_title,
// 'videos_description'       =>  $request->videos_description,

// 'services'                 =>  $request->services,
// 'our_services'             =>  $request->our_services,

// 'about_studio'             =>  $request->about_studio,
// 'about_the_farm'           =>  $request->about_the_farm,
// 'about_us'                 =>  $request->about_us,
// 'about_me'                 =>  $request->about_me,
// 'about'                    =>  $request->about,

// 'contact_us'               =>  $request->title,
// 'contact'                  =>  $request->title,

// 'plans_and_pricing'        =>  $request->title,
// 'plans'                    =>  $request->title,

// 'book_online'              =>  $request->title,
// 'book_aclass'              =>  $request->title,

// 'activities'               =>  $request->title,

// 'facilities'               =>  $request->title,
// 'treatments'               =>   $request->title,
// 'specials'                 =>  $request->title,
// 'challenges'               =>  $request->title,
// 'new_inventory'            =>  $request->title,
// 'per_owned'                =>  $request->title,
// 'financing'                =>  $request->title,
// 'testimonials'             =>  $request->title,
// 'faq'                      =>  $request->title,
// 'workpalces'               =>  $request->title,
// 'models'                   =>  $request->title,
// 'info'                     =>  $request->title,
// 'album'                    =>  $request->title,
// 'vlog'                     =>  $request->title,
// 'location'                 =>  $request->title,
// 'phone'                    =>  $request->title,
// 'our_member'               =>  $request->title,
// 'sale_up_to_value'         =>  $request->title,
// 'buy_one_get_one_free'     =>  $request->title,
// 'get_discount'             =>  $request->title,
// 'items'                    =>  $request->title,
// 'contest'                  =>  $request->title,
// 'follow_me'                =>  $request->title,
// 'jouney'                   =>  $request->title,
// 'strength'                 =>  $request->title,
// 'bukalapak'                =>  $request->title,
// 'lazada'                   =>  $request->title,
// 'say_hello'                =>  $request->title,
// 'training'                 =>  $request->title,
// 'why_naturopathy'          =>  $request->title,
// 'riders'                   =>  $request->title,
// 'tokyo'                    =>  $request->title,
// 'spotify'                  =>  $request->title,
// 'soundcloud'               =>  $request->title,
// 'vibe'                     =>  $request->title,
// 'apple_music'              =>  $request->title,
// 'tickets'                  =>  $request->title,
// 'epk'                      =>  $request->title,
// 'tour'                     =>  $request->title,
// 'media'                    =>  $request->title,
// 'seoul'                    =>  $request->title,
// 'buy_me_ticket'            =>  $request->title,
// 'deezer'                   =>  $request->title,
// 'bandcamp'                 =>  $request->title,
// 'audiomack'                =>  $request->title,
// 'collection'               =>  $request->title,

// 'introduction'             =>  $request->title,

// 'photographer'             =>  $request->title,
// 'our_team'                 =>  $request->title,
// 'menu'                     =>  $request->title,
// 'order'                    =>  $request->title,
// 'rate_us'                  =>  $request->title,
// 'store_address'            =>  $request->title,
// 'relax'                    =>  $request->title,
// 'pinterest'                =>  $request->title,
// 'skype'                    =>  $request->title,
// 'travel_vlog'              =>  $request->title,
// 'homestay'                 =>  $request->title,
// 'traveling'                =>  $request->title,
// 'google_map'               =>  $request->title,
// 'travel_resources'         =>  $request->title,

// 'portfolio'                =>  $request->title,
// 'style'                    =>  $request->title,
// 'discount'                 =>  $request->title,
// 'show'                     =>  $request->title,
// 'band'                     =>  $request->title,
// 'summer_band'              =>  $request->title,
// 'socials_description'      =>  $request->title,
// 'blog'                     =>  $request->title,

// 'full_name'                =>  $request->title,
// 'email'                    =>  $request->title,
// 'title_of_send_email'      =>  $request->title,
// 'footer_of_send_email'     =>  $request->title,
// 'follower_and_style_list'  =>  $request->title,
// 'design_id'                =>  $request->title,






// 'title'               => $request->title,
// 'description'         => $request->description,
// 'image'               => $request->image != null ? self::uploadImage($request->file('image'),'informations') : null,
// //  'facebook'            => $request->facebook,
// //  'instgram'            => $request->instgram,
// //  'x'                   => $request->x,
// //  'gmail'               => $request->gmail,
// 'socials'             => $request->socials,
// 'online_store'        => $request->online_store,
// 'website'             => $request->website,
// 'video'               => $request->videos!= null ? self::uploadvideo($request->file('image'),'informations') : null,
// 'videos_description'  => $request->videos_description,
// 'contact_us'          => $request->contact_us,
// 'design_id'           => $request->design_id,
// 'owner_id'            =>$this->owner->id,

// {
//     "code": 0,
//     "data": {
//         "basic": {
//             "source": "",
//             "domain": "linkfly.to",
//             "link": "511180ptMdR",
//             "id": "511180ptMdR",
//             "substate": 1,
//             "dnstate": 1,
//             "suffix": 1,
//             "title": "NANCY  PERFUME SHOP",
//             "themeid": 148,
//             "path": "color_29",
//             "part": 1,
//             "cover": "https://d351p1jxpt6hnn.cloudfront.net/2020071003/1594355939914.png",
//             "desc": "",
//             "theme": "{\"theme\": {\"tid\": null, \"path\": null, \"font\": null, \"textColor\": null, \"titleColor\": \"#ffffff\", \"descColor\": \"#ffffff\"}, \"layout\": {\"block\": {\"style\": null, \"corner\": null, \"border\": null}, \"colors\": {\"background\": null, \"opacity\": null, \"text\": null, \"border\": null, \"shadow\": null}, \"thumbnail\": {\"style\": null, \"radius\": null, \"color\": null}, \"button\": {\"backgroundColor\": null, \"textColor\": null}}, \"background\": {\"key\": null, \"color\": null, \"style\": null, \"color1\": null, \"color2\": null, \"color3\": null, \"direction\": null, \"image\": null, \"blur\": null, \"opacity\": null, \"link\": null}, \"other\": {\"profile\": {\"style\": null, \"size\": null, \"corner\": null, \"border\": null}, \"social\": {\"style\": null, \"align\": null, \"color\": \"\"}, \"divider\": {\"style\": null, \"align\": null, \"thickness\": null, \"width\": null}}}",
//             "verified": "",
//             "uid": "50924fdgmn9",
//             "discover_state": 0,
//             "state": 1,
//             "version_state": 1
//         },
        
//         },
       
       
        
//         "contents": [
//             {
//                 "id": "btn-51118gToVVsdD",
//                 "type": 1,
//                 "state": 1,
//                 "image": "",
//                 "link": "",
//                 "embed": "",
//                 "title": "fddfd",
//                 "text": "",
//                 "order": 10,
//                 "desc": "fddddddddddd",
//                 "subtype": "cmpt-button-buttonLink",
//                 "subtitle": "",
//                 "path": "",
//                 "buttons": [
//                     {
//                         "id": 5275755,
//                         "link": "cxcxcx",
//                         "title": "My website",
//                         "desc": null,
//                         "icon": "https://fly.linkcdn.cc/statics/links/btn-socials/gmail.png",
//                         "type": 1,
//                         "subtype": 0,
//                         "source_id": "",
//                         "featured": 0,
//                         "tcolor": "",
//                         "bcolor": "",
//                         "link1": "cxcxcx",
//                         "link2": "",
//                         "state": 1,
//                         "scheduled": 0,
//                         "start": "",
//                         "end": "",
//                         "text": "",
//                         "path": ""
//                     },
//                     {
//                         "id": 5275756,
//                         "link": "",
//                         "title": "Shop now",
//                         "desc": null,
//                         "icon": "",
//                         "type": 1,
//                         "subtype": 0,
//                         "source_id": "",
//                         "featured": 0,
//                         "tcolor": "",
//                         "bcolor": "",
//                         "link1": "",
//                         "link2": "",
//                         "state": 1,
//                         "scheduled": 0,
//                         "start": "",
//                         "end": "",
//                         "text": "",
//                         "path": ""
//                     },
//                     {
//                         "id": 5275757,
//                         "link": "",
//                         "title": "Blog",
//                         "desc": null,
//                         "icon": "",
//                         "type": 1,
//                         "subtype": 0,
//                         "source_id": "",
//                         "featured": 0,
//                         "tcolor": "",
//                         "bcolor": "",
//                         "link1": "",
//                         "link2": "",
//                         "state": 1,
//                         "scheduled": 0,
//                         "start": "",
//                         "end": "",
//                         "text": "",
//                         "path": ""
//                     },
//                     {
//                         "id": 5275758,
//                         "link": "",
//                         "title": "Contact us",
//                         "desc": null,
//                         "icon": "",
//                         "type": 1,
//                         "subtype": 0,
//                         "source_id": "",
//                         "featured": 0,
//                         "tcolor": "",
//                         "bcolor": "",
//                         "link1": "",
//                         "link2": "",
//                         "state": 1,
//                         "scheduled": 0,
//                         "start": "",
//                         "end": "",
//                         "text": "",
//                         "path": ""
//                     }
//                 ]
//             },
//             {
//                 "id": "scl-512031mpbZxaK",
//                 "type": 2,
//                 "state": 1,
//                 "image": "",
//                 "link": "",
//                 "embed": "",
//                 "title": null,
//                 "text": "",
//                 "order": 1,
//                 "desc": "",
//                 "subtype": "",
//                 "subtitle": "",
//                 "path": "",
//                 "socials": [
//                     {
//                         "id": 3907789,
//                         "type": 71,
//                         "title": "",
//                         "link": "https://www.facebook.com/mahammedeldeeb",
//                         "order": 1,
//                         "image": "",
//                         "pid": "scl-512031mpbZxaK"
//                     },
//                     {
//                         "id": 3907790,
//                         "type": 53,
//                         "title": "",
//                         "link": "https://www.facebook.com/profile.php?id=100009140219911",
//                         "order": 1,
//                         "image": "",
//                         "pid": "scl-512031mpbZxaK"
//                     }
//                 ]
//             },
//             {
//                 "id": "scl-512044bPG8MGd",
//                 "type": 2,
//                 "state": 1,
//                 "image": "",
//                 "link": "",
//                 "embed": "",
//                 "title": null,
//                 "text": "",
//                 "order": 1,
//                 "desc": "",
//                 "subtype": "",
//                 "subtitle": "",
//                 "path": "",
//                 "socials": [
//                     {
//                         "id": 3910233,
//                         "type": 46,
//                         "title": "",
//                         "link": "",
//                         "order": 1,
//                         "image": "",
//                         "pid": "scl-512044bPG8MGd"
//                     }
//                 ]
//             },
//             {
//                 "id": "form-51204z0byUUIm",
//                 "type": 5,
//                 "state": 1,
//                 "image": "",
//                 "link": "",
//                 "embed": "",
//                 "title": "Contact us",
//                 "text": "{\"fields\":[{\"key\":\"email\",\"required\":1,\"services\":null,\"sync\":0,\"title\":\"Email\"},{\"key\":\"input\",\"required\":0,\"services\":null,\"sync\":0,\"title\":\"Full Name\"}],\"submit\":{\"btn_text\":\"Submit\",\"thanks_text\":\"Thanks for submitting!\"},\"title\":\"Contact us\",\"themes\":[],\"bio\":{\"uid\":\"50924fdgmn9\",\"pro\":1,\"pg\":1,\"logoshow\":2}}",
//                 "order": 1,
//                 "desc": "",
//                 "subtype": "",
//                 "subtitle": "",
//                 "path": ""
//             }
//         ],
//         "orders": [
//             "btn-51118gToVVsdD",
//             "scl-512031mpbZxaK",
//             "scl-512044bPG8MGd",
//             "form-51204z0byUUIm"
//         ],
//         "other": {}
//     },
//     "msg": "SUCCESS"