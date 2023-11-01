@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
        <div class="col-md-6 ">
            <form action="{{ route('districts.update', $editDistrict->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header justify-content-center">
                        <h2>Edit District</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <label class="form-label required">Select Division</label>
                                <div>
                                    <select name="division_id" class="form-select">
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}"
                                                {{ $editDistrict->division_id == $division->id ? 'selected' : '' }}>
                                                {{ $division->division_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-mb-3">
                                <label class="form-label required">District Name</label>
                                <div>
                                    <input type="text" class="form-control" name="district_name"
                                        placeholder="Enter email"value="{{ $editDistrict->district_name }}">
                                    @error('district_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" name="id" value="{{ $editDistrict->id }}">
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
