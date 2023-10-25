<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\StatusEnum;
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
use RealRashid\SweetAlert\Facades\Alert;

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
            'email' => 'required|string|email|min:1|max:100',
            'password' => 'required|string',
        ]);


        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {

            //checking if the customer is blocked by admin
            if (Auth::guard('customer')->user()->status == 0) {

                Auth::guard('customer')->logout();

                // sweet alert
                Alert::warning('Blocked', 'Your account has been blocked');

                return redirect()->route('home');
            }
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
