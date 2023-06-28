<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\City;

class LocationController extends BaseController
{
    public function __construct(UserService $userService)
    {
        $this->user = $userService;
    }
    
    public function getCity(City $city){

    }
}
