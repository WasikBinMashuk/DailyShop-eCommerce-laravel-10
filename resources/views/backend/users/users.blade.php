@extends('backend.master')
@section('content')
    <div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
        <div class="col-md-8 ">
            <div class="card">
                <div class=" card-header justify-content-between ">
                    <div>
                        <h3 class="card-title">Registered Admins</h3>
                    </div>
                    <div>
                        <div class="d-inline">
                            <a class="btn btn-info" href="{{ route('users.create') }}">Add Admin</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- @if (session('msg'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>{{ Session::get('msg') }}</strong>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                @endif
                @if (session('danger'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>{{ Session::get('danger') }}</strong>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                @endif --}}

                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ URL::to('/users') }}"
                },
                columns: [

                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'roles',
                        name: 'roles'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },

                ]
            });
        });
    </script>
@endsection
