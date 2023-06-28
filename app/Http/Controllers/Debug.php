<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class Debug extends Controller
{
    public function debug(){
        
        $user_id = 1;
        User::find(1);
        $query = User::with('role')->first();

        // $result = DB::table('users')->find($user->package_id);

        dd(unserialize($query->role->permision));

    }
}
