<?php

namespace App\Http\Controllers\Api\Owner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\OwnerResource;
use App\Models\Owner;
use App\Models\Setting;

class authenticationController extends Controller
{

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(), [
            'email'     =>  'required|exists:owners,email',
            'password'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'  => false,
                'message' =>$validator->errors(),
            ], 400);
        }
        // $user_one=Owner::where('email',$request->email)->first();
        // $user_two=Owner::where('email_second',$request->email)->first();
        // // return $user_one->password;
        // if (!empty($user_one)) 
        // {
        //     return $credentials = ['email' => $user_one->email, 'password' =>$user_one->password];
        //          $token = auth('owner')->attempt($credentials);

        //         $owner= auth('owner')->user();
        //         if(!empty($owner))
        //         {
        //             if($owner->verify_account==false)
        //             {
        //                 return response()->json([
        //                     'status'  => false,
        //                     'message' => __('site.You Need To Verify Your Account'),
        //                 ], 400);
        //             }
        //             // if($request->has('mobile_token')){
        //             //     $owner->mobile_token   = $request->mobile_token;
        //             //     $owner->save();
        //             // }
        //             return response()->json([
        //                 'status'    => true,
        //                 'owner'   => new OwnerResource($owner),
        //                 'token'     => $token,
        //             ], 200);
        //         }else
        //         {
        //             return response()->json([
        //                 'status'  => false,
        //                 'message' => __('site.wrong email or password'),
        //             ], 400);
        //         }
        // }if (!empty($user_two))
        // {
        //         $credentials = ['email' => $user_two->email_second, 'password' =>$user_two->password];
        //         $token = auth('owner')->attempt($credentials);

        //         $owner= auth('owner')->user();
        //         if(!empty($owner))
        //         {
        //         if($owner->verify_second_email==false)
        //         {
        //             return response()->json([
        //                 'status'  => false,
        //                 'message' => __('site.You Need To Verify Your second email Account'),
        //             ], 400);
        //         }
        //         // if($request->has('mobile_token')){
        //         //     $owner->mobile_token   = $request->mobile_token;
        //         //     $owner->save();
        //         // }
        //         return response()->json([
        //             'status'    => true,
        //             'owner'   => new OwnerResource($owner),
        //             'token'     => $token,
        //         ], 200);
        //     }else
        //     {
        //         return response()->json([
        //             'status'  => false,
        //             'message' => __('site.wrong email or password'),
        //         ], 400);
        //     }
        // }else
        // {
        //     return response()->json([
        //         'status'  => false,
        //         'message' => __('site.wrong email or password'),
        //     ], 400);
        // }
        
        $credentials = ['email' => $request->email, 'password' => $request->password];
        $token = auth('owner')->attempt($credentials);

        $owner= auth('owner')->user();
        if(!empty($owner))
        {
            if($owner->verify_account==false)
            {
                return response()->json([
                    'status'  => false,
                    'message' => __('site.You Need To Verify Your Account'),
                ], 400);
            }
            // if($request->has('mobile_token')){
            //     $owner->mobile_token   = $request->mobile_token;
            //     $owner->save();
            // }
            return response()->json([
                'status'    => true,
                'owner'   => new OwnerResource($owner),
                'token'     => $token,
            ], 200);
        }else
        {
            return response()->json([
                'status'  => false,
                'message' => __('site.wrong email or password'),
            ], 400);
        }
    
    }


    public function logout(){ 

        $owner=Auth::guard('owner')->user();

        // $owner->update(['verify_account'=>null]);

        Auth::guard('owner')->logout('true');

        return response()->json([
            'status'  => true,
            'message' => __('site.Logout_Successfully'),
        ], 200);
    }
}
