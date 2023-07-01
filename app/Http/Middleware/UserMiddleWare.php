<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Device;

class UserMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // kiểm tra device_id
        $thisDevices = Device::where('token', $request->header('device_id'))->first();

        // không có device này
        if($thisDevices === null){
            return response()->json([
                'code' => 'redirect_to_login',
                'message' => 'Hết phiên làm việc vui lòng đăng nhập lại',
                'data'=>null
            ],422);
        }

        // device éo phải của nó
        if($thisDevices->user_id !== $user->id){
            return response()->json([
                'code' => 'redirect_to_login',
                'message' => 'Token không đúng, vui lòng đăng nhập lại để lấy token mới',
                'data'=>null
            ],422);
        }

        return $next($request);
    }
}
