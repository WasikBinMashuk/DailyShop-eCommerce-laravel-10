<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
// use App\Http\Middleware\Customer;
use App\Http\Requests\CustomerFormRequest;
use App\Jobs\SendEmailJob;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerAuthController extends Controller
{
    public function customerRegister(CustomerFormRequest $request)
    {
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'mobile' => $request->mobile,
        ]);

        // sending email to the customer using queue jobs
        SendEmailJob::dispatch($customer->email);

        // sweet alert
        toast('Registered! Please Login', 'success');

        return redirect()->back();
    }

    public function customerLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|min:1|max:100|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('customer/dashboard');
        } else {
            // sweet alert
            toast('Email or password invalid', 'warning');
            return redirect()->back();
        }
    }

    public function customerLogout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }
}
