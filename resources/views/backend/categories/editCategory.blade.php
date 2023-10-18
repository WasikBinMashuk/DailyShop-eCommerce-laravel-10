@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
        <div class="col-md-6 ">
            <form action="{{ route('category.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header justify-content-center">
                        <h2>Update Categories</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col mb-3">
                                <label class="form-label required">Category Name</label>
                                <div>
                                    <input type="text" class="form-control" name="category_name"
                                        placeholder="Enter email"value="{{ $editCategory->category_name }}">
                                    @error('category_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" name="id" value="{{ $editCategory->id }}">
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
