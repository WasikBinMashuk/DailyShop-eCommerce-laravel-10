<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //ADMIN register
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255||unique:users',
            'password' => 'required|confirmed|min:6',
            'mobile' => 'required|max:11',
            'status' => 'required|in:0,1'
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $password = Hash::make($request->password);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'mobile' => $request->mobile,
            'status' => $request->status,
        ]);

        $success['token'] = $user->createToken('DailyShop')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User register successful'
        ];

        return response()->json($response, 200);
    }

    //Customer login API
    public function login(Request $request)
    {
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('customer')->user();
            $success['token'] = $user->createToken('DailyShop')->plainTextToken;
            $success['name'] = $user->name;

            return ApiResponseHelper::apiResponse('Success', '200', 'Login successful', $success);
        } else {

            return ApiResponseHelper::apiResponse('Failed', '422', 'Unauthorized');
        }
    }

    public function logout(Request $request)
    {
        // dd(auth('sanctum')->user());
        if (auth('sanctum')->check()) {
            auth('sanctum')->user()->currentAccessToken()->delete();
            return ApiResponseHelper::apiResponse('Success', '200', 'Customer Logged out');
        } else {
            return ApiResponseHelper::apiResponse('Failed', '422', 'No user found');
        }
    }
}
