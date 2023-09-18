@extends('frontend.master')
@section('content')

        <div class="">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
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
											<th>Product</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Total</th>
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
											<tr data-id={{ $id }}>
												<td data-th="Product" class="product-col">
													<div class="product">
														<figure class="product-media">
															<a href="#">
																<img src="{{ asset('images') }}/{{ $details['product_image'] }}" width="100" height="100" alt="product">
															</a>
														</figure>
	
														<h3 class="product-title">
															<a href="#">{{ $details['product_name'] }}</a>
														</h3><!-- End .product-title -->
													</div><!-- End .product -->
												</td>
												<td data-th="Price" class="price-col">${{ $details['price'] }}</td>
												<td data-th="Quantity" class="quantity-col">
													<div class="cart-product-quantity">
														<input type="number" value="{{ $details['quantity'] }}" class="form-control quantity cart_update"  min="1">
													</div><!-- End .cart-product-quantity -->
												</td>
												<td data-th="Total" class="total-col">${{ $details['price'] * $details['quantity']}}</td>
												<td class="remove-col"><button class="btn-remove cart_remove"><i class="icon-close"></i></button></td>
											</tr>

										@endforeach
											
										@endif
										
										
									</tbody>
								</table><!-- End .table table-wishlist -->

	                			<div class="cart-bottom">
			            			<div class="cart-discount">
			            				<form action="#">
			            					<div class="input-group">
				        						<input type="text" class="form-control" required placeholder="coupon code">
				        						<div class="input-group-append">
													<button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
												</div><!-- .End .input-group-append -->
			        						</div><!-- End .input-group -->
			            				</form>
			            			</div><!-- End .cart-discount -->

			            			<a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a>
		            			</div><!-- End .cart-bottom -->
	                		</div><!-- End .col-lg-9 -->
	                		<aside class="col-lg-3">
	                			<div class="summary summary-cart">
	                				<h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

	                				<table class="table table-summary">
	                					<tbody>
	                						<tr class="summary-subtotal">
	                							<td>Subtotal:</td>
	                							<td>${{ $total }}</td>
	                						</tr><!-- End .summary-subtotal -->

	                					</tbody>
	                				</table><!-- End .table table-summary -->

	                				<a href="checkout.html" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
	                			</div><!-- End .summary -->

		            			<a href="{{ route('shop') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
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