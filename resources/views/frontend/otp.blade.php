@extends('frontend.master')
@section('title', 'Dashboard')
@section('content')

    <div class="">
        <div class="page-header text-center" style="background-image: url({{ asset('frontend/images/page-header-bg.jpg') }})">
            <div class="container">
                <h1 class="page-title">{{ __('Enter OTP') }}</h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->

        <div class="page-content">
            <div class="dashboard">
                <div class="container">
                    <div class="row">
                        <div
                            style="font-family: Arial, sans-serif; background-color: #f5f5f5; display: flex; justify-content: center; align-items: center;">
                            <div
                                style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px; width: 300px;">
                                @if (\Session::has('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('success') }}
                                        <a href="{{ route('otp.resend') }}">Resend OTP</a>
                                    </div>
                                @endif
                                <h2>Enter OTP</h2>
                                <form action="{{ route('otp.verify') }}" method="post">
                                    @csrf
                                    <input type="text"
                                        style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;"
                                        name="otp_code" placeholder="Enter OTP" required>
                                    <button type="submit"
                                        style="background-color: #007BFF; color: #fff; border: none; border-radius: 4px; padding: 10px 20px; font-size: 16px; cursor: pointer;"
                                        class="submit-button">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .dashboard -->
        </div><!-- End .page-content -->
    </div><!-- End .main -->

@endsection
