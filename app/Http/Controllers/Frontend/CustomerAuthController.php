<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Customer;
use App\Http\Requests\CustomerFormRequest;
use App\Models\Customer as ModelsCustomer;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{

    public function index()
    {
        return view('frontend.customer-dashboard');
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
