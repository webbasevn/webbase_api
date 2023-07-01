<?php

namespace App\Http\Controllers\Api\Open;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Api\BaseController;

// models
use App\Models\User;
use App\Models\Device;

class AuthController extends BaseController
{

    private function create_new_device($device,$user_id,$propeties){

        $create = Device::create([
            "devices" => $device,
            "user_id" => $user_id,
            "properties" => serialize($propeties),
            "token" => rand(100000,999999)
        ]);

        return $create;
    }

    private function response_use_data($user,$token,$device_id,$message){

        return  response()->json([
            "code" => 200,
            'message' => $message,
            'token' => $token,
            'device_id' => $device_id,
            'data' => [
                "name" => $user->name,
                "phone" => $user->phone,
                "email" => $user->email,
                "is_admin" => boolval($user->is_admin),
                "address" => $user->address,
                "city" => $user->city,
                "district" => $user->district,
                "ward" => $user->ward,
                'package' => [
                    "id" => $user->package->id,
                    "name" => $user->package->name
                ],
                'status' => $user->status->name
            ]
        ]);

    }

    public function Login(LoginRequest $request){

        $credentials = $request->validated();

        
        if (auth()->attempt($credentials) === false) {
            
            return response()->json([
                'message' => 'Đăng nhập thất bại 123',
                'data' => null
            ],403);
            
        }
        
        $user = auth()->user();

        // nếu user bị lock hoặc khóa
        if(boolval($user->status->redirect) === false){
            return response()->json([
                'message' => $user->status->message,
                'data' => null
            ],403);
        };
        
        $token = $user->createToken(env('TOKEN_SECRET_KEY'))->plainTextToken;

        $device_id = 0;

        // Nếu không có id thiết bị
        if($request->devices['current_device_id'] === null){

            $result = $this->create_new_device(
                $device = $request->devices['devices'],
                $user_id = $user->id,
                $propeties = $request->devices['properties']
            );

            return $this->response_use_data($user,$token,(int)$result->token,'Đăng nhập thành công');
        };

        $thisDevices = Device::where('token', $request->devices['current_device_id'])->first();

        if(!$thisDevices){

            $result = $this->create_new_device(
                $device = $request->devices['devices'],
                $user_id = $user->id,
                $propeties = $request->devices['properties']
            );

            return $this->response_use_data($user,$token,(int)$result->token,'Đăng nhập thành công');
        };

        return $this->response_use_data($user,$token,(int)$thisDevices->token,'Đăng nhập thành công');

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

        // tạo device mới
        $device = $this->create_new_device(
            $device = $request->devices['devices'],
            $user_id = $user->id,
            $propeties = $request->devices['properties']
        );

        $token = $user->createToken(env('TOKEN_SECRET_KEY'))->plainTextToken;

        // lấy thông tin package
        return $this->response_use_data($user,$token,(int)$device->token, 'Đăng ký thành công');

    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Đăng xuất thành công',
            'data'=>null
        ]);
    }

    public function me(Request $request){

        $user = $request->user();

        // lấy thông tin package
        return $this->response_use_data($user,null,(int)$request->header('device_id'), 'Thành công');
        
    }

}
