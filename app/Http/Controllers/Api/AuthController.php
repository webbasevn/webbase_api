<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    public function Login(LoginRequest $request){
        return  response()->json([
            'message' => 'ok'
        ]);
    }

    public function register(RegisterRequest $request){

        $user = User::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $user->createToken(env('TOKEN_SECRET_KEY'))->plainTextToken;

        return  response()->json([
            'message' => 'register router',
            'token' => $token,
            'data' => $user
        ]);
    }
}
