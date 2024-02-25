<?php
namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\OwnerResource;
use App\Models\Owner;
use App\Models\Setting;
use App\Models\OwnerVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Traits\SendSmsMessage;
use App\Http\Traits\UploadFilesTrait;
use App\Http\Traits\CreateVerifyCode;
use Illuminate\Validation\Rule;
use App\Mail\VerifyEmail;
use App\Mail\ForgetPassword;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\OwnerRequest;
use Exception;
class RegisterController extends Controller
{
    use SendSmsMessage;
    use UploadFilesTrait;
    use CreateVerifyCode;
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email'         => 'required|email|max:255|unique:owners,email' ,
            'password'      => 'required|confirmed|min:6|max:255',
            // "device_token"  => 'nullable',
            'avater'        => 'nullable|mimes:jpg,jpeg,png,gif,webp',
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                'message'=> $validator->errors(),
            ], 400);
        }
        $owner=Owner::create([
                'email'            => $request->email,
                'password'         => bcrypt($request->password),
                // "device_token"     => $request->device_token,
                'avater'        => $request->avater != null ? self::uploadImage($request->file('avater'),'owners') : null,
            ]);
        $set=Setting::create([
                        
            'remove_brand'            => 0,
            'owner_id'                =>$owner->id,
        ]); 
        $token=self::createToken(new OwnerVerifyEmail());
        OwnerVerifyEmail::create([
            'email'=>$owner->email,
            'token'=>$token,
            'type'=>0,
        ]);
        try
        {
            Mail::to($owner->email)->send(new VerifyEmail($token));
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
       
    }

    public function verifyEmailToRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'    => 'required|exists:owner_verify_emails,token',
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => false,
                'errors'=> $validator->errors(),
            ], 402);
        }

        $email_verify=OwnerVerifyEmail::where('type',0)->where('token',$request->token)->first();
        $owner=Owner::where('email',$email_verify->email)->first();

        if(empty($email_verify) || empty($owner))
        {
            return response()->json([
                "status" => false,
                'message'=> __('site.no_records'),
            ], 400);
        }
        $owner->verify_account=true;
        $owner->save();
        $email_verify->delete();

        $token = JWTAuth::fromUser($owner);
        return response()->json([
           "status" => true,
           'owner'   =>new OwnerResource($owner),
           'token'  => $token,
       ], 200);

    }

    public function resndVerifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|exists:owners,email',
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                'errors'=> $validator->errors(),
            ], 402);
        }
        OwnerVerifyEmail::where('email',$request->email)->delete();
        $owner=Owner::where('email',$request->email)->first();

        if(empty($owner))
        {
            return response()->json([
                "status" => false,
                'message'=> __('site.user_not_found'),
            ], 402);
        }
        $token=self::createToken(new OwnerVerifyEmail());
        OwnerVerifyEmail::create([
            'email'=>$owner->email,
            'token'=>$token,
        ]);
        try
        {
            Mail::to($owner->email)->send(new VerifyEmail($token));
            return response()->json([
                "status"    => true,
                'owner'  =>__('site.Message_Send_To_Your_email_By_token'),
            ], 200);
        } catch (Exception $ex)
        {
            return response()->json([
                "status" => false,
                'message'=>  $ex->getMessage(),
            ], 400);
        }
      
    }
    public function sociallogin(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            //'facebook_id'    => 'nullable|integer',
            //'google_id'    => 'nullable|integer',
            //'google_id' => 'nullable|numeric|digits:21',
            // 'social_id'    => 'required|integer',
            // 'email'         => 'nullable|email|max:255|unique:owners,email' ,
            //'password'      => 'required|confirmed|min:6|max:255',
            // "device_token"  => 'nullable',
            'facebook_id'    => 'nullable|numeric',
            'google_id' => 'nullable|numeric',
            'avater'        => 'nullable|mimes:jpg,jpeg,png,gif,webp',
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                'errors'=> $validator->errors(),
            ], 402);
        }


        
        if ( $request->facebook_id !==null) {
            $Owner_f = Owner::where('facebook_id',$request->facebook_id)->first();
            if (!empty($Owner_f)) 
            {
                $token = JWTAuth::fromUser($Owner_f);
                return response()->json([
                    "status" => true,
                    'type'   =>'login',
                    'token'  => $token,
                ], 200);
            }
            $owner=Owner::create([
                'facebook_id'            => $request->facebook_id,
                // 'email'            => $request->email,
                //'password'         => bcrypt($request->password),
                // "device_token"     => $request->device_token,
                'avater'        => $request->avater != null ? self::uploadImage($request->file('avater'),'owners') : null,
            ]);
            
            $set=Setting::create([
                        
                'remove_brand'            => 0,
                'owner_id'                =>$owner->id,
            ]); 
            
            $token = JWTAuth::fromUser($owner);
            return response()->json([
                "status" => true,
                'type'   =>'register',
                'token'  => $token,
            ], 200);
        }
        if ($request->google_id !==null) {
            $Owner_g = Owner::where('google_id',$request->google_id)->first();
            if (!empty($Owner_g)) 
            {
                $token = JWTAuth::fromUser($Owner_g);
                return response()->json([
                    "status" => true,
                    'type'   =>'login',
                    'token'  => $token,
                ], 200);
            }
            $owner=Owner::create([
                'google_id'            => $request->google_id,
                // 'email'            => $request->email,
                //'password'         => bcrypt($request->password),
                // "device_token"     => $request->device_token,
                'avater'        => $request->avater != null ? self::uploadImage($request->file('avater'),'owners') : null,
            ]);
    
            $token = JWTAuth::fromUser($owner);
            return response()->json([
                "status" => true,
                'type'   =>'register',
                'token'  => $token,
            ], 200);
        }
        return response()->json([
            'status'=>false,
            'messege'   =>__('site.enter valid facebook user or google'),
        ],400);
    }

}