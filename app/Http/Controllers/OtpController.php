<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Otp;
use App\Models\OtpCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class OtpController extends Controller
{
    public function otp(Request $request)
    {
        if ($request->session()->has('otpOn')) {
            return view('frontend.otp');
        } else {
            return redirect()->route('home');
        }
    }

    public function verify(Request $request)
    {

        $request->validate([
            'otp_code' => 'required|integer|digits_between:1,6',
        ]);

        $otp = Otp::where('otp_code', $request->otp_code)->Where('mobile', $request->session()->get('customerInput')['mobile'])->orderBy('created_at', 'desc')->first();
        if ($otp) {
            
            if (strtotime($otp->expire_at) > strtotime(now())) {
                
                Otp::where('id', $otp->id)->update([
                    'isUsed' => 1,
                ]);

                Customer::create([
                    'name' => $request->session()->get('customerInput')['name'],
                    'email' => $request->session()->get('customerInput')['email'],
                    'password' => $request->session()->get('customerInput')['password'],
                    'mobile' => $request->session()->get('customerInput')['mobile'],
                ]);

                // Set a session variable to indicate the modal should be open
                session()->put('keep_modal_open', true);

                //deleting all the sessions used for otp
                $request->session()->forget('customerInput');
                $request->session()->forget('otpOn');
                $request->session()->forget('timer_start');
                $request->session()->forget('timer_duration');

                // sweet alert
                toast('You are verified! Please Signin', 'success');

                return redirect()->route('home');
            } else {
                return redirect()->route('otp')->with('success', 'OTP expired');
            }
        } else {
            return redirect()->route('otp')->with('success', 'OTP does not match');
        }
    }

    public function resend(Request $request)
    {
        $request->session()->put('otpOn', true);

        // fetching data for otp request limit per day, 10 per user and 1000 for all users
        $today = now()->toDateString();
        $totalDailyLimit = OtpCount::whereDate('created_at', $today)->sum('otp_count');
        $totalDailyLimitOfUser = OtpCount::select('otp_count', 'updated_at')->where('mobile', $request->session()->get('customerInput')['mobile'])->whereDate('created_at', $today)->get();
        // dd(strtotime($totalDailyLimitOfUser[0]->updated_at->addMinutes(1)));
        //check if daily website limit and daily user's otp request limit is over
        if ($totalDailyLimitOfUser->isEmpty() || $totalDailyLimitOfUser[0]->otp_count <= 10) {

            if (($totalDailyLimit <= 1000)) {
                // $otp = Otp::where('customer_id', $request->session()->get('customerId'))->where('isUsed', 0)->first();

                // $otp->update([
                //     'otp_code' => env('APP_ENV') == 'local' ? '123456' : random_int(100000, 999999),
                //     'expire_at' => now()->addMinutes(3),
                // ]);

                //check : user cannot resend any request within 1 minute
                if (strtotime($totalDailyLimitOfUser[0]->updated_at->addMinutes(1)) > strtotime(now())) {
                    // sweet alert
                    Alert::error('Wait for a minute');
                    return redirect()->back();
                }

                $otp = Otp::create([
                    'mobile' => $request->session()->get('customerInput')['mobile'],
                    'otp_code' => env('APP_ENV') == 'local' ? '123456' : random_int(100000, 999999),
                    'expire_at' => now()->addMinutes(1),
                ]);

                $otp_count = OtpCount::where('mobile', $request->session()->get('customerInput')['mobile'])->first();

                //increasing otp count per mobile number by every request
                if ($otp_count) {
                    $otp_count->update([
                        'otp_count' => $otp_count->otp_count + 1
                    ]);
                } else {
                    OtpCount::create([
                        'mobile' => $request->session()->get('customerInput')['mobile'],
                        'otp_count' => 1,
                    ]);
                }

                //Sending otp to mobile by SMS
                $response = Http::post('http://ismsapi.publicdemo.xyz/api/v3/send-sms', [
                    'api_token' => 'id21k6pn-hfecd5j0-8twu0ho3-5j0avf06-rbhikgtz',
                    'sid' => 'SSLW',
                    'msisdn' => $otp->mobile,
                    'sms' => "Your OTP: $otp->otp_code will expire in 3 minutes",
                    'csms_id' => uniqid(),
                ]);

                // Start the timer for otp timeout
                session(['timer_start' => now()]);
                session(['timer_duration' => 60]);

                return redirect()->back();
            } else {
                //deleting the sessions used for otp
                $request->session()->forget('customerInput');
                $request->session()->forget('otpOn');

                // sweet alert
                Alert::error('Limit Crossed', 'Daily OTP limit is over, try again tomorrow!');

                return redirect()->route('home');
            }
        } else {
            //deleting the sessions used for otp
            $request->session()->forget('customerInput');
            $request->session()->forget('otpOn');

            // sweet alert
            Alert::error('Limit Crossed', 'Your OTP limit is over, try again tomorrow!');
            return redirect()->route('home');
        }
    }

    public function apiTesting()
    {
        // dd(Auth::guard('customer')->user()->mobile);
        // dd(random_int(100000, 999999));
        // dd(now()->addMinutes(3));
        $otp = Otp::create([
            'customer_id' => Auth::guard('customer')->user()->id,
            'mobile' => Auth::guard('customer')->user()->mobile,
            'otp_code' => random_int(100000, 999999),
            'expire_at' => now()->addMinutes(3),
        ]);

        $response = Http::post('http://ismsapi.publicdemo.xyz/api/v3/send-sms', [
            'api_token' => 'id21k6pn-hfecd5j0-8twu0ho3-5j0avf06-rbhikgtz',
            'sid' => 'SSLW',
            'msisdn' => $otp->mobile,
            'sms' => "Your OTP: $otp->otp_code will expire in 3 minutes",
            'csms_id' => uniqid(),
        ]);

        // $response = Http::get('http://worldtimeapi.org/api/timezone/Asia/Dhaka');

        $jsonData = $response->json();
        return $jsonData;

        // dd($jsonData);
        // dd($jsonData['smsinfo'][0]['sms_status']);
    }
}
