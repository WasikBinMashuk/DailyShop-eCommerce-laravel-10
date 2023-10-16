<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $orders = Order::with(['orderDetails'])->where('customer_id', $request->user()->id)->get();
        if ($orders->isNotEmpty()) {
            return ApiResponseHelper::apiResponse('Success', '200', 'Order Details Success', $orders);
        } else {
            return ApiResponseHelper::apiResponse('Failed', '422', 'No Orders Found');
        }
    }
}
