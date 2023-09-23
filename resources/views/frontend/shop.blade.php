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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
        			
                    <div class="toolbox">
        				<div class="toolbox-left">
                            <a href="#" class="sidebar-toggler"><i class="icon-bars"></i>Filters</a>
        				</div><!-- End .toolbox-left -->
                        {{-- <div class="toolbox-right">
        					<div class="toolbox-sort">
        						<div class="header-search">
                                    <a href="#" class="search-toggle" role="button" title="Search"><i class="icon-search"></i></a>
                                    <form action="" method="get">
                                        <div class="header-search-wrapper">
                                            <label for="search" class="sr-only">Search</label>
                                            <input type="search" class="form-control" name="search" id="search" placeholder="Search in..." required>
                                        </div><!-- End .header-search-wrapper -->
                                    </form>
                                </div><!-- End .header-search -->
        					</div><!-- End .toolbox-sort -->
        				</div><!-- End .toolbox-right --> --}}
        			</div><!-- End .toolbox -->

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
                                                <a href="{{ route('add_to_cart', $item->id) }}" class="btn-product btn-cart"><span>add to cart</span></a>
                                            </div><!-- End .product-action -->
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <div class="product-cat">
                                                <a href="#">{{ $item->sub_category_name }}</a>
                                            </div><!-- End .product-cat -->
                                            <h3 class="product-title"><a href="#">{{ $item->product_name }}</a></h3><!-- End .product-title -->
                                            <div class="product-price">
                                                &#2547;{{ $item->price }}
                                            </div><!-- End .product-price -->
                                        </div><!-- End .product-body -->
                                    </div><!-- End .product -->
                                </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                            @endforeach
                            
                        </div><!-- End .row -->
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div><!-- End .products -->

                    <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
                    <aside class="sidebar-shop sidebar-filter">
                        <div class="sidebar-filter-wrapper">
                            <div class="widget widget-clean">
                                <label><i class="icon-close"></i>Filters</label>
                                <a href="#" class="sidebar-filter-clear">Clean All</a>
                            </div><!-- End .widget -->
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                        Category
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-1">
                                    <div class="widget-body">
                                        <div class="filter-items filter-items-count">
                                            @foreach ($categories as $item)
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    {{-- <input type="checkbox" class="custom-control-input" id="cat-1">
                                                    <label class="custom-control-label" for="cat-1">{{ $item->category_name }}</label> --}}
                                                    <a href="{{ route('shop', ['category_id' => $item->id]) }}">{{ $item->category_name }}</a>
                                                </div><!-- End .custom-checkbox -->
                                                <span class="item-count">3</span>
                                            </div><!-- End .filter-item -->
                                            @endforeach
                                            

                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                        </div><!-- End .sidebar-filter-wrapper -->
                    </aside><!-- End .sidebar-filter -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </div><!-- End .main -->

@endsection