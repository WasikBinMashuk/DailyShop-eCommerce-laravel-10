@extends('backend.master')
@section('content')

<div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
    <div class="col-md-6 ">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Product Input form</h3>
            </div>
            <div class="card-body">
              <div class="row">
                  
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Select Category</label>
                  <div>
                    <select name="category_id" class="form-select" id="category">
                      <option value="">Select Category</option>
                      @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                      @endforeach
                    </select>
                    @error('category_id')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Select Subcategory</label>
                  <div>
                    <select name="sub_category_id" class="form-select" id="sub_category">
                      <option value="">Select Subcategory</option>
                      {{-- @foreach($subCategories as $subcategory)
                        <option value="{{ $subcategory->id }}" {{ old('sub_category_id') == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->sub_category_name }}</option>
                      @endforeach --}}
                    </select>
                    @error('sub_category_id')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                  <div class="col-md-6 mb-3">
                      <label class="form-label required">Product Code</label>
                      <div>
                          <input type="text" class="form-control @error('product_code') is-invalid @enderror" name="product_code"  placeholder="Enter Product Code" value="{{ old('product_code') }}">
                          @error('product_code')
                                  <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label class="form-label required">Product Name</label>
                      <div>
                          <input type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name"  placeholder="Enter Product Name" value="{{ old('product_name') }}">
                          @error('product_name')
                                  <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label class="form-label required">Price</label>
                      <div>
                          <input type="text" class="form-control @error('price') is-invalid @enderror" name="price"  placeholder="Enter Price" value="{{ old('price') }}">
                          @error('price')
                                  <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label class="form-label required">Status</label>
                    <div>
                      <select name="status" class="form-select">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                      </select>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Description</label>
                      <textarea id="tinymce-mytextarea" name="description" placeholder="Write a decsription for the product..."> {{ old('description') }} </textarea>
                  </div>
                  <div class="col-md-12 mb-3">
                      <label class="form-label">Product Image</label>
                      <div>
                          <input type="file" class="form-control" name="product_image">
                          @error('product_image')
                                  <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
              </div>
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
          </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  jQuery(document).ready(function(){
    jQuery('#category').change(function(){
      let cid=jQuery(this).val();
      jQuery.ajax({
        url:'/getSubCategory',
        type:'post',
        data:'cid='+cid+'&_token={{csrf_token()}}',
        success:function(result){
          jQuery('#sub_category').html(result)
        }
      });
    });
  });
</script>

@endsection