<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function viewCart(Request $request)
    {
        $carts = Cart::with(['customer', 'product'])->where('customer_id', auth('sanctum')->user()->id)->get();

        if ($carts->isNotEmpty()) {
            return ApiResponseHelper::apiResponse('Success', '200', 'Order Details Success', CartResource::collection($carts));
        } else {
            return ApiResponseHelper::apiResponse('Failed', '422', 'Cart Empty');
        }
    }

    public function addToCart(Request $request)
    {

        try {
            $product = Product::find($request->id);    //will throw an error if product not found

            //checking if there isn't any product will throw Response failed
            if (!$product) {
                return ApiResponseHelper::apiResponse('Failed', '422', 'Product not found');
            }

            //verifying if the product is already added in cart by the same customer
            $verify = Cart::where('customer_id', auth('sanctum')->user()->id)->where('product_id', $product->id)->first();

            if (!$verify) {
                //if its a new product from customer
                $quantity = 1;
                Cart::create([
                    'customer_id' => auth('sanctum')->user()->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'total_price' => $quantity * $product->price,
                ]);
            } else {
                //if its a existing product from customer, increasing quantity
                $quantity = $verify->quantity + 1;
                $cart = Cart::where('id', $verify->id)->first();
                $cart->update([
                    'quantity' => $quantity,
                    'total_price' => $quantity * $product->price,
                ]);
            }
            return ApiResponseHelper::apiResponse('Success', '200', 'Product added to cart');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function removeFromCart(Request $request)
    {
        // dd($request->id);

        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
                return ApiResponseHelper::apiResponse('Success', '200', 'Product successfully removed');
            } else {
                return ApiResponseHelper::apiResponse('Failed', '422', 'This product has not found in cart');
            }
        }
    }

    public function emptyCart(Request $request)
    {

        // Clearing cart
        $request->session()->forget('cart');
        return ApiResponseHelper::apiResponse('Success', '200', 'Cart Empty');
    }
}
