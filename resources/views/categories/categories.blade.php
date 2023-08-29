@extends('layouts.dash')
@section('dash')

<div class="container">
  <div class="row justify-content-center mt-5">
      <div class="col-md-8">
          <div class="card">
              <div class=" card-header justify-content-center text-center">
                <h3 class="card-title">Sub Category</h3>
              </div>
              <div class="card-body">
                <table class="table ">
                    <thead>
                      <tr>
                        {{-- <th scope="col">Category ID</th> --}}
                        <th scope="col">Category Name</th>
                        <th scope="col">Sub Category Name</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($subCategories as $item)
                          <tr>
                              <td>{{ $item->category_name }}</td>
                              <td>{{ $item->sub_category_name }}</td>
                              <td style="width: 100px">
                                <a href="{{ route('category.edit', $item->id) }}" class="btn btn-primary">
                                  <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
                                </a>
                              </td>
                              <td style="width: 100px">
                                <a href="" class="btn btn-danger" onclick="confirmation(event)">
                                  <i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>
                                </a>
                                {{-- onclick="confirmation(event)"" --}}
                              </td>
                          </tr>
                          @endforeach
                    </tbody>
                  </table>
  
                    {{-- {{ $phonebooks->links('pagination::bootstrap-5') }} --}}
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