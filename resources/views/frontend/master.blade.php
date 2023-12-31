<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - DailyShop</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/icons/favicon-new.png') }}">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/magnific-popup/magnific-popup.css') }}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        .disabled-link {
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">

                        <select class="form-select lang-change" style="color: gray; border:none" name=""
                            id="">
                            <option value="en" {{ session()->get('lang_code') == 'en' ? 'selected' : '' }}>ENG
                            </option>
                            <option value="bn" {{ session()->get('lang_code') == 'bn' ? 'selected' : '' }}>BN
                            </option>
                        </select>
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <ul class="top-menu">
                            <li>
                                <a href="#">Links</a>
                                <ul>

                                    <li><a href="#"><i class="icon-heart-o"></i>My Wishlist <span>(3)</span></a>
                                    </li>
                                    <li><a href="#">{{ __('text.About Us') }}</a></li>
                                    <li><a href="#">{{ __('text.Contact Us') }}</a></li>

                                    @if (Auth::guard('customer')->check())
                                        <li><a href="{{ route('customer.dashboard') }}"><i
                                                    class="icon-user"></i>{{ Auth::guard('customer')->user()->name }}</a>
                                        </li>
                                    @else
                                        <li><a href="#signin-modal" data-toggle="modal"><i
                                                    class="icon-user"></i>{{ __('text.login') }}</a></li>
                                    @endif

                                </ul>
                            </li>
                        </ul><!-- End .top-menu -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-top -->

            <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <a href="{{ route('home') }}" class="logo">
                            {{-- <img src="{{ asset('frontend/images/logo.png') }}" alt="Molla Logo" width="105" height="25"> --}}
                            <img src="{{ asset('frontend/images/logo-new.png') }}" alt="Molla Logo" width="165"
                                height="30">
                        </a>

                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="megamenu-container active">
                                    <a href="{{ route('home') }}" class="">{{ __('text.Home') }}</a>
                                </li>

                                <li>
                                    <a href="{{ route('shop') }}" class="sf-with-ul">{{ __('text.Shop') }}</a>

                                    <ul>
                                        {{-- <li>
                                            <a href="about.html" class="sf-with-ul">About</a>

                                            <ul>
                                                <li><a href="about.html">About 01</a></li>
                                                <li><a href="about-2.html">About 02</a></li>
                                            </ul>
                                        </li> --}}
                                        @foreach ($shopCategories as $item)
                                            <li><a
                                                    href="{{ route('shop', ['category_id' => $item->id]) }}">{{ $item->category_name }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </li>
                                <li>
                                    <a href="blog.html" class="sf-with-ul">{{ __('text.Blog') }}</a>

                                    <ul>
                                        <li><a href="blog.html">Classic</a></li>
                                        <li><a href="blog-listing.html">Listing</a></li>
                                        <li>
                                            <a href="#">Grid</a>
                                            <ul>
                                                <li><a href="blog-grid-2cols.html">Grid 2 columns</a></li>
                                                <li><a href="blog-grid-3cols.html">Grid 3 columns</a></li>
                                                <li><a href="blog-grid-4cols.html">Grid 4 columns</a></li>
                                                <li><a href="blog-grid-sidebar.html">Grid sidebar</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Masonry</a>
                                            <ul>
                                                <li><a href="blog-masonry-2cols.html">Masonry 2 columns</a></li>
                                                <li><a href="blog-masonry-3cols.html">Masonry 3 columns</a></li>
                                                <li><a href="blog-masonry-4cols.html">Masonry 4 columns</a></li>
                                                <li><a href="blog-masonry-sidebar.html">Masonry sidebar</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Mask</a>
                                            <ul>
                                                <li><a href="blog-mask-grid.html">Blog mask grid</a></li>
                                                <li><a href="blog-mask-masonry.html">Blog mask masonry</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Single Post</a>
                                            <ul>
                                                <li><a href="single.html">Default with sidebar</a></li>
                                                <li><a href="single-fullwidth.html">Fullwidth no sidebar</a></li>
                                                <li><a href="single-fullwidth-sidebar.html">Fullwidth with sidebar</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <div class="header-search">
                            <a href="" class="search-toggle" role="button" title="Search"><i
                                    class="icon-search"></i></a>
                            <form action="{{ route('shop') }}" method="get">
                                <div class="header-search-wrapper">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="search" id="q"
                                        placeholder="Search in..." required>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->

                        <div class="dropdown cart-dropdown">
                            <a href="{{ route('cart') }}" class="dropdown-toggle" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                data-display="static">
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count">{{ count((array) session('cart')) }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">
                                    @php
                                        $total = 0;
                                    @endphp
                                    @if (session('cart'))
                                        @foreach (session('cart') as $id => $details)
                                            <div class="product">
                                                <div class="product-cart-details">
                                                    <h4 class="product-title">
                                                        <a
                                                            href="{{ route('product.show', $id) }}">{{ $details['product_name'] }}</a>
                                                    </h4>
                                                    <span class="cart-product-info">
                                                        <span
                                                            class="cart-product-qty">{{ $details['quantity'] }}</span>
                                                        x &#2547;{{ $details['price'] }}
                                                    </span>
                                                </div><!-- End .product-cart-details -->
                                                <figure class="product-image-container">
                                                    <a href="{{ route('product.show', $id) }}" class="product-image">
                                                        {{-- <img src="{{ asset('images') }}/{{ $details['product_image'] }}" alt="product"> --}}
                                                        <img src="{{ asset('images/' . $details['product_image']) }}"
                                                            alt="product">
                                                    </a>
                                                </figure>
                                                {{-- <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a> --}}
                                            </div><!-- End .product -->

                                            @php
                                                $total += $details['price'] * $details['quantity'];
                                            @endphp
                                        @endforeach
                                    @endif

                                </div><!-- End .cart-product -->

                                <div class="dropdown-cart-total">
                                    <span>{{ __('text.Total') }}</span>
                                    <span class="cart-total-price">&#2547;{{ $total }}</span>
                                </div><!-- End .dropdown-cart-total -->

                                <div class="dropdown-cart-action">
                                    <a href="{{ route('cart') }}"
                                        class="btn btn-primary">{{ __('text.View Cart') }}</a>
                                    <a href="{{ route('checkout') }}"
                                        class="btn btn-outline-primary-2"><span>{{ __('text.Checkout') }}</span><i
                                            class="icon-long-arrow-right"></i></a>
                                </div><!-- End .dropdown-cart-total -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->
        </header><!-- End .header -->

        <main class="main">

            @yield('content');

        </main><!-- End .main -->

        <footer class="footer footer-dark">
            <div class="footer-bottom">
                <div class="container justify-content-center">
                    <p class="">Copyright © 2019 Molla Store. All Rights Reserved.</p>
                    <!-- End .footer-copyright -->

                </div><!-- End .container -->
            </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>



    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin"
                                        role="tab" aria-controls="signin"
                                        aria-selected="true">{{ __('text.Sign In') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register"
                                        role="tab" aria-controls="register"
                                        aria-selected="false">{{ __('text.Register') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade active show" id="signin" role="tabpanel"
                                    aria-labelledby="signin-tab">
                                    <form action="{{ route('customer.login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="singin-email">{{ __('text.Email address') }} <b
                                                    class="required">*</b></label>
                                            <input type="text" class="form-control" id="singin-email"
                                                name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="singin-password">{{ __('text.Password') }} <b
                                                    class="required">*</b></label>
                                            <input type="password" class="form-control" id="singin-password"
                                                name="password" required>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>{{ __('text.LOG IN') }}</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Remember
                                                    Me</label>
                                            </div><!-- End .custom-checkbox -->

                                            <a href="#" class="forgot-link">Forgot Your Password?</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                </div><!-- .End .tab-pane -->
                                <div class="tab-pane fade" id="register" role="tabpanel"
                                    aria-labelledby="register-tab">
                                    <form action="{{ route('customer.register') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>{{ __('text.Name') }} *</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}" required>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label>{{ __('text.Email address') }} *</label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label>{{ __('text.Password') }} *</label>
                                            <input type="password" class="form-control" name="password" required>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="register-password">{{ __('text.Confirm password') }} *</label>
                                            <input type="password" class="form-control" id="register-password"
                                                name="password_confirmation" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-group">
                                            <label for="register-email">{{ __('text.Mobile') }} *</label>
                                            <input type="text" class="form-control" id="register-email"
                                                name="mobile" value="{{ old('mobile') }}" required>
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>{{ __('text.SIGN UP') }}</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div><!-- End .form-footer -->
                                    </form>
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->


    @include('sweetalert::alert')

    <!-- Plugins JS File -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/superfish.min.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    {{-- CART update and delete scripts --}}
    <script type="text/javascript">
        $(".cart_update").change(function(e) {
            // alert("Hello! I am an alert box!!");
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: '{{ route('update_cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $(".cart_remove").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            if (confirm("Do you really want to remove?")) {
                $.ajax({
                    url: '{{ route('remove_from_cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                        // $('#' + ele.parents("tr").attr("data-id")).remove();
                    }
                });
            }
        });
    </script>

    {{-- Script for localization --}}
    <script type="text/javascript">
        var url = "{{ route('lang.change') }}";

        $('.lang-change').change(function() {
            let lang_code = $(this).val();
            window.location.href = url + "?lang=" + lang_code;
        });
    </script>

    {{-- MODAL auto open after validation fails --}}
    @if (count($errors) > 0)
        <script type="text/javascript">
            @if (session('register_tab_open'))
                $(document).ready(function() {
                    $('#signin-modal').modal('show');
                    document.getElementById('register-tab').classList.add('active');
                    document.getElementById('register').classList.add('active', 'show');
                    document.getElementById('signin').classList.remove('active', 'show');
                    document.getElementById('signin-tab').classList.remove('active');
                });
                @php session()->forget('register_tab_open'); @endphp
            @endif
            @if (session('signin_tab_open'))
                $(document).ready(function() {
                    $('#signin-modal').modal('show');
                    document.getElementById('signin-tab').classList.add('active');
                    document.getElementById('signin').classList.add('active', 'show');
                    document.getElementById('register').classList.remove('active', 'show');
                });
                @php session()->forget('signin_tab_open'); @endphp
            @endif
        </script>
    @endif

    {{-- MODAL auto open and signin tab active script --}}
    <script>
        // Check if the session variable is set
        @if (session('keep_modal_open'))
            // Opening the modal using JavaScript
            $(document).ready(function() {
                $('#signin-modal').modal('show');
                document.getElementById('signin-tab').classList.add('active');
            });
            @php session()->forget('keep_modal_open'); @endphp
        @endif
    </script>
</body>

</html>
