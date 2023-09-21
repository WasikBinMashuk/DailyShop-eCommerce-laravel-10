<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::latest()->paginate(10);
        return view('backend.orders.index',compact('orders'));
    }

    public function update(Request $request, $id){
        
        // dd($id, $request->all());

        $request->validate([
            'status' => 'required',
        ]);
        
        $order = Order::find($id);

        $order->update([
            'status' => $request->status,
        ]);

        // sweet alert
        toast('Order Status Updated!','success');

        return redirect()->back();
    }

    public function details($id){
        $orderDetails = OrderDetail::where('order_id',$id)->get();
        // dd($orderDetails);

        return view('backend.orders.details',compact('orderDetails'));
    }
}
