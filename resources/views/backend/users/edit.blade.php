@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
        <div class="col-md-8 ">
            <form action="{{ route('users.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header justify-content-center">
                        <h2>Update admin's details</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Name</label>
                                <div>
                                    <input type="text" class="form-control" name="name" placeholder="Enter name"
                                        value="{{ $editUsers->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Email</label>
                                <div>
                                    <input type="email" class="form-control" name="email"
                                        placeholder="Enter email"value="{{ $editUsers->email }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-6 mb-3">
                    <label class="form-label required">Password</label>
                    <div>
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="Enter password">
                        @error('password')
                                <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Confirm Password</label>
                    <div>
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation"  placeholder="Comfirm password">
                        
                    </div>
                </div> --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Mobile</label>
                                <div>
                                    <input type="text" class="form-control" name="mobile" placeholder="Enter mobile no"
                                        value="{{ $editUsers->mobile }}">
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Status</label>
                                <div>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ $editUsers->status == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $editUsers->status == '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $editUsers->id }}">
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
