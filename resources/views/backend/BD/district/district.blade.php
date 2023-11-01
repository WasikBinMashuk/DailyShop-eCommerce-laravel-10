@extends('backend.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class=" card-header justify-content-between ">
                        <div>
                            <h3 class="card-title">Districts</h3>
                        </div>
                        <div>

                            <div class="d-inline">
                                <a class="btn btn-info" href="{{ route('districts.create') }}">Add</a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table ">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">Category ID</th> --}}
                                    <th scope="col">Division Name</th>
                                    <th scope="col">District Name</th>
                                    <th scope="col"></th>
                                    {{-- <th scope="col"></th> --}}

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($districts as $item)
                                    <tr>
                                        <td>{{ $item->division->division_name }}</td>
                                        <td>{{ $item->district_name }}</td>

                                        <td style="width: 100px">
                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                <a href="{{ route('districts.edit', $item->id) }}" class="btn btn-primary">
                                                    <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
                                                </a>
                                                <form action="{{ route('districts.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Are you sure to delete this user?')">
                                                        <i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $districts->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection