<?php

namespace App\Helpers;


class ApiResponseHelper
{
    public static function apiResponse($status, $code, $message, $data = null)
    {
        $response = [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response, $code);
    }
}
