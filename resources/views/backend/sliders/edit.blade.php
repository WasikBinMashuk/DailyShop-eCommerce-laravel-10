@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
        <div class="col-md-6 ">
            <form action="{{ route('sliders.update', $editSlider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Slider edit form</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Title</label>
                                <div>
                                    <input type="text" class="form-control @error('slider_title') is-invalid @enderror"
                                        name="slider_title" placeholder="Enter slider title"
                                        value="{{ old('slider_title', $editSlider->slider_title) }}">
                                    @error('slider_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Link</label>
                                <div>
                                    <input type="url" class="form-control @error('slider_link') is-invalid @enderror"
                                        name="slider_link" placeholder="Enter slider link"
                                        value="{{ old('slider_link', $editSlider->slider_link) }}">
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
                                        <option value="1"
                                            {{ old('status', $editSlider->status) == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $editSlider->status) == '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3 text-center">
                                <label class="form-label mb-3">Current Image:</label>
                                <div>
                                    <img src="{{ asset('images/sliders/' . $editSlider->slider_image) }}"
                                        style="height: 200px;width:350px;">
                                </div>
                            </div>

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
