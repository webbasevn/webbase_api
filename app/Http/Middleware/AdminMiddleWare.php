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
        $role = ["is_admin"];

        $user = $request->user();

        $role = User::find($user->id)->role;

        $permision = unserialize($role->permision);

        if(in_array('is_admin',$permision) === false){
            return response()->json([
                'message' => 'Bạn không có quyền',
                'data'=>null
            ],401);
        }

        return $next($request);
    }
}
