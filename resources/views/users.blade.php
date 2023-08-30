@extends('layouts.dash')
@section('dash')


<div class="page-wrapper mt-5" style="display: flex; justify-content: center; flex-direction:row">
    <div class="col-md-8 ">
        <div class="card" >
          <div class=" card-header justify-content-between ">
            <div>
              <h3 class="card-title">Users Table</h3>
            </div>
            <div>
              <div class="d-inline">
                <a class="btn btn-info" href="">Add User</a>
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

                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $user)
                      <tr>
                        <th>{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>
                          @if ($user->status == 0)
                              <span class="badge bg-red">Inactive</span>
                          @else
                            <span class="badge bg-green">Active</span>
                          @endif
                        </td>
                        <td style="width: 100px">
                          <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
                          </a>
                        </td>
                        <td style="width: 100px">
                          <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger" onclick="confirmation(event)">
                            <i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>
                          </a>
                          {{-- onclick="confirmation(event)"" --}}
                        </td>
                      </tr>
                      @endforeach
                      
                    </tbody>
                  </table>
                  {{ $users->links('pagination::bootstrap-5') }}
            </div>
          </div>    
    </div>
</div>

  

@endsection