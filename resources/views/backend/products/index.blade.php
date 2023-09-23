@extends('backend.master')
@section('content')

<div class="container">
  <div class="row justify-content-center mt-5">
      <div class="col-md-12">
          <div class="card">
              <div class=" card-header justify-content-between ">
                <div class="d-flex">
                  {{-- <div >
                    <h3 class="d-inline card-title">Products</h3>
                  </div> --}}
                  <div class="">
                    <form action="" method="get" autocomplete="off" novalidate>
                      <div class="input-group mb-2">
                        <input type="search" name="search" size="25" class="form-control" placeholder="Search by name or product code" value="{{ $search }}">
                        <button class="btn me-1" type="submit">Go!</button>
                        <a href="{{ url('/products') }}" class="btn">
                          <i class="fa-solid fa-rotate-right" style="color: #000000;"></i>
                        </a>
                      </div>
                      
                    </form>
                  </div>
                </div>
                <div>
                  
                  <div class="d-inline">
                    <a class="btn btn-info" href="{{ route('product.create') }}">Add</a>
                  </div>
                  
                </div>
              </div>
              <div class="card-body">
                <table class="table ">
                    <thead>
                      <tr>
                        {{-- <th scope="col">Category ID</th> --}}
                        <th scope="col">Product Image</th>
                        <th scope="col">Category</th>
                        <th scope="col">Sub Category</th>
                        <th scope="col">Product Code</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">status</th>
                        <th scope="col">Trendy</th>
                        <th scope="col">Actions</th>
                        
                        <th scope="col"></th>
                        {{-- <th scope="col"></th> --}}
                        
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($products as $item)
                          <tr>
                              <td>
                                {{-- {{ $item->product_image }} --}}
                                @if($item->product_image)
                                  <img src="{{ asset('images/'.$item->product_image) }}" style="height: 100px;width:100px;">
                                  @else 
                                  <img src="{{ asset('images/no.jpg') }}" style="height: 100px; width: 100px;">
                                @endif
                              </td>
                              <td>{{ $item->category_name }}</td>
                              <td>{{ $item->sub_category_name }}</td>
                              <td>{{ $item->product_code }}</td>
                              <td>{{ $item->product_name }}</td>
                              <td>&#2547;{{ $item->price }}</td>
                              <td>
                                @if ($item->status == 0)
                                  <span class="badge bg-red">Inactive</span>
                                @else
                                  <span class="badge bg-green">Active</span>
                                @endif  
                              </td>
                              <td>
                                @if ($item->trendy == 1)
                                <span class="badge bg-cyan">Trendy</span>
                                @endif  
                              </td>
                              
                              <td style="width: 100px">
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                  <a href="{{ route('product.edit', $item->id) }}" class="btn btn-primary">
                                    <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
                                  </a>
                                  <a href="{{ route('product.delete', $item->id) }}" class="btn btn-danger" onclick="confirmation(event)">
                                    <i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>
                                  </a>
                                </div>
                              </td>
                          </tr>
                          @endforeach
                    </tbody>
                  </table>
  
                    {{ $products->links('pagination::bootstrap-5') }}
              </div>
          </div>
      </div>
  </div>
</div>

@endsection