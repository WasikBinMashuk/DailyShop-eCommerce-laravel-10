@extends('frontend.master')
@section('title', 'Checkout')
@section('content')


    <div class="">
        <div class="page-header text-center" style="background-image: url({{ asset('frontend/images/page-header-bg.jpg') }})">
            <div class="container">
                <h1 class="page-title">{{ __('text.Checkout') }}</h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('text.Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">{{ __('text.Shop') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('text.Checkout') }}</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="checkout">
                <div class="container">
                    {{-- <div class="checkout-discount">
            				<form action="#">
        						<input type="text" class="form-control" required id="checkout-discount-input">
            					<label for="checkout-discount-input" class="text-truncate">Have a coupon? <span>Click here to enter your code</span></label>
            				</form>
            			</div><!-- End .checkout-discount --> --}}
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-9">
                                <h2 class="checkout-title">{{ __('text.Shipping Details') }}</h2>
                                <!-- End .checkout-title -->
                                <div>
                                    <label>{{ __('text.Name') }} *</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', Auth::guard('customer')->user()->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label>{{ __('text.Company Name') }} (Optional)</label>
                                    <input type="text" name="company_name" class="form-control"
                                        value="{{ old('company_name') }}">
                                    @error('company_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label>{{ __('text.Address') }} *</label>
                                    <input type="text" name="address" class="form-control"
                                        placeholder="House number and Street name"
                                        value="{{ old('address', $customer->address) }}" required>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>{{ __('text.Town / City') }} *</label>
                                        <input type="text" name="city" class="form-control"
                                            value="{{ old('city', $customer->city) }}" required>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>{{ __('text.State / County') }} *</label>
                                        <input type="text" name="country" class="form-control"
                                            value="{{ old('country', $customer->country) }}" required>
                                        @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>{{ __('text.Postcode / ZIP') }} *</label>
                                        <input type="text" name="postcode" class="form-control"
                                            value="{{ old('postcode', $customer->postcode) }}" required>
                                        @error('postcode')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>{{ __('text.Mobile') }} *</label>
                                        <input type="tel" name="mobile" class="form-control"
                                            value="{{ old('mobile', Auth::guard('customer')->user()->mobile) }}" required>
                                        @error('mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <div>
                                    <label>{{ __('text.Email address') }} *</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', Auth::guard('customer')->user()->email) }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkout-create-acc"
                                        name="saveAddress" value="1">
                                    <label class="custom-control-label"
                                        for="checkout-create-acc">{{ __('text.Save address for next orders?') }}</label>
                                </div><!-- End .custom-checkbox -->

                                <div>
                                    <label>{{ __('text.Order notes') }} (optional)</label>
                                    <textarea class="form-control" name="order_notes" cols="30" rows="4"
                                        placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                                    @error('order_notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div><!-- End .col-lg-9 -->

                            <aside class="col-lg-3">
                                <div class="summary">
                                    <h3 class="summary-title">{{ __('text.Your Order') }}</h3><!-- End .summary-title -->

                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>{{ __('text.Product') }}</th>
                                                <th>{{ __('text.Total') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @if (session('cart'))
                                                @foreach (session('cart') as $id => $details)
                                                    @php
                                                        $total += $details['price'] * $details['quantity'];
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            {{ $details['product_name'] }}
                                                        </td>
                                                        <td>{{ $details['quantity'] }} x &#2547;{{ $details['price'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr class="summary-total">
                                                <td>{{ __('text.Total') }}:</td>
                                                <td>&#2547;{{ $total }}</td>
                                            </tr><!-- End .summary-total -->
                                        </tbody>
                                    </table><!-- End .table table-summary -->

                                    {{-- <div class="accordion-summary" id="accordion-payment">
										    <div class="card">
										        <div class="card-header" id="heading-1">
										            <h2 class="card-title">
										                <a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
										                    Direct bank transfer
										                </a>
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-payment">
										            <div class="card-body">
										                Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
										            </div><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->

										    <div class="card">
										        <div class="card-header" id="heading-2">
										            <h2 class="card-title">
										                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
										                    Check payments
										                </a>
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion-payment">
										            <div class="card-body">
										                Ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. 
										            </div><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->

										    <div class="card">
										        <div class="card-header" id="heading-3">
										            <h2 class="card-title">
										                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
										                    Cash on delivery
										                </a>
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordion-payment">
										            <div class="card-body">Quisque volutpat mattis eros. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. 
										            </div><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->

										    <div class="card">
										        <div class="card-header" id="heading-4">
										            <h2 class="card-title">
										                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
										                    PayPal <small class="float-right paypal-link">What is PayPal?</small>
										                </a>
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-payment">
										            <div class="card-body">
										                Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum.
										            </div><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->

										    <div class="card">
										        <div class="card-header" id="heading-5">
										            <h2 class="card-title">
										                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
										                    Credit Card (Stripe)
										                    <img src="assets/images/payments-summary.png" alt="payments cards">
										                </a>
										            </h2>
										        </div><!-- End .card-header -->
										        <div id="collapse-5" class="collapse" aria-labelledby="heading-5" data-parent="#accordion-payment">
										            <div class="card-body"> Donec nec justo eget felis facilisis fermentum.Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Lorem ipsum dolor sit ame.
										            </div><!-- End .card-body -->
										        </div><!-- End .collapse -->
										    </div><!-- End .card -->
										</div><!-- End .accordion --> --}}

                                    @if (session('cart'))
                                        <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                            <span class="btn-text">{{ __('text.Place Order') }}</span>
                                            <span class="btn-hover-text">{{ __('text.PROCEED TO CHECKOUT') }}</span>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block"
                                            disabled>
                                            <span class="btn-text">{{ __('text.Place Order') }}</span>
                                            <span class="btn-hover-text">{{ __('text.Your Cart is Empty') }}</span>
                                        </button>
                                    @endif

                                </div><!-- End .summary -->
                            </aside><!-- End .col-lg-3 -->
                        </div><!-- End .row -->
                    </form>
                </div><!-- End .container -->
            </div><!-- End .checkout -->
        </div><!-- End .page-content -->
    </div><!-- End .main -->

@endsection
