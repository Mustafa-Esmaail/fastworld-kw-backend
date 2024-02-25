<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use App\Models\Owner;
use App\Models\Setting;

class SettingController extends Controller
{
    protected $owner;
    protected $model;
    protected $settings_ids;
    public function __construct(Setting $model)
    {
        $this->owner=auth('owner')->user();
        $this->model=$model;
        $this->settings_ids=!empty($this->owner->Profile_setting)?$this->owner->Profile_setting->pluck('id')->toArray():[];

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
          'remove_brand'             => ['nullable', Rule::in(['0' ,'1' ])],
          ]);
          if($validator->fails())
          {
              return response()->json([
              'status'=>false,
              'message'=>$validator->errors(),
              ],400);
          }
            $set=$this->model->create([
                            
              'remove_brand'            => $request->remove_brand,
              'owner_id'          =>$this->owner->id,
            ]);

            return response()->json([
              'status'=>true,
              'message'=>__('site.add_successfuly'),
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
          //'id'                       =>'required|exists:social_icons,id',
          // 'id'                       =>['required', Rule::in($this->settings_ids)],
          'remove_brand'             => ['nullable', Rule::in(['0' ,'1' ])],
          ]);
          if($validator->fails())
          {
              return response()->json([
              'status'=>false,
              'message'=>$validator->errors(),
              ],400);
          }

          // $set=$this->owner->Profile_setting->where('owner_id',$this->owner->id)->find($request->id);
          $set=$this->owner->Profile_setting;
          if (!empty($set)){
            $set->update([ 
                'remove_brand'  => $request->remove_brand != null ?$request->remove_brand:$set->remove_brand,
                ]);
            }

            return response()->json([
              'status'=>true,
              'message'=>__('site.update_successfuly'),
            ],200);
        } 

        catch (Exception $e) 
        {
            return response()->json([
            'status'=>false,
            'errors'=>$e->getMessage(),
            ],400); 
        }
    }
    public function get()
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
      // $set=$this->owner->Profile_setting->where('owner_id',$this->owner->id)->find($request->id);
      $set=$this->owner->Profile_setting;
      $remove_brand=$set->remove_brand;
        return response()->json([
          'status'=>true,
          'remove_brand'=>$remove_brand,
        ],200);
      } 

      catch (Exception $e) 
      {
          return response()->json([
          'status'=>false,
          'errors'=>$e->getMessage(),
          ],400); 
      }
  }
}
