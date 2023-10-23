<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        return view('backend.dashboard');
    }

    public function api()
    {
        $response = Http::post('http://ismsapi.publicdemo.xyz/api/v3/send-sms', [
            'api_token' => 'id21k6pn-hfecd5j0-8twu0ho3-5j0avf06-rbhikgtz',
            'sid' => 'SSLW',
            'msisdn' => '01685010517',
            'sms' => 'Hello World',
            'csms_id' => uniqid(),
        ]);

        // $response = Http::get('http://worldtimeapi.org/api/timezone/Asia/Dhaka');

        $jsonData = $response->json();

        dd($jsonData);
        dd($jsonData['smsinfo'][0]['sms_status']);
    }
}
