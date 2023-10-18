@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
        <div class="col-md-8 ">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Admin registration form</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Name</label>
                                <div>
                                    <input type="text" class="form-control" name="name" placeholder="Enter name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Email</label>
                                <div>
                                    <input type="email" class="form-control" name="email" placeholder="Enter email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Password</label>
                                <div>
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Enter password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Confirm Password</label>
                                <div>
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password_confirmation" placeholder="Comfirm password">

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Mobile</label>
                                <div>
                                    <input type="text" class="form-control" name="mobile" placeholder="Enter mobile no">
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Status</label>
                                <div>
                                    <select name="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0" selected>Inactive</option>
                                    </select>
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
@endsection
