@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
        <div class="col-md-6 ">
            <form action="{{ route('thanas.update', $editThana->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Thana </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Select Division</label>
                                <div>
                                    <select name="division_id" class="form-select" id="divisions">
                                        <option value="">Select Division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}"
                                                {{ $editThana->division_id == $division->id ? 'selected' : '' }}>
                                                {{ $division->division_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('division_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Select District</label>
                                <div>
                                    <select name="district_id" class="form-select" id="districts">
                                        {{-- <option value="">Select Subcategory</option> --}}
                                        {{-- <option value="{{ $subCategories->id }}" {{ $editProduct->sub_category_id == $subCategories->id ? 'selected' : '' }}>{{ $subCategories->sub_category_name }}</option> --}}
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $editThana->district_id == $district->id ? 'selected' : '' }}>
                                                {{ $district->district_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Thana Name</label>
                                <div>
                                    <input type="text" class="form-control @error('thana_name') is-invalid @enderror"
                                        name="thana_name" placeholder="Enter Product Code"
                                        value="{{ old('thana_name', $editThana->thana_name) }}">
                                    @error('thana_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- Dependent dropdown jquery --}}
    <script>
        jQuery(document).ready(function() {
            jQuery('#divisions').change(function() {
                let cid = jQuery(this).val();
                jQuery.ajax({
                    url: '/getDistricts',
                    type: 'post',
                    data: 'cid=' + cid + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        jQuery('#districts').html(result)
                    }
                });
            });
        });
    </script>
@endsection
