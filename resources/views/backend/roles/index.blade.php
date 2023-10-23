@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5 mx-5">
        <div class="row">
            <div class="col-md-7 ">
                <form action="{{ route('roles.permission.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class=" card-header justify-content-between ">
                            <div>
                                <h3 class="card-title">Role/Permission</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label required">Roles</label>
                                    <div>
                                        <select name="role_id" class="form-select" id="role">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="col-3 col-form-label pt-0">Permissions</label>
                                    <div class="col" id="permissions">
                                        @foreach ($permissions as $permission)
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permission_id[]"
                                                    value="{{ $permission->id }}" />
                                                <span class="form-check-label">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5 ">
                <div class="row">
                    <div class="col-md-12 ">
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Add Roles</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required">Role Name</label>
                                            <div>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Enter name">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 mt-5">
                        <form action="{{ route('permission.store') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Add Permissions</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required">Permission Name</label>
                                            <div>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Enter name">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Dependent checkbox jquery --}}
    {{-- <script>
        jQuery(document).ready(function() {
            jQuery('#role').change(function() {
                let cid = jQuery(this).val();
                // alert(cid);
                jQuery.ajax({
                    url: '/getRole',
                    type: 'post',
                    data: 'cid=' + cid + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        jQuery('#permissions').html(result)
                    }
                });
            });
        });
    </script> --}}
@endsection
