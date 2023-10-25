<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OtpController extends Controller
{
    public function otp()
    {
        return view('frontend.otp');
    }

    public function verify(Request $request)
    {

        $result = Otp::where('otp_code', $request->otp_code)->Where('customer_id', $request->session()->get('customerId'))->first();


        if ($result) {
            if (strtotime($result->expire_at) > strtotime(now())) {
                $customer = Customer::find($result->customer_id)->update([
                    'otp_verified' => 1,
                ]);
                Otp::where('customer_id', $result->customer_id)->update([
                    'isUsed' => 1,
                ]);

                // Set a session variable to indicate the modal should be open
                session()->put('keep_modal_open', true);

                $request->session()->forget('customerId');
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
        $otp = Otp::where('customer_id', $request->session()->get('customerId'))->where('isUsed', 0)->first();

        $otp->update([
            'otp_code' => env('APP_ENV') == 'local' ? '123456' : random_int(100000, 999999),
            'expire_at' => now()->addMinutes(3),
        ]);

        $response = Http::post('http://ismsapi.publicdemo.xyz/api/v3/send-sms', [
            'api_token' => 'id21k6pn-hfecd5j0-8twu0ho3-5j0avf06-rbhikgtz',
            'sid' => 'SSLW',
            'msisdn' => $otp->mobile,
            'sms' => "Your OTP: $otp->otp_code will expire in 3 minutes",
            'csms_id' => uniqid(),
        ]);

        return redirect()->back();
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
