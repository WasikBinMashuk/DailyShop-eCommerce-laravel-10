@extends('frontend.master')
@section('title', 'Home')
@section('content')

    <div class="mb-6"></div><!-- End .mb-6 -->

    <div class="container">

        <div class="row mb-6">
            <div class="col-lg-12">
                <div class="intro-slider-container slider-container-ratio slider-container-1 mb-2 mb-lg-0">
                    <div class="intro-slider intro-slider-1 owl-carousel owl-simple owl-light owl-nav-inside"
                        data-toggle="owl"
                        data-owl-options='{
                            "nav": false, 
                            "responsive": {
                                "768": {
                                    "nav": true
                                }
                            }
                        }'>
                        @foreach ($sliders as $slider)
                            <div class="intro-slide">

                                <figure class="slide-image">
                                    <picture>
                                        {{-- <source media="(max-width: 480px)" srcset="frontend/images/slider/slide-1-480w.jpg"> --}}
                                        <img src="{{ asset('images/sliders/' . $slider->slider_image) }}" alt="Image Desc">
                                    </picture>
                                </figure><!-- End .slide-image -->

                                <div class="intro-content">

                                    <h1 class="intro-title">{{ $slider->slider_title }}</h1><!-- End .intro-title -->

                                    <a href="{{ $slider->slider_link }}" target="_blank" class="btn btn-outline-white">
                                        <span>{{ __('text.SHOP NOW') }}</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </a>
                                </div><!-- End .intro-content -->


                            </div><!-- End .intro-slide -->
                        @endforeach
                    </div><!-- End .intro-slider owl-carousel owl-simple -->

                    <span class="slider-loader"></span><!-- End .slider-loader -->
                </div><!-- End .intro-slider-container -->
            </div><!-- End .col-lg-8 -->
        </div>

        <div class="container">
            <div class="heading heading-center mb-3">
                <h2 class="title-lg">{{ __('text.Trendy Products') }}</h2><!-- End .title -->
            </div><!-- End .heading -->

            <div class="tab-content tab-content-carousel">
                <div class="tab-pane p-0 fade show active" id="trendy-all-tab" role="tabpanel"
                    aria-labelledby="trendy-all-link">
                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":2
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>
                        @foreach ($trendy as $item)
                            <div class="product product-11 text-center">
                                <figure class="product-media">
                                    <a href="{{ route('product.show', $item->id) }}">
                                        <img src="{{ asset('images/' . $item->product_image) }}" alt="Product image"
                                            class="product-image">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist"><span>add to
                                                wishlist</span></a>
                                    </div><!-- End .product-action-vertical -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <h3 class="product-title"><a
                                            href="{{ route('product.show', $item->id) }}">{{ $item->product_name }}</a></h3>
                                    <!-- End .product-title -->
                                    <div class="product-price">
                                        &#2547;{{ $item->price }}
                                    </div><!-- End .product-price -->
                                </div><!-- End .product-body -->
                                <div class="product-action">
                                    <a href="{{ route('add_to_cart', $item->id) }}"
                                        class="btn-product btn-cart"><span>{{ __('text.add to cart') }}</span></a>
                                </div><!-- End .product-action -->
                            </div><!-- End .product -->
                        @endforeach



                    </div><!-- End .owl-carousel -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
        </div><!-- End .container -->

        <div class="container">
            <div class="heading heading-center mb-6">
                <h2 class="title-lg">{{ __('text.Recent Arrivals') }}</h2><!-- End .title -->
            </div><!-- End .heading -->

            <div class="tab-content">
                <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
                    <div class="products">
                        <div class="row justify-content-center">

                            @foreach ($products as $item)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="product product-11 mt-v3 text-center mb-5">
                                        <figure class="product-media">
                                            <a href="{{ route('product.show', $item->id) }}">
                                                @if ($item->product_image)
                                                    <img src="{{ asset('images/' . $item->product_image) }}"
                                                        alt="Product image" class="product-image">
                                                @else
                                                    <img src="{{ asset('images/no.jpg') }}">
                                                @endif
                                                {{-- <img src="frontend/images/demos/demo-2/products/product-8-2.jpg" alt="Product image" class="product-image-hover"> --}}
                                            </a>

                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                                        wishlist</span></a>
                                            </div><!-- End .product-action-vertical -->
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <h3 class="product-title"><a
                                                    href="{{ route('product.show', $item->id) }}">{{ $item->product_name }}</a>
                                            </h3><!-- End .product-title -->
                                            <div class="product-price">
                                                &#2547;{{ $item->price }}
                                            </div><!-- End .product-price -->
                                        </div><!-- End .product-body -->
                                        <div class="product-action">
                                            <a href="{{ route('add_to_cart', $item->id) }}"
                                                class="btn-product btn-cart"><span>{{ __('text.add to cart') }}</span></a>
                                        </div><!-- End .product-action -->
                                    </div><!-- End .product -->
                                </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                            @endforeach


                        </div><!-- End .row -->
                    </div><!-- End .products -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
            <div class="more-container text-center">
                <a href="{{ route('shop') }}"
                    class="btn btn-outline-darker btn-more"><span>{{ __('text.Go to shop for more') }}</span><i
                        class="icon-long-arrow-right"></i></a>
            </div><!-- End .more-container -->
        </div>
    </div><!-- End .container -->

@endsection
