<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orders(Request $request)
    {
        // dd(auth('sanctum')->user()->id);
        $orders = Order::with(['orderDetails'])->where('customer_id',  auth('sanctum')->user()->id)->get();
        if ($orders->isNotEmpty()) {
            return ApiResponseHelper::apiResponse('Success', '200', 'Order Details Success', $orders);
        } else {
            return ApiResponseHelper::apiResponse('Failed', '422', 'No Orders Found');
        }
    }

    public function products()
    {
        $products = Product::with(['category', 'subCategory'])->get();
        if ($products->isNotEmpty()) {
            return ApiResponseHelper::apiResponse('Success', '200', 'Products Details Success', $products);
        } else {
            return ApiResponseHelper::apiResponse('Failed', '422', 'No Products Found');
        }
    }
}
