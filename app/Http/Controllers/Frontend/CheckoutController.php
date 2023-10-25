<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $customer = Customer::find(Auth::guard('customer')->user()->id);
        return view('frontend.checkout', compact('customer'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|min:1|max:255',
            'company_name' => 'nullable|string|min:1|max:255',
            'address' => 'required|string|min:1|max:255',
            'city' => 'required|string|min:1|max:50',
            'country' => 'required|string|min:1|max:50',
            'postcode' => 'required|numeric|digits_between:4,6',
            'mobile' => 'required|numeric|digits:11',
            'email' => 'required|string|email|max:255',
            'order_notes' => 'nullable|string|max:20000',
            // 'status' => 'integer',
        ]);

        try {
            if ($request->filled('saveAddress')) {
                Customer::find(Auth::guard('customer')->user()->id)
                    ->update([
                        'address' => $request->address,
                        'city' => $request->city,
                        'country' => $request->country,
                        'postcode' => $request->postcode,
                    ]);
            }

            if (session('cart')) {
                $subtotal = 0;
                foreach (session('cart') as $id => $details) {
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
                foreach (session('cart') as $id => $details) {

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
                if (isset($data)) OrderDetail::insert($data);
            }

            // sweet alert
            Alert::success('Success!!!', 'Order Placed');

            // Clearing cart
            $request->session()->forget('cart');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->route('home');
    }
}
