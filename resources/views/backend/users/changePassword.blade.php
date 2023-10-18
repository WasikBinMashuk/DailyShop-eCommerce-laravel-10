@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
        <div class="col-md-6 ">
            <form action="{{ route('updatePassword') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Change Password</h3>
                    </div>
                    <div class=" card-body  ">
                        <div class="mb-3">
                            <label class="form-label required">Old password</label>
                            <div>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                                    name="old_password" placeholder="Enter old password">
                                @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">New Password</label>
                            <div>
                                <input type="password" id="password"
                                    class="form-control @error('new_password') is-invalid @enderror" name="password"
                                    placeholder="Enter new password">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Confirm Password</label>
                            <div>
                                <input type="password" id="password" class="form-control" name="password_confirmation"
                                    placeholder="Enter password">
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
