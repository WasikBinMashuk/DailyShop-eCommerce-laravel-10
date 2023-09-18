@extends('backend.master')
@section('content')

<div class="container">
  <div class="row justify-content-center mt-5">
      <div class="col-md-12">
          <div class="card">
              <div class=" card-header justify-content-between ">
                <div class="d-flex">
                  <div >
                    <h3 class="d-inline card-title">Sliders</h3>
                  </div>
                  
                </div>
                <div>
                  
                  <div class="d-inline">
                    <a class="btn btn-info" href="{{ route('sliders.create') }}">Add</a>
                  </div>
                  
                </div>
              </div>
              <div class="card-body">
                <table class="table align-middle">
                    <thead>
                      <tr>
                        {{-- <th scope="col">Category ID</th> --}}
                        <th scope="col">Slider Image</th>
                        <th scope="col" style="width: 100px;">Title</th>
                        <th scope="col">Link</th>
                        <th scope="col">status</th>
                        <th scope="col">Actions</th>
                        
                        <th scope="col"></th>
                        {{-- <th scope="col"></th> --}}
                        
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($sliders as $item)
                          <tr>
                              <td>
                                {{-- {{ $item->product_image }} --}}
                                  <img src="{{ asset('images/sliders/'.$item->slider_image) }}" style="height: 100px;width:180px;">
                              </td>
                              <td>{{ $item->slider_title }}</td>
                              <td><a href="{{ $item->slider_link }}">{{ $item->slider_link }}</a></td>
                              <td>
                                @if ($item->status == 0)
                                  <span class="badge bg-red">Inactive</span>
                                @else
                                  <span class="badge bg-green">Active</span>
                                @endif  
                              </td>

                              <td style="width: 100px">
                                <a href="{{ route('sliders.edit', $item->id) }}" class="btn btn-primary">
                                  <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
                                </a>
                              </td>
                              
                              <td style="width: 100px">
                                <form action="{{ route('sliders.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete this user?')">
                                        <i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>
                                    </button>
                                </form>
                                {{-- onclick="confirmation(event)"" --}}
                              </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
  
                    {{ $sliders->links('pagination::bootstrap-5') }}
              </div>
          </div>
      </div>
  </div>
</div>

@endsection