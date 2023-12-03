@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5 mx-5">
        <div class="row">
            <div class="col-md-7 ">
                <div class="row">
                    {{-- Role/Permission --}}
                    <div class="card">
                        <form action="{{ route('roles.permission.store') }}" method="POST">
                            @csrf
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
                                                <option value="" selected disabled>Select something</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="col-3 col-form-label pt-0">Permissions</label>
                                        <div class="col" id="permissions">
                                            {{-- @foreach ($permissions as $permission)
                                                <label class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permission_id[]"
                                                        value="{{ $permission->id }}" />
                                                    <span class="form-check-label">{{ $permission->name }}</span>
                                                </label>
                                            @endforeach --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                    {{-- Asign Roles To User --}}
                    <div class="card mt-5">
                        <form action="{{ route('user.role.store') }}" method="POST">
                            @csrf
                            <div class=" card-header justify-content-between ">
                                <div>
                                    <h3 class="card-title">Asign Roles To User</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Users</label>
                                        <div>
                                            <select name="user_id" class="form-select" id="user">
                                                <option value="" selected disabled>Select User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="col-3 col-form-label pt-0">Roles</label>
                                        <div class="col" id="roles">
                                            {{-- @foreach ($permissions as $permission)
                                                <label class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permission_id[]"
                                                        value="{{ $permission->id }}" />
                                                    <span class="form-check-label">{{ $permission->name }}</span>
                                                </label>
                                            @endforeach --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                    {{-- Asign Permissions to User --}}
                    <div class="card mt-5">
                        <form action="{{ route('user.permissions.store') }}" method="POST">
                            @csrf
                            <div class=" card-header justify-content-between ">
                                <div>
                                    <h3 class="card-title">Asign Permissions To User</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Users</label>
                                        <div>
                                            <select name="user_id" class="form-select" id="user-permission">
                                                <option value="" selected disabled>Select User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="col-3 col-form-label pt-0">Permissions</label>
                                        <div class="col" id="userHasPermissions">
                                            {{-- @foreach ($permissions as $permission)
                                                <label class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permission_id[]"
                                                        value="{{ $permission->id }}" />
                                                    <span class="form-check-label">{{ $permission->name }}</span>
                                                </label>
                                            @endforeach --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5 ">
                <div class="row">
                    {{-- Add roles --}}
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
                                                <input type="text" class="form-control" name="roleName"
                                                    placeholder="Enter Role Name">
                                                @error('roleName')
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
                    {{-- Add permissions --}}
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
                                                <input type="text" class="form-control" name="permissionName"
                                                    placeholder="Enter Permission Name">
                                                @error('permissionName')
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

    {{-- Dependent checkbox Role vs Permissions --}}
    <script>
        jQuery(document).ready(function() {
            jQuery('#role').change(function() {
                let cid = jQuery(this).val();
                // alert(cid);
                jQuery.ajax({
                    url: '/getPermissions',
                    type: 'post',
                    data: 'cid=' + cid + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        jQuery('#permissions').html(result)
                    }
                });
            });
        });
    </script>

    {{-- Dependent checkbox User vs Roles --}}
    <script>
        jQuery(document).ready(function() {
            jQuery('#user').change(function() {
                let cid = jQuery(this).val();
                // alert(cid);
                jQuery.ajax({
                    url: '/getUserRole',
                    type: 'post',
                    data: 'cid=' + cid + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        jQuery('#roles').html(result)
                    }
                });
            });
        });
    </script>

    {{-- Dependent checkbox User vs Permissions --}}
    <script>
        jQuery(document).ready(function() {
            jQuery('#user-permission').change(function() {
                let cid = jQuery(this).val();
                // alert(cid);
                jQuery.ajax({
                    url: '/getUserPermission',
                    type: 'post',
                    data: 'cid=' + cid + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        jQuery('#userHasPermissions').html(result)
                    }
                });
            });
        });
    </script>
@endsection
