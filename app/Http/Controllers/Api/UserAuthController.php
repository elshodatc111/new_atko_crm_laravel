<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserAuthController extends Controller{

    public function login(Request $request){
        $request->validate([
            "email" => "required|string",
            "password" => "required"
        ]);
        $user = User::where("email", $request->email)->first();
        if(!empty($user)){
            if(Hash::check($request->password, $user->password)){
                $tokenInfo = $user->createToken("myToken");
                $token = $tokenInfo->plainTextToken; 
                return response()->json([
                    "status" => true,
                    "data" =>[
                        "name" => $user->name,
                        "email" => $user->email,
                        "phone" => $user->phone,
                        "addres" => $user->addres,
                        "balans" => $user->balans,
                    ],
                    "message" => "Login successful",
                    "token" => $token
                ]);
            }else{
                return response()->json([
                    "status" => false,
                    "message" => "Password didn't match."
                ]);
            }
        }else{
            return response()->json([
                "status" => false,
                "message" => "Invalid credentials"
            ]);
        }
    }

    public function profile(){
        $userData = auth()->user()->only(['balans']);
        return response()->json([
            "status" => true,
            "message" => "Profile information",
            "balans" => $userData
        ]);
    }

    public function logout(){
        request()->user()->tokens()->delete();
        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }

}
