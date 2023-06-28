<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AdminMiddleWare
{

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        $is_admin = User::find($user->id)->is_admin;


        if($is_admin !== 1){
            return response()->json([
                'message' => 'Bạn không có quyền',
                'data'=>null
            ],401);
        }

        return $next($request);
    }
}
