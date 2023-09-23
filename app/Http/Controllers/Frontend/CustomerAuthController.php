<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Customer;
use App\Http\Requests\CustomerFormRequest;
use App\Models\Customer as ModelsCustomer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{

    public function index()
    {
        // $orders = OrderDetail::select('orders.id','orders.subtotal','order_details.product_name','order_details.quantity','order_details.price_each')
        // ->Join('orders', 'order_details.order_id', '=', 'orders.id')
        // ->where('orders.customer_id', Auth::guard('customer')->user()->id)
        // ->orderBy('orders.id', 'DESC')->get();
        
        $orders = Order::where('customer_id',Auth::guard('customer')->user()->id)->orderBy('id', 'DESC')->get();
        if($orders->isNotEmpty()){
            foreach($orders as $order){
                $orderIds[] = $order->id;
            }
            $orderDetails = OrderDetail::whereIn('order_id',$orderIds)->get();
        }else{
            $orderDetails = null;
        }
        
        // dd($orders);
        // $orderIds = $orders->id;
        
        // dd($orderDetails);
        return view('frontend.customer-dashboard',compact('orders','orderDetails'));
    }

    public function customerLoginForm()
    {
        return view('frontend.login');
    }

    public function customerRegister(CustomerFormRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        
        ModelsCustomer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'mobile' => $request->mobile,
            // 'status' => $request->status,
        ]);

        // sweet alert
        toast('Registered! Please Login','success');

        return redirect()->back();
    }

    public function customerLogin(Request $request)
    {
        $request->validate([
            'email'=>'required|max:100',
            'password'=>'required|min:6',
        ]);

        if(Auth::guard('customer')->attempt(['email'=>$request->email,'password'=>$request->password])){
            // dd(Auth::guard('customer'));
            return redirect('customer/dashboard');
        }else{
            // dd('bhuul');

            // sweet alert
            toast('Email or password invalid','warning');
            return redirect()->back();
        }
    }

    public function customerLogout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }

    

    
}
