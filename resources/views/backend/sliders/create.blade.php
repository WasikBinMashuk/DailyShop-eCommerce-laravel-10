@extends('backend.master')
@section('content')

<div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
    <div class="col-md-6 ">
        <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Slider Input form</h3>
            </div>
            <div class="card-body">
              <div class="row">
                  <div class="col-md-6 mb-3">
                      <label class="form-label required">Title</label>
                      <div>
                          <input type="text" class="form-control @error('slider_title') is-invalid @enderror" name="slider_title"  placeholder="Enter slider title" value="{{ old('slider_title') }}">
                          @error('slider_title')
                                  <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
                  <div class="col-md-6 mb-3">
                      <label class="form-label required">Link</label>
                      <div>
                          <input type="url" class="form-control @error('slider_link') is-invalid @enderror" name="slider_link"  placeholder="Enter slider link" value="{{ old('slider_link') }}">
                          @error('slider_link')
                                  <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label required">Upload Image</label>
                    <div>
                        <input type="file" class="form-control" name="slider_image">
                        <small class="form-hint">
                          Minimum dimentions: 1920 x 1080 <br> Max: 2MB
                        </small>
                        @error('slider_image')
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
                  
              </div>
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-primary">ADD</button>
            </div>
          </div>
        </form>
    </div>
</div>


@endsection