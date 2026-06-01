<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Mail\VerifyOtpMail;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {

        $data = $request->validated();
        $data["password"] = Hash::make($request->password);

        $otp = (string) rand(100000,999999);
        $data["otp"] = $otp;

        Cache::put("otp_".$request->email, $data, now()->addMinutes(10));

        Mail::to($request->email)->send(new VerifyOtpMail($otp));

        return response()->json([
            "success" => true,
            "message" => "User registered successfully! Please verify your email with the OTP sent to your email address.",
        ],201);

    }
    public function verifyOtp(Request $request){
        $request->validate([
            "email" => "required|email",
            "otp" => "required|string",
        ]);
        $cachedData = Cache::get("otp_".$request->email);

        if (! $cachedData || $cachedData['otp'] !== $request->otp) {
            return response()->json(['error' => 'Invalid or expired OTP'], 400);
        }
        $user =User::create($cachedData);
        Cache::forget("otp_".$request->email);
        $token = $user->createToken("ApiAuthToken")->plainTextToken;
        return response()->json([
            "success" => true,
            "message" => "OTP verified successfully!",
            "token" => $token
        ],200);
    }
    public function login(LoginRequest $request){
        $request->validated();
        $credentials = $request->only("email","password");

        if(!Auth::attempt($credentials)){
            return response()->json([
                "success" => false,
                "message" => "Wrong email or Password!",
            ],403);  
        }

        $user = User::where("email",$request->email)->first();
        $token = $user->createToken("ApiAuthToken")->plainTextToken;

        return response()->json([
            "success" => true,
            "message" => "Login Successful!",
            "token" => $token,
            "User" => new UserResource($user)
        ],200);
    }
    
    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            "success" => true,
            "message" => "User logged out successfully!",
        ],200);

    }

    public function deleteUser($id){
        $user = User::find($id);
        if(!$user){
            return response()->json([
                "success" => false,
                "message" => "User not found!"
            ],404);
        }
        $user->delete();
        return response()->json([
            "success" => true,
            "message" => "User deleted successfully!"
        ],200);
    }
}