@extends('layouts.dash')
@section('dash')

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
                    <form action="./" method="get" autocomplete="off" novalidate>
                      <div class="input-icon">
                        <span class="input-icon-addon">
                          <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                        </span>
                        <input type="text" value="" class="form-control" placeholder="Search products by name" aria-label="Search in website">
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
                              <td>{{ $item->price }}</td>
                              <td>
                                @if ($item->status == 0)
                                  <span class="badge bg-red">Inactive</span>
                                @else
                                  <span class="badge bg-green">Active</span>
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

      {{-- <div class="col-md-4">
          <div class="card">
              <div class="card-header text-center pt-4">
                  <h4>Select Category</h4>
                  
              </div>

              <div class="card-body">
                  
                  <form action="{{ route('category.index') }}" method="POST">
                      @csrf
                      <div class="mb-3">
                        <label class="form-label">Select Category</label>
                        <div>
                          <select name="category_id" class="form-select">
                            @foreach($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      

                        <div class="d-grid mb-2">
                          <input type="submit" class="btn btn-primary" value="SHOW">
                        </div>
                  </form>
                  
              </div>
          </div>
      </div> --}}
  </div>
</div>

@endsection