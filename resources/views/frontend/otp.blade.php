@extends('frontend.master')
@section('title', 'Dashboard')
@section('content')

    <div class="">
        <div class="page-header text-center" style="background-image: url({{ asset('frontend/images/page-header-bg.jpg') }})">
            <div class="container">
                <h1 class="page-title">{{ __('OTP') }}</h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->

        <div class="page-content">
            <div class="dashboard">
                <div class="container">
                    <div class="mt-5">
                        <div
                            style="font-family: Arial, sans-serif;  display: flex; justify-content: center; align-items: center;">
                            <div
                                style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px; width: 350px;">
                                @if (\Session::has('success'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>{{ Session::get('success') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                {{-- <a href="{{ route('otp.resend') }}">Request OTP</a> --}}
                                {{-- <h2>Enter OTP</h2> --}}
                                @if (session()->has('otpOn'))
                                    {{-- <div>Your OTP will expire in <span id="timer"></span></div> --}}
                                    <div id="timer">
                                        Your OTP will expire in: <span id="countdown">3:00</span>
                                    </div>
                                    <form action="{{ route('otp.verify') }}" method="post">
                                        @csrf
                                        <input type="text"
                                            style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;"
                                            name="otp_code" placeholder="Enter OTP" required>
                                        @error('otp_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        {{-- <div>
                                                <button type="submit"
                                                    style="background-color: #007BFF; color: #fff; border: none; border-radius: 4px; padding: 10px 20px; font-size: 16px; cursor: pointer;"
                                                    class="submit-button">Submit</button>
                                            </div>
                                            <div class="btn btn-outline-primary-2" id="otp-div"
                                                style="border: none; border-radius: 4px; padding: 10px 10px; font-size: 16px; cursor: pointer;">
                                                <a href="{{ route('otp.resend') }}" class="disabled-link text-black"
                                                    id="otp-resend-button">Resend OTP</a>
                                            </div> --}}
                                        <div class="dropdown-cart-action">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="{{ route('otp.resend') }}"
                                                class="btn btn-outline-primary-2 disabled-link"
                                                id="otp-resend-button"><span>Resend OTP</span><i
                                                    class="icon-long-arrow-right "></i></a>
                                        </div><!-- End .dropdown-cart-total -->
                                    </form>
                                @endif

                            </div>
                        </div>
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .dashboard -->
        </div><!-- End .page-content -->
    </div><!-- End .main -->

    {{-- <script>
        let timerOn = true;

        function timer(remaining) {
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('timer').innerHTML = m + ':' + s;
            remaining -= 1;

            if (remaining >= 0 && timerOn) {
                setTimeout(function() {
                    timer(remaining);
                }, 1000);
                return;
            }

            if (!timerOn) {
                // Do validate stuff here
                return;
            }

            // Do timeout stuff here
            // alert('Timeout for otp');
            document.getElementById('otp-button').classList.remove('disabled-link');

        }

        timer(180);
    </script> --}}

    {{-- Timer for OTP session --}}
    <script>
        // Get the initial timer duration from the session
        const initialDuration = {{ session('timer_duration', 60) }};

        const countdownElement = document.getElementById('countdown');
        var count = 1;

        function updateCountdown() {
            const now = new Date();
            const timerStart = new Date("{{ session('timer_start') }}");
            const elapsedTime = Math.floor((now - timerStart) / 1000);
            const remainingTime = initialDuration - elapsedTime;

            if (remainingTime <= 0) {
                countdownElement.textContent = 'Time expired';
                document.getElementById('otp-resend-button').classList.remove('disabled-link');
                
                if (count == 1) {
                    $.ajax({
                        url: '/otp/timedout',
                        type: 'GET',
                        success: function(response) {
                            // Handle the response, e.g., redirect to a login page
                        }
                    });
                    count = count + 1;
                }
            } else {
                const minutes = Math.floor(remainingTime / 60);
                const seconds = remainingTime % 60;
                countdownElement.textContent = `${minutes}:${(seconds < 10 ? '0' : '')}${seconds}`;
            }
        }

        // Update the countdown every second
        setInterval(updateCountdown, 1000);

        // Initial update
        updateCountdown();
    </script>
@endsection
