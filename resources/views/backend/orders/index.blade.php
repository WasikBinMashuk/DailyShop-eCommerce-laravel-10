@extends('backend.master')
@section('content')


<div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
    <div class="col-md-12 ">
        <div class="card" >
          <div class=" card-header justify-content-between ">
            <div>
              <h3 class="card-title">orders Table</h3>
            </div>
            <div>
              <div class="d-inline">
                {{-- <a class="btn btn-info" href="{{ route('orders.create') }}">Add order</a> --}}
              </div>
            </div>
          </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">City</th>
                        <th scope="col">Country</th>
                        <th scope="col">Postcode</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Email</th>
                        <th scope="col">Order notes</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                          <th>{{ $order->id }}</th>
                          <td>{{ $order->name }}</td>
                          <td>
                                @if ($order->company_name == null)
                                    <span>---</span>
                                @endif
                                {{ $order->company_name }}
                            </td>
                          <td>{{ $order->address }}</td>
                          <td>{{ $order->city }}</td>
                          <td>{{ $order->country }}</td>
                          <td>{{ $order->postcode }}</td>
                          <td>{{ $order->mobile }}</td>
                          <td>{{ $order->email }}</td>
                          <td>
                            @if ($order->order_notes == null)
                                    <span>---</span>
                                @endif
                                {{ $order->order_notes }}
                          </td>
                          <td>&#2547;{{ $order->subtotal }}</td>
                          <td>
                            @if ($order->status == 1)
                              <span class="badge bg-orange">Processing</span>
                            @elseif ($order->status == 2)
                              <span class="badge bg-yellow">Shipped</span>
                            @elseif ($order->status == 3)
                              <span class="badge bg-green">Delivered</span>
                            @else
                              <span class="badge bg-red">Failed</span>
                            @endif
                          </td>
                          <td style="width: 100px">
                            <div class="btn-group">
                              <a href="#" class="btn btn-info orderStatus" data-status="{{ $order->status }}" data-id="{{ $order->id }}" data-bs-toggle="modal" data-bs-target="#modal-report">
                                <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
                              </a>
                              <a href="{{ route('orders.details', $order->id) }}" class="btn btn-primary"><i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a>
                            </div>
                            
                          </td>
                          {{-- <td style="width: 100px">
                            <a href="{{ route('orders.details', $order->id) }}" class="btn btn-primary"><i class="fa-solid fa-circle-info" style="color: #ffffff;"></i></a>
                          </td> --}}
                        </tr>
                        @endforeach
                      
                    </tbody>
                  </table>
                  {{ $orders->links('pagination::bootstrap-5') }}
            </div>
          </div>    
    </div>
</div>

<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Order Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="POST" id="modalForm">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select class="form-select" name="status" id="orderStatusId">
                    <option value="1" selected>Processing</option>
                    <option value="2">Shipped</option>
                    <option value="3">Delivered</option>
                    <option value="0">Failed</option>
                  </select>
                  @error('status')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <button type="sumbit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                  <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                  <path d="M16 5l3 3"></path>
              </svg>
              Edit
            </button>
          </div>
        </form>
      </div>
    </div>
</div>


  <script>
    $(document).on("click", ".orderStatus", function () {

      var orderId = $(this).data('id');
      var oldStatus = $(this).attr("data-status");

      let link = "{{ route('orders.index') }}/" + orderId + "/update";
      // console.log(link);
      $('#modalForm').attr('action', link);

     $(".modal-body #orderStatusId").val( oldStatus );
    });
  </script>

@endsection