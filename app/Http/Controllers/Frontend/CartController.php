<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        return view('frontend.cart');
    }

    public function addToCart($id)
    {
        try {
            $product = Product::findOrFail($id);

            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "product_name" => $product->product_name,
                    "price" => $product->price,
                    "product_image" => $product->product_image,
                    "quantity" => 1
                ];
            }

            session()->put('cart', $cart);

            toast('Product added in cart', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }
        return redirect()->back();
    }

    public function addToCartFromProduct(Request $request, $id)
    {
        try {

            $quantity = $request->quantity;

            $product = Product::findOrFail($id);

            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "product_name" => $product->product_name,
                    "price" => $product->price,
                    "product_image" => $product->product_image,
                    "quantity" => $quantity
                ];
            }

            session()->put('cart', $cart);

            toast('Product added in cart', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }
        return redirect()->back();
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            // session()->flash('success','product removed');
        }
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            // session()->flash('success','product removed');
        }
    }
}
