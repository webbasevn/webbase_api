<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as StatusResponse;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($message = null, $result = null, $code = StatusResponse::HTTP_OK)
    {
        $response = [
            'code' => $code,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($message = null, $result = null, $code = StatusResponse::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response = [
            'code' => $code,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }

    public function validator($request, array $validate, array $messages = [], array $customAttributes = [])
    {
        $validator = Validator::make($request->all(), $validate, $messages, $customAttributes);
        $this->error = [];
        if ($validator->fails()) {
            $this->error = $validator->messages()->toArray();
        }
        return $this->error;
    }
}
