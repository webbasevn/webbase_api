<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserStatus;
use App\Services\UserStatusService;
use App\Constant\BaseConstant;
use App\Http\Resources\Admin\UserStatusResource;
use App\Http\Controllers\Api\BaseController;

class UserStatusController extends BaseController
{

    public function __construct(UserStatusService $userStatusService)
    {
        $this->services = $userStatusService;
    }


    public function index(Request $request){
        $query = $this->services->paginate(!empty($request->limit) ? $request->limit : BaseConstant::DEFAULT_PAGINATE);
        return  UserStatusResource::collection($query);
    }

    public function store(Request $request){

        UserStatus::create([
            'name' => $request->name,
            'redirect' => $request->redirect,
            'message' => $request->message,
        ]);

        return  response()->json([
            'message' => 'Tạo mới thành công',
            'data' => null
        ],201);
    }

    public function destroy(UserStatus $userStatus){
        $userStatus->delete();
        return $this->sendResponse('Xóa status thành công');
    }
}
