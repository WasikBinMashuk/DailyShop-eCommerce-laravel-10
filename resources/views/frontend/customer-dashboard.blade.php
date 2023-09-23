@extends('frontend.master')
@section('content')

    <div class="">
        <div class="page-header text-center" style="background-image: url({{ asset('frontend/images/page-header-bg.jpg') }})">
            <div class="container">
                <h1 class="page-title">My Account<span>Shop</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Account</li>
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
                                    <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-downloads-link" data-toggle="tab" href="#tab-downloads" role="tab" aria-controls="tab-downloads" aria-selected="false">Downloads</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-address-link" data-toggle="tab" href="#tab-address" role="tab" aria-controls="tab-address" aria-selected="false">Adresses</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Account Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('customer/logout') }}">Sign Out</a>
                                </li>
                            </ul>
                        </aside><!-- End .col-lg-3 -->

                        <div class="col-md-8 col-lg-9">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                                    <p>Hello <span class="font-weight-normal text-dark">User</span> (not <span class="font-weight-normal text-dark">User</span>? <a href="#">Log out</a>) 
                                    <br>
                                    From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.</p>
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

                                <div class="tab-pane fade" id="tab-downloads" role="tabpanel" aria-labelledby="tab-downloads-link">
                                    <p>No downloads available yet.</p>
                                    <a href="category.html" class="btn btn-outline-primary-2"><span>GO SHOP</span><i class="icon-long-arrow-right"></i></a>
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="tab-address-link">
                                    <p>The following addresses will be used on the checkout page by default.</p>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card card-dashboard">
                                                <div class="card-body">
                                                    <h3 class="card-title">Billing Address</h3><!-- End .card-title -->

                                                    <p>User Name<br>
                                                    User Company<br>
                                                    John str<br>
                                                    New York, NY 10001<br>
                                                    1-234-987-6543<br>
                                                    yourmail@mail.com<br>
                                                    <a href="#">Edit <i class="icon-edit"></i></a></p>
                                                </div><!-- End .card-body -->
                                            </div><!-- End .card-dashboard -->
                                        </div><!-- End .col-lg-6 -->

                                        <div class="col-lg-6">
                                            <div class="card card-dashboard">
                                                <div class="card-body">
                                                    <h3 class="card-title">Shipping Address</h3><!-- End .card-title -->

                                                    <p>You have not set up this type of address yet.<br>
                                                    <a href="#">Edit <i class="icon-edit"></i></a></p>
                                                </div><!-- End .card-body -->
                                            </div><!-- End .card-dashboard -->
                                        </div><!-- End .col-lg-6 -->
                                    </div><!-- End .row -->
                                </div><!-- .End .tab-pane -->

                                <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
                                    <form action="#">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>First Name *</label>
                                                <input type="text" class="form-control" required>
                                            </div><!-- End .col-sm-6 -->

                                            <div class="col-sm-6">
                                                <label>Last Name *</label>
                                                <input type="text" class="form-control" required>
                                            </div><!-- End .col-sm-6 -->
                                        </div><!-- End .row -->

                                        <label>Display Name *</label>
                                        <input type="text" class="form-control" required>
                                        <small class="form-text">This will be how your name will be displayed in the account section and in reviews</small>

                                        <label>Email address *</label>
                                        <input type="email" class="form-control" required>

                                        <label>Current password (leave blank to leave unchanged)</label>
                                        <input type="password" class="form-control">

                                        <label>New password (leave blank to leave unchanged)</label>
                                        <input type="password" class="form-control">

                                        <label>Confirm new password</label>
                                        <input type="password" class="form-control mb-2">

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