<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //ADMIN register
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|max:255||unique:users',
            'password' => 'required|confirmed|min:6',
            'mobile' => 'required|max:11',
            'status' => 'required|in:0,1'
        ]);
        if($validator->fails()){
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
    public function login(Request $request){
        if(Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::guard('customer')->user();
            $success['token'] = $user->createToken('DailyShop')->plainTextToken;
            $success['name'] = $user->name;

            $response = [
                'status' => 'success',
                'code' => 200,
                'data' => $success,
                'message' => 'Customer login successful'
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                'status' => 'Failed',
                'code' => 422,
                'data' => null,
                'message' => 'Unauthorized'
            ];
            return response()->json($response);
        }
    }

    public function orders(Request $request)
    {
        $orders = Order::where('customer_id',$request->user()->id)->orderBy('id', 'DESC')->get();
        if($orders->isNotEmpty()){
            foreach($orders as $order){
                $orderIds[] = $order->id;
            }
            $orderDetails = OrderDetail::whereIn('order_id',$orderIds)->get();
        }else{
            $orderDetails = null;
        }

        // return $orderDetails;
        $response = [
            'status' => 'success',
            'code' => 200,
            'data' => $orders,
            'message' => 'order details success'
        ];
        return response()->json($response, 200);
    }
}
