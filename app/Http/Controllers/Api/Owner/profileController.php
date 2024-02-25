<?php

namespace App\Http\Controllers\Api\Owner;
use App\Http\Resources\OwnerResource;
use App\Http\Resources\VarificationProfileResource;
use App\Http\Resources\VarificationIconResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Traits\SendSmsMessage;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Models\Owner;
use App\Models\Setting;
use App\Models\VarificationProfile;
use App\Models\VarificationIcon;
use JWTAuth;
use Auth;
use App\Http\Traits\UploadFilesTrait;
use App\Http\Traits\CreateVerifyCode;
use Exception;
use App\Models\OwnerVerifyEmail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use File;

class profileController
{
    use SendSmsMessage;
    use UploadFilesTrait;
    use CreateVerifyCode;

    public function getProfile()
    {
        $owner = auth('owner')->user();
        if (empty($owner)) 
          {
            return response()->json([
                'status'=>false,
                'message'=>__('site.user_not_found'),
            ]);
          }
          //$varified_icon = $owner->varification_profiles;  
        return response()->json([
            'status'  => true,
            'owner' => new OwnerResource($owner),
            //'varified_icon' => $owner->varification_profiles,

            //'varified_icon' => new VarificationIconResource($varified_icon),
        ], 200);

    }
    public function updateProfile(Request $request)
    {
        $owner = auth('owner')->user();
        if (empty($owner)) 
          {
            return response()->json([
                'status'=>false,
                'message'=>__('site.user_not_found'),
            ]);
          }
           
        $validator = Validator::make($request->all(), [
            'avater'        => 'required|mimes:png,jpg,jpeg,gif',
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                'errors'=> $validator->errors(),
            ], 402);
        }
        if($request->hasFile('avater'))
        { 
            if($owner->avater != null)
            {
                if(File::exists(public_path('uploads/owners/'.$owner->avater)))
                {
                    File::delete(public_path('uploads/owners/'.$owner->avater));
                }
            }
            $owner->avater=self::uploadImage($request->file('avater') ,'owners');
            $owner->save();
        }
        return response()->json([
            'status'  => true,
            'message' =>__('site.Updated Successfully'),
            'owner' => new OwnerResource ($owner),
        ], 200);

    }

    
    public function changePassword(Request $request)
    {
        $owner = auth('owner')->user();
        if (empty($owner)) 
          {
            return response()->json([
                'status'=>false,
                'message'=>__('site.user_not_found'),
            ]);
          }
        $validator = Validator::make($request->all(), [
            'oldPassword'             => 'required|string|min:5',
            'password'                => 'required|string|min:6',
            'password_confirmation'   => 'required|string|same:password',
        ]);

        if($validator->fails()){
            return response()->json([
                "status"    => false,
                'message'   => $validator->errors(),
            ], 400);
        }
        if(Hash::check($request->oldPassword, $owner->password)){
            $owner->password  = Hash::make($request->get('password'));
            $owner->save();
            return response()->json([
                'status'  => true,
                'message' => __('site.password change Successfully'),
            ], 200);

        } else {
            return response()->json([
                'status'  => false,
                'message' => __('site.old password is wrong'),
            ], 400);
        }
    }




    public function deleteProfile(Request $request)
    {

        // return $request;
        try {
            if (! $owner = auth('owner')->user()) {
                return response()->json([
                    'status'  => false,
                    'message' => __('site.user_not_found'),
    
                ], 200);
            }

        } catch (TokenExpiredException $e) {
            return response()->json([
                'status'  => false,
                'message' => __('site.token_expired'),

            ], 200);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status'  => false,
                'message' => __('site.token_invalid'),

            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status'  => false,
                'message' => __('site.token_absent'),

            ], 200);
        }


        $validator = Validator::make($request->all(), [
            'password'                  => 'nullable|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'  => false,
                'message' =>$validator->errors(),
            ], 200);
        }

        if (!Hash::check( $request->password, $owner->password)) {
            return response()->json([
                'status'  => false,
                'message' => __('site.wrong password'),
            ], 200);
         }
         $owner->delete();
        if($owner->avater !=null)
        {
            $avater = $owner->avater;
            if(file_exists(base_path('public/uploads/owners/') . $avater)){
                unlink(base_path('public/uploads/owners/') . $avater);
            }   
        }
        $student->avater= base_path('public\uploads\owners\default.png') ;  
        if($owner->trashed()){
            return response()->json([
                "status" => false,
                'message'=> __('site.delete profile success'),
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                'message'=> __('site.delete profile falid'),
            ], 400);
          
        }
    }
    public function add_second_email(Request $request) 
    {
        try {
            if (! $owner = auth('owner')->user()) {
                return response()->json([
                    'status'  => false,
                    'message' => __('site.user_not_found'),
    
                ], 200);
            }

        } catch (TokenExpiredException $e) {
            return response()->json([
                'status'  => false,
                'message' => __('site.token_expired'),

            ], 200);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status'  => false,
                'message' => __('site.token_invalid'),

            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status'  => false,
                'message' => __('site.token_absent'),

            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'email'         => 'required|email|max:255|unique:owners,email' ,
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                'message'=> $validator->errors(),
            ], 400);
        }
        $owner->update([
            'email_second'  => $request->email,
            ]);

        $token=self::createToken(new OwnerVerifyEmail());
        OwnerVerifyEmail::create([
            'email'=>$owner->email_second,
            'token'=>$token,
            'type'=>1,
        ]);
        try
        {
            Mail::to($owner->email_second)->send(new VerifyEmail($token));
            return response()->json([
                "status"    => true,
                // 'token'=>$token,
                'owner'  =>__('site.Message_Send_To_Your_email_By_token'),
            ], 200);
        } catch (Exception $ex)
        {
            return response()->json([
                "status" => false,
                'message'=>  $ex->getMessage(),
            ], 400);
            // Debug via $ex->getMessage();
        }
        // return response()->json([
        //     "status"    => true,
        //     'owner'  =>__('site.email_add_succfully'),
        // ], 200);
    }
    public function verify_second_email(Request $request) 
    {
        try {
            if (! $owner = auth('owner')->user()) {
                return response()->json([
                    'status'  => false,
                    'message' => __('site.user_not_found'),
    
                ], 200);
            }

        } catch (TokenExpiredException $e) {
            return response()->json([
                'status'  => false,
                'message' => __('site.token_expired'),

            ], 200);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status'  => false,
                'message' => __('site.token_invalid'),

            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status'  => false,
                'message' => __('site.token_absent'),

            ], 200);
        }
        $validator = Validator::make($request->all(), [
            'token'    => 'required|exists:owner_verify_emails,token',
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => false,
                'errors'=> $validator->errors(),
            ], 402);
        }

        $email_verify=OwnerVerifyEmail::where('type',1)->where('token',$request->token)->first();
        $owner=Owner::where('email_second',$email_verify->email)->first();

        if(empty($email_verify) || empty($owner))
        {
            return response()->json([
                "status" => false,
                'message'=> __('site.no_records'),
            ], 400);
        }
        $owner->verify_second_email=true;
        $owner->save();
        $email_verify->delete();

        $token = JWTAuth::fromUser($owner);
        return response()->json([
           "status" => true,
           'owner'   =>new OwnerResource($owner),
           'token'  => $token,
       ], 200);
    }
}
