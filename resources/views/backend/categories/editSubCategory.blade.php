@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
        <div class="col-md-8 ">
            <form action="{{ route('subcategory.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header justify-content-center">
                        <h2>Update Categories</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Select Category</label>
                                <div>
                                    <select name="category_id" class="form-select">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $editCategory->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Sub Category Name</label>
                                <div>
                                    <input type="text" class="form-control" name="sub_category_name"
                                        placeholder="Enter email" value="{{ $editCategory->sub_category_name }}">
                                    @error('sub_category_name')
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
