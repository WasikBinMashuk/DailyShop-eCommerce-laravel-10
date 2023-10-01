@extends('frontend.master')
@section('title','Cart')
@section('content')

        <div class="">
        	<div class="page-header text-center" style="background-image: url({{ asset('frontend/images/page-header-bg.jpg') }})">
        		<div class="container">
        			<h1 class="page-title">{{ __('text.Shopping Cart') }}</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('text.Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('shop') }}">{{ __('text.Shop') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('text.Shopping Cart') }}</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="cart">
	                <div class="container">
	                	<div class="row">
	                		<div class="col-lg-9">
	                			<table class="table table-cart table-mobile">
									<thead>
										<tr>
											<th>{{ __('text.Product') }}</th>
											<th>{{ __('text.Price') }}</th>
											<th>{{ __('text.Quantity') }}</th>
											<th>{{ __('text.Total') }}</th>
											<th></th>
										</tr>
									</thead>

									<tbody>
										@php
											$total = 0
										@endphp
										@if (session('cart'))
										@foreach (session('cart') as $id => $details)
											@php
												$total += $details['price'] * $details['quantity']
											@endphp
											<tr data-id={{ $id }} id={{ $id }}>
												<td data-th="Product" class="product-col">
													<div class="product">
														<figure class="product-media">
															<a href="#">
																<img src="{{ asset('images/'.$details['product_image']) }}" width="100" height="100" alt="product">
															</a>
														</figure>
	
														<h3 class="product-title">
															<a href="{{ route('product.show', $id) }}">{{ $details['product_name'] }}</a>
														</h3><!-- End .product-title -->
													</div><!-- End .product -->
												</td>
												<td data-th="Price" class="price-col">&#2547;{{ $details['price'] }}</td>
												<td data-th="Quantity" class="quantity-col">
													<div class="cart-product-quantity">
														<input type="number" value="{{ $details['quantity'] }}" class="form-control quantity cart_update"  min="1" max="10">
													</div><!-- End .cart-product-quantity -->
												</td>
												<td data-th="Total" class="total-col">&#2547;{{ $details['price'] * $details['quantity'] }}</td>
												<td class="remove-col"><button class="btn-remove cart_remove"><i class="icon-close"></i></button></td>
											</tr>
										@endforeach
											
										@endif
										
										
									</tbody>
								</table><!-- End .table table-wishlist -->

	                			<div class="cart-bottom">
			            			{{-- <div class="cart-discount">
			            				<form action="#">
			            					<div class="input-group">
				        						<input type="text" class="form-control" required placeholder="coupon code">
				        						<div class="input-group-append">
													<button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
												</div><!-- .End .input-group-append -->
			        						</div><!-- End .input-group -->
			            				</form>
			            			</div><!-- End .cart-discount --> --}}

			            			{{-- <a href="#" class="btn btn-outline-dark-2"><span>CLEAR CART</span><i class="icon-refresh"></i></a> --}}
		            			</div><!-- End .cart-bottom -->

	                		</div><!-- End .col-lg-9 -->
	                		<aside class="col-lg-3">
	                			<div class="summary summary-cart">
	                				<h3 class="summary-title">{{ __('text.Cart Total') }}</h3><!-- End .summary-title -->

	                				<table class="table table-summary">
	                					<tbody>
	                						<tr class="summary-subtotal">
	                							<td>{{ __('text.Subtotal') }}:</td>
	                							<td>&#2547;{{ $total }}</td>
	                						</tr><!-- End .summary-subtotal -->

	                					</tbody>
	                				</table><!-- End .table table-summary -->

	                				<a href="{{ route('checkout') }}" class="btn btn-outline-primary-2 btn-order btn-block">{{ __('text.PROCEED TO CHECKOUT') }}</a>
	                			</div><!-- End .summary -->

		            			<a href="{{ route('shop') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>{{ __('text.CONTINUE SHOPPING') }}</span><i class="icon-refresh"></i></a>
	                		</aside><!-- End .col-lg-3 -->
	                	</div><!-- End .row -->
	                </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </div><!-- End .main -->

{{-- <script type="text/javascript">

	$(".cart_update").change(function (e){
		// alert("Hello! I am an alert box!!");
		e.preventDefault();

		var ele = $(this);

		$.ajax({
			url:'{{ route('update_cart') }}',
			method: "patch",
			data: {
				_token: '{{ csrf_token() }}',
				id: ele.parents("tr").attr("data-id"),
				quantity: ele.parents("tr").find(".quantity").val()
			},
			success: function (response){
				window.location.reload();
			}
		});
	});

	$(".cart_remove").click(function (e) {
		e.preventDefault();

		var ele = $(this);

		if(confirm("Do you really want to remove?")){
			$.ajax({
				url: '{{ route('remove_from_cart') }}',
				method: "DELETE",
				data: {
					_token: '{{ csrf_token() }}',
					id: ele.parents("tr").attr("data-id")
				},
				success: function (response){
					window.location.reload();
				}
			});
		}
	});
</script> --}}

@endsection