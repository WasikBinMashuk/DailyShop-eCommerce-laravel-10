<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    public function checkout(){
        $customer = Customer::find(Auth::guard('customer')->user()->id);
        return view('frontend.checkout',compact('customer'));
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|max:255',
            'company_name' => 'max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:50',
            'country' => 'required|max:50',
            'postcode' => 'required|numeric|digits_between:4,6',
            'mobile' => 'required|max:11',
            'email' => 'required|max:255',
            'order_notes' => 'nullable',
            'status' => 'integer',
        ]);

        if($request->has('saveAddress')){
            Customer::find(Auth::guard('customer')->user()->id)
            ->update([
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'postcode' => $request->postcode,
            ]);
        }

        if(session('cart')){
            $subtotal = 0;
            foreach(session('cart') as $id => $details){
                $subtotal += $details['price'] * $details['quantity'];
            }

            // inserting data to orders table
            $order = Order::create([
                'name' => $request->name,
                'company_name' => $request->company_name,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'postcode' => $request->postcode,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'order_notes' => $request->order_notes,
                'subtotal' => $subtotal,
                'customer_id' => Auth::guard('customer')->user()->id,
            ]);
            
            // inserting data to order details table
            foreach(session('cart') as $id => $details){

                $totalPrice = $details['price'] * $details['quantity'];

                $data[] = [
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $details['product_name'],
                    'quantity' => $details['quantity'],
                    'price_each' => $details['price'],
                    'total_price' => $totalPrice,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
            }
            if(isset($data)) OrderDetail::insert($data);
        
        }

        // sweet alert
        Alert::success('Success!!!', 'Order Placed');

        // Clearing cart
        $request->session()->forget('cart');

        return redirect()->route('home');
    }

}
