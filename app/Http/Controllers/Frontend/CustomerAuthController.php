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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerAuthController extends Controller
{

    public function index()
    {
        $profile = ModelsCustomer::find(Auth::guard('customer')->user()->id);
        
        $orders = Order::where('customer_id',Auth::guard('customer')->user()->id)->orderBy('id', 'DESC')->get();
        if($orders->isNotEmpty()){
            foreach($orders as $order){
                $orderIds[] = $order->id;
            }
            $orderDetails = OrderDetail::whereIn('order_id',$orderIds)->get();
        }else{
            $orderDetails = null;
        }

        return view('frontend.customer-dashboard',compact('profile','orders','orderDetails'));
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

    public function profileUpdate(Request $request){

        $request->validate([
            'name' => 'required|max:20',
            'email' =>  ['required','max:100',Rule::unique('customers')->ignore(Auth::guard('customer')->user()->id)],
            'mobile' => 'required|max:11',
        ]);

        $customer = ModelsCustomer::find(Auth::guard('customer')->user()->id)
                    ->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'mobile' => $request->mobile,
                    ]);

        // sweet alert
        toast('Profile Updated!','success');

        return redirect()->back();
    }

    public function addressUpdate(Request $request){
        // dd($request->all());
        $request->validate([
            'address' => 'required|max:255',
            'city' => 'required|max:50',
            'country' => 'required|max:50',
            'postcode' => 'required|numeric|digits_between:4,6',
        ]);

        ModelsCustomer::find(Auth::guard('customer')->user()->id)
                    ->update([
                        'address' => $request->address,
                        'city' => $request->city,
                        'country' => $request->country,
                        'postcode' => $request->postcode,
                    ]);

        // sweet alert
        toast('Address Updated!','success');

        return redirect()->back();
    }

    public function updatePassword(Request $request){
        // dd($request->all());
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        
        if(!Hash::check($request->old_password, Auth::guard('customer')->user()->password)){
            toast('Old Password Does not match!','warning');
            return back();
        }
        ModelsCustomer::find(Auth::guard('customer')->user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        toast('Password changed!','success');
        return back();
    }

    public function customerLogout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }

    

    
}
