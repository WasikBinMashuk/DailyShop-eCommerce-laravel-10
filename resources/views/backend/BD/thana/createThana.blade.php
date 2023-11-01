@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
        <div class="col-md-6 ">
            <form action="{{ route('thanas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add Thana</h3>
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
                                                {{ old('division_id') == $division->id ? 'selected' : '' }}>
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
                                        <option value="">Select District</option>
                                        {{-- @foreach ($subCategories as $subcategory)
                        <option value="{{ $subcategory->id }}" {{ old('sub_category_id') == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->sub_category_name }}</option>
                      @endforeach --}}
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
                                        name="thana_name" placeholder="Enter Thana Name" value="{{ old('thana_name') }}">
                                    @error('thana_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
