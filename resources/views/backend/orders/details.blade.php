@extends('backend.master')
@section('content')


<div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
    <div class="col-md-8 ">
        <div class="card" >
          <div class=" card-header justify-content-between ">
            <div>
              <h3 class="card-title">Order Details</h3>
            </div>
            <div>
              <div class="d-inline">
                <a class="btn btn-info" href="{{ route('orders.index') }}">Orders</a>
              </div>
            </div>
          </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">Product ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Each Price</th>
                        <th scope="col">Total Price</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails as $orderDetail)
                        <tr>
                          <th>{{ $orderDetail->id }}</th>
                          <td>{{ $orderDetail->order_id }}</td>
                          <td>{{ $orderDetail->product_id }}</td>
                          <td>{{ $orderDetail->product_name }}</td>
                          <td>{{ $orderDetail->quantity }}</td>
                          <td>&#2547;{{ $orderDetail->price_each }}</td>
                          <td>&#2547;{{ $orderDetail->total_price }}</td>
                          
                          
                        </tr>
                        @endforeach
                      
                    </tbody>
                  </table>
                  {{-- {{ $orderDetails->links('pagination::bootstrap-5') }} --}}
            </div>
          </div>    
    </div>
</div>

  

@endsection