@extends('layouts.dash')
@section('dash')

<div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
    <div class="col-md-6 ">
        <form action="{{ route('category.store') }}" method="POST">
          @csrf
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Add Category</h3>
            </div>
            <div class=" card-body  ">
                
                <div class="mb-3">
                    {{-- <label class="form-label ">Category</label> --}}
                    <div>
                        <input type="text" class="form-control @error('new_password') is-invalid @enderror" name="category_name" placeholder="Enter category name">
                        @error('category_name')
                                <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- <div class="mb-3">
                    <label class="form-label required">Confirm Password</label>
                    <div>
                        <input type="password" id="password" class="form-control" name="password_confirmation"  placeholder="Enter password">
                    </div>
                </div> --}}
              
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary">Add</button>
            </div>
          </div>
        </form>
    </div>
</div>

@endsection