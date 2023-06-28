<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use App\Constant\BaseConstant;
use App\Services\Admin\UserService;

use App\Http\Resources\Admin\UserResource;

class UserControllers extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->user = $userService;
    }

    public function ListUsers(Request $request){
        $listUser = $this->user->paginate(!empty($request->limit) ? $request->limit : BaseConstant::DEFAULT_PAGINATE);
        return  UserResource::collection($listUser);
    }
}
