<?php
namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\OwnerResource;
use App\Models\Owner;
use App\Models\OwnerVerifyEmail;
use App\Models\OwnerForgetPassword;
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
class forgetpasswordController extends Controller
{
    use SendSmsMessage;
    use UploadFilesTrait;
    use CreateVerifyCode;
    public function forgetpassword(Request $request)
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
        OwnerForgetPassword::where('email',$request->email)->delete();
        $owner=Owner::where('email',$request->email)->first();

        if(empty($owner))
        {
            return response()->json([
                "status" => false,
                'message'=> __('site.user_not_found'),
            ], 402);
        }
        $token=self::createToken(new OwnerForgetPassword());
        OwnerForgetPassword::create([
            'email'=>$owner->email,
            'token'=>$token,
        ]);
        try
        {
            Mail::to($owner->email)->send(new ForgetPassword($token));
            return response()->json([
                "status"    => true,
                'owner'  =>__('site.Message_Send_To_Your_email_By_token_to_reset_password'),
            ], 200);
        } catch (Exception $ex)
        {
            return response()->json([
                "status" => false,
                'message'=>  $ex->getMessage(),
            ], 400);
        }
      
    }
    public function resetforgetpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'    => 'required|exists:owner_forget_passwords,token',
            'password'                => 'required|string|min:6',
            'password_confirmation'   => 'required|string|same:password',
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => false,
                'errors'=> $validator->errors(),
            ], 402);
        } 
        $OwnerForgetPassword=OwnerForgetPassword::where('token',$request->token)->first();
        $owner=Owner::where('email',$OwnerForgetPassword->email)->first();
        if(empty($OwnerForgetPassword) || empty($owner))
        {
            return response()->json([
                "status" => false,
                'message'=> __('site.no_records'),
            ], 400);
        }
        $owner->password=bcrypt($request->password);
        $owner->save();
        $OwnerForgetPassword->delete();
        $token = JWTAuth::fromUser($owner);
        return response()->json([
           "status" => true,
           'owner'   =>new OwnerResource($owner),
           'token'  => $token,
       ], 200);
    }
}