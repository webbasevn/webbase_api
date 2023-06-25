<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Api\Role\Create;

use Illuminate\Support\Facades\DB;
use App\Models\Role;

use App\Http\Resources\RoleResource;

use App\Constant\BaseConstant;
use App\Services\RoleService;

class RoleController extends BaseController
{
    public function __construct(RoleService $roleService)
    {
        $this->role = $roleService;
    }

    public function CreateRole(Create $request){

        Role::create([
            "name" => $request->name,
            "permision" => serialize($request->permision)
        ]);

        return  response()->json('ok');
    }

    public function QueryRole(Request $request){

        $roles = $this->role->paginate(!empty($request->limit) ? $request->limit : BaseConstant::DEFAULT_PAGINATE);

        return  RoleResource::collection($roles);
    }

    public function DeleteRole(Role $role){
        $role->delete();
        return $this->sendResponse('Xóa quyền thành công');
    }

}
