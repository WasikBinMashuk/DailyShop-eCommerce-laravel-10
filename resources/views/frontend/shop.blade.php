@extends('frontend.master')
@section('content')


        <div class="">
        	<div class="page-header text-center" style="background-image: url({{ asset('frontend/images/page-header-bg.jpg') }})">
        		<div class="container">
        			<h1 class="page-title">Shop</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
        			

                    <div class="products">
                        <div class="row">
                            @foreach ($products as $item)
                                <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                                    <div class="product">
                                        <figure class="product-media">
                                            <a href="{{ route('product.show', $item->id) }}">
                                                @if($item->product_image)
                                                    <img src="{{ asset('images/'.$item->product_image) }}" alt="Product image" class="product-image" style="height: 280px;width:280px;" >
                                                @else 
                                                    <img src="{{ asset('images/no.jpg') }}" >
                                                @endif
                                            </a>

                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                            </div><!-- End .product-action -->

                                            <div class="product-action action-icon-top">
                                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                            </div><!-- End .product-action -->
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <div class="product-cat">
                                                <a href="#">{{ $item->sub_category_name }}</a>
                                            </div><!-- End .product-cat -->
                                            <h3 class="product-title"><a href="#">{{ $item->product_name }}</a></h3><!-- End .product-title -->
                                            <div class="product-price">
                                                {{ $item->price }}bdt
                                            </div><!-- End .product-price -->
                                        </div><!-- End .product-body -->
                                    </div><!-- End .product -->
                                </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                            @endforeach
                            
                        </div><!-- End .row -->
                        {{ $products->links('pagination::bootstrap-5') }}

                        {{-- <div class="load-more-container text-center">
                            <a href="#" class="btn btn-outline-darker btn-load-more">More Products <i class="icon-refresh"></i></a>
                        </div><!-- End .load-more-container --> --}}
                    </div><!-- End .products -->

                    
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </div><!-- End .main -->

@endsection