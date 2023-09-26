@extends('frontend.master')
@section('content')

    <div class="">
        <div class="page-header text-center" style="background-image: url({{ asset('frontend/images/page-header-bg.jpg') }})">
            <div class="container">
                <h1 class="page-title">{{ __('text.My Account') }}</h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('text.Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">{{ __('text.Shop') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('text.My Account') }}</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="dashboard">
                <div class="container">
                    <div class="row">
                        <aside class="col-md-4 col-lg-3">
                            <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">{{ __('text.Profile') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">{{ __('text.Orders') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="false">{{ __('text.Address') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">{{ __('text.Change Password') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('customer/logout') }}">{{ __('text.Sign Out') }}</a>
                                </li>
                            </ul>
                        </aside><!-- End .col-lg-3 -->

                        <div class="col-md-8 col-lg-9">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                                    <form action="{{ route('customer.update') }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label >{{ __('text.Name') }}</label>
                                            <input type="text" class="form-control"  name="name" value="{{ $profile->name }}" required>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label >{{ __('text.Email address') }}</label>
                                            <input type="email" class="form-control"  name="email" value="{{ $profile->email }}" required>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label >{{ __('text.Mobile') }}</label>
                                            <input type="text" class="form-control"  name="mobile" value="{{ $profile->mobile }}" required>
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div><!-- End .form-group -->

                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>{{ __('text.SAVE CHANGES') }}</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </form>
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">

                                    @if ($orders->isEmpty())
                                        <p>No order has been made yet.</p>
                                    @endif

                                    @foreach ($orders as $order)
                                    <div class="row p-2 bg-white border rounded mt-2">
                                        <div class="col-md-6 mt-1">
                                            <h5 style="color: orange">Order ID. {{ $order->id }}</h5>
                                            <h6>Products: </h6>
                                            
                                            <div class="mt-1 mb-1 spec-1">
                                                @foreach ($orderDetails as $detail)

                                                    @if ($detail->order_id == $order->id)
                                                        <li>{{ $detail->product_name }} x{{ $detail->quantity }}</li>
                                                    @endif

                                                @endforeach
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="align-items-center align-content-center col-md-6 border-left mt-1">
                                            <div class="d-flex flex-row align-items-center">
                                                <h4 class="mr-1" style="color: orange">Total price: <span class="text-dark">&#2547;{{ $order->subtotal }}</span></h4>
                                            </div>
                                            <div class="d-flex flex-column mt-4">
                                                <span class="badge bg-light h5 " style="height: 30px; ">Order Status</span>
                                                
                                                @if ( $order->status == 1)
                                                    <span class="badge  h5 " style="height: 30px; background-color:rgb(157, 103, 2)">Processing</span>
                                                
                                                
                                                @elseif ($order->status  == 2)
                                                    <span class="badge  h5 " style="height: 30px; background-color:rgb(245, 192, 93)">Shipped</span>
                                                
                                                @elseif ( $order->status  == 3)
                                                    <span class="badge  h5 " style="height: 30px; background-color:rgb(0, 144, 29)">Delivered</span>
                                                
                                                @else
                                                    <span class="badge  h5 " style="height: 30px; background-color:rgb(255, 43, 43)">Failed</span>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                      
                                    
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
                                    <p>The following addresses will be used on the checkout page by default.</p>

                                    <div>
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Shipping Address</h3><!-- End .card-title -->

                                                <form action="{{ route('customer.change.address') }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label>Address</label>
                                                            <input type="text" name="address" class="form-control" value="{{ $profile->address }}" required>
                                                            @error('address')
                                                                <span class="text-danger">{{ $message }}</span>
                                                             @enderror
                                                        </div><!-- End .col-sm-6 -->
                                                        <div class="col-sm-6">
                                                            <label>Town / City</label>
                                                            <input type="text" name="city" class="form-control" value="{{ $profile->city }}" required>
                                                            @error('city')
                                                                <span class="text-danger">{{ $message }}</span>
                                                             @enderror
                                                        </div><!-- End .col-sm-6 -->
    
                                                        <div class="col-sm-6">
                                                            <label>State / Country</label>
                                                            <input type="text" name="country" class="form-control" value="{{ $profile->country }}" required>
                                                            @error('country')
                                                                <span class="text-danger">{{ $message }}</span>
                                                             @enderror
                                                        </div><!-- End .col-sm-6 -->
            
                                                        <div class="col-sm-6">
                                                            <label>Postcode / ZIP *</label>
                                                            <input type="text" name="postcode" class="form-control" value="{{ $profile->postcode }}" required>
                                                            @error('postcode')
                                                                <span class="text-danger">{{ $message }}</span>
                                                             @enderror
                                                        </div><!-- End .col-sm-6 -->

                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-outline-primary-2">
                                                                <span>SAVE CHANGES</span>
                                                                <i class="icon-long-arrow-right"></i>
                                                            </button>
                                                        </div>
                                                    </div><!-- End .row -->
                                                </form>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
                                    <form action="{{ route('customer.change.password') }}" method="POST">
                                        @csrf
                                        <div>
                                            <label>Old password (leave blank to leave unchanged)</label>
                                            <input type="password" class="form-control" name="old_password">
                                            @error('old_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label>New password (leave blank to leave unchanged)</label>
                                            <input type="password" class="form-control" name="password">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label>Confirm new password</label>
                                            <input type="password" class="form-control mb-2" name="password_confirmation">
                                        </div>

                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>SAVE CHANGES</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </form>
                                </div><!-- .End .tab-pane -->
                            </div>
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .dashboard -->
        </div><!-- End .page-content -->
    </div><!-- End .main -->

@endsection