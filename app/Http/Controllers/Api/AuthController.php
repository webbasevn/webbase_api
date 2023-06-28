<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function Login(LoginRequest $request){

        $credentials = $request->validated();

        if (auth()->attempt($credentials) === false) {

            return response()->json([
                'message' => 'Đăng nhập thất bại 123',
                'data' => null
            ],403);

        }

        $user = auth()->user();

        $token = $user->createToken(env('TOKEN_SECRET_KEY'))->plainTextToken;

        return  response()->json([
            'message' => 'Đăng nhập thành công',
            'token' => $token,
            'data' => [
                "name" => $user->name,
                "phone" => $user->phone,
                "email" => $user->email,
                "address" => $user->address
            ]
        ]);
    }

    public function register(RegisterRequest $request){

        $user = User::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'package_id' => 1,
            'status_id' => 1,
            'is_admin' => false,
        ]);

        $token = $user->createToken(env('TOKEN_SECRET_KEY'))->plainTextToken;

        $eloquent = User::find($user->id)->with('package','status');

        // lấy thông tin package

        return  response()->json([
            'message' => 'Đăng ký thành công',
            'token' => $token,
            'data' => [
                "id" => $user->id,
                "name" => $user->name,
                "phone" => $user->phone,
                "package" => [
                    "id" => $user->package_id,
                    "name" => "ten package"
                ],
            ]
        ]);
    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Đăng xuất thành công',
            'data'=>null
        ]);
    }

    public function getUser(Request $request){

        $user = $request->user();

        return  response()->json(
            [
                "name" => $user->name,
                "phone" => $user->phone,
                "email" => $user->email,
                "address" => $user->address
            ]
        );
        
    }

    public function getUserAdmin(Request $request){

        $user = $request->user();

        return  response()->json(
            [
                "name" => $user->name,
                "phone" => $user->phone,
                "email" => $user->email,
                "address" => $user->address
            ]
        );
        
    }
}
