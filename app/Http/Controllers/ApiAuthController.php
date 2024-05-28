<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    //
    public function register(Request $request){
        //validation
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:200",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|confirmed",
        ]);

        // check
        if ($validator->fails()) {
            return response()->json([
                "msg" => $validator->errors()
            ], 300);
        }
        //hashed
        $passwordHash = bcrypt($request->password);

        //access_token
        $access_token = Str::random(30);

        User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$passwordHash,
            "access_token"=>$access_token
        ]);

        // success
        return response()->json([
            "msg"=>"Register Successfully!",
            "access_token"=>$access_token,
        ],200);
    }

    public function login(Request $request){
        //validation
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|min:8",
        ]);

        // check
        if ($validator->fails()) {
            return response()->json([
                "msg" => $validator->errors()
            ], 300);
        }
        $email = $request->email;
        $newPassword = $request->password;
        $access_token = Str::random(30);
        //check
        $user = User::where("email",$email)->first();
        // $oldPassword = $user->password;
        // return $user;

        if(!empty ($user)){
            $is_verify = Hash::check($newPassword,$user->password);
            if($is_verify) {
                // update
                $user->update([
                    "access_token"=>$access_token
                ]);
                // success
                return response()->json([
                    "msg" => "Login Successfully!" ,
                ], 200);
            }else{
                return response()->json([
                    "msg" => "Password is not correct!"
                ],404);
            }
        }else{
            return response()->json([
                "msg" => "this account not exist"
            ],404);
        }
    }

    public function logout(Request $request){
        $access_token = $request->header("access_token");
        if(! empty($access_token)){
            //check
            $user = User::where("access_token",$access_token)->first();
            if($user){
                // update
                $user->update([
                    "access_token"=>null
                ]);
                // success
                return response()->json([
                    "msg"=>"Logout Successfully!."
                ],200);
            }else{
                return response()->json([
                    "msg"=>"access token not correct"
                ],300);

            }
        }else{
            return response()->json([
                "msg"=>"access token not found"
            ],300);
        }
    }
}
