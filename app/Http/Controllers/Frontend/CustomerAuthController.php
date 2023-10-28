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
use App\Models\Otp;
use App\Models\OtpCount;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

use function Laravel\Prompts\alert;

class CustomerAuthController extends Controller
{
    public function customerRegister(Request $request)
    {

        // $validated = $request->validated();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:30',
            'email' => 'required|string|email|min:1|max:100|unique:customers',
            'password' => 'required|string|confirmed|min:6|max:255',
            'mobile' => 'required|numeric|digits:11|unique:customers',
        ]);

        if ($validator->fails()) {
            // Set a session variable to indicate the modal should be open
            session()->put('register_tab_open', true);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // $customer = Customer::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password,
        //     'mobile' => $request->mobile,
        // ]);

        // fetching data for otp request limit per day, 10 per user and 1000 for all users
        $today = now()->toDateString();
        $totalDailyLimit = OtpCount::whereDate('created_at', $today)->sum('otp_count');
        $totalDailyLimitOfUser = OtpCount::select('otp_count','updated_at')->where('mobile', $request->mobile)->whereDate('created_at', $today)->get();

        //check if daily website limit and daily user's otp request limit is over
        if ($totalDailyLimitOfUser->isEmpty() || $totalDailyLimitOfUser[0]->otp_count <= 10) {

            if (($totalDailyLimit <= 1000)) {
                $request->session()->put('customerInput', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'mobile' => $request->mobile,
                ]);

                //check : User cannot resend any request within 1 minute (What if someone try to resubmit the registration form frequently)
                if ($totalDailyLimitOfUser->isNotEmpty() && (strtotime($totalDailyLimitOfUser[0]->updated_at->addMinutes(1)) > strtotime(now()))) {
                    // sweet alert
                    Alert::error('Wait for a minute');
                    return redirect()->back();
                }

                // sending email to the customer using queue jobs
                // SendEmailJob::dispatch($customer->email);

                // Set a session variable to indicate the modal should be open
                // session()->put('keep_modal_open', true);


                // OTP generate
                $otp = Otp::create([
                    'mobile' => $request->mobile,
                    'otp_code' => env('APP_ENV') == 'local' ? '123456' : random_int(100000, 999999),
                    'expire_at' => now()->addMinutes(1),
                ]);

                $otp_count = OtpCount::where('mobile', $request->mobile)->first();

                //increasing otp count per mobile number by every request
                if ($otp_count) {
                    $otp_count->update([
                        'otp_count' => $otp_count->otp_count + 1
                    ]);
                } else {
                    OtpCount::create([
                        'mobile' => $request->mobile,
                        'otp_count' => 1,
                    ]);
                }

                // otp page can be viewed after this session starts
                $request->session()->put('otpOn', true);

                //Sending otp to mobile by SMS
                $response = Http::post('http://ismsapi.publicdemo.xyz/api/v3/send-sms', [
                    'api_token' => 'id21k6pn-hfecd5j0-8twu0ho3-5j0avf06-rbhikgtz',
                    'sid' => 'SSLW',
                    'msisdn' => $otp->mobile,
                    'sms' => "Your OTP: $otp->otp_code will expire in 3 minutes",
                    'csms_id' => uniqid(),
                ]);

                // sweet alert
                Alert::success('Registered', 'Please Enter OTP to complete registration');

                // Start the timer for otp timeout
                session(['timer_start' => now()]);
                session(['timer_duration' => 60]);

                return redirect()->route('otp');
            } else {
                //deleting the sessions used for otp
                $request->session()->forget('customerInput');
                $request->session()->forget('otpOn');

                // sweet alert
                Alert::error('Limit Crossed', 'Daily Otp limit is over, try again tomorrow!');

                return redirect()->route('home');
            }
        } else {

            // sweet alert
            Alert::error('Limit Crossed', 'Your Otp limit is over, try again tomorrow!');
            return redirect()->route('home');
        }




        // return redirect()->back();
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

            // //Checking if the customer is verified or not while login
            // if (Auth::guard('customer')->user()->otp_verified == 0) {

            //     // OTP generate
            //     $otp = Otp::create([
            //         'customer_id' => Auth::guard('customer')->user()->id,
            //         'mobile' => Auth::guard('customer')->user()->mobile,
            //         'otp_code' => env('APP_ENV') == 'local' ? '123456' : random_int(100000, 999999),
            //         'expire_at' => now()->addMinutes(3),
            //     ]);

            //     $otp_count = OtpCount::where('mobile', Auth::guard('customer')->user()->mobile)->first();
            //     $otp_count->update([
            //         'otp_count' => $otp_count->otp_count + 1
            //     ]);

            //     //passing the customerId using session
            //     $request->session()->put('customerId', Auth::guard('customer')->user()->id);

            //     $response = Http::post('http://ismsapi.publicdemo.xyz/api/v3/send-sms', [
            //         'api_token' => 'id21k6pn-hfecd5j0-8twu0ho3-5j0avf06-rbhikgtz',
            //         'sid' => 'SSLW',
            //         'msisdn' => $otp->mobile,
            //         'sms' => "Your OTP: $otp->otp_code will expire in 3 minutes",
            //         'csms_id' => uniqid(),
            //     ]);

            //     Auth::guard('customer')->logout();

            //     // sweet alert
            //     Alert::warning('Not Verified', 'Please verify your account using OTP');

            //     return redirect()->route('otp');
            // }

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
