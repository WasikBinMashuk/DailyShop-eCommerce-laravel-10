<?php

namespace App\Helpers;


class ApiResponseHelper
{
    static public function apiResponse($status, $code, $message, $data = null)
    {
        $response = [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response, 200);
    }
}
