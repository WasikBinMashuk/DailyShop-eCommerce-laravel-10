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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerAuthController extends Controller
{
    public function customerRegister(Request $request)
    {
        // $validated = $request->validated();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:30',
            'email' => 'required|string|email|min:1|max:100|unique:customers',
            'password' => 'required|string|confirmed|min:6|max:255',
            'mobile' => 'required|numeric|digits:11',
        ]);

        if ($validator->fails()) {
            // Set a session variable to indicate the modal should be open
            session()->put('register_tab_open', true);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'mobile' => $request->mobile,
        ]);

        // sending email to the customer using queue jobs
        SendEmailJob::dispatch($customer->email);

        // Set a session variable to indicate the modal should be open
        session()->put('keep_modal_open', true);

        // sweet alert
        toast('Registered! Please Signin', 'success');

        return redirect()->back();
    }

    public function customerLogin(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|string|email|min:1|max:100',
        //     'password' => 'required|string',
        // ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|min:1|max:100',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            // Set a session variable to indicate the modal should be open
            session()->put('signin_tab_open', true);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


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
            // Set a session variable to indicate the modal should be open
            session()->put('keep_modal_open', true);

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
