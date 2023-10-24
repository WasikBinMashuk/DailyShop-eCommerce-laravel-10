<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(10);
        return view('backend.orders.index', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        //! Order status -> 1=processing, 2=shipped, 3=delivered, 0= failed
        $request->validate([
            'status' => 'required|string|in:1,2,3,0',
        ]);

        try {
            $order = Order::findOrFail($id);

            $order->update([
                'status' => $request->status,
            ]);

            // sweet alert
            toast('Order Status Updated!', 'success');
        } catch (Exception $e) {
            // dd($e->getMessage());
            toast('Something went wrong', 'error');
        }

        return redirect()->back();
    }

    public function details($id)
    {
        $orderDetails = OrderDetail::where('order_id', $id)->get();

        return view('backend.orders.details', compact('orderDetails'));
    }
}
