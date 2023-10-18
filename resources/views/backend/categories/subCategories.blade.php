@extends('backend.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class=" card-header justify-content-between ">
                        <div>
                            <h3 class="card-title">Subcategories</h3>
                        </div>
                        <div>

                            <div class="d-inline">
                                <a class="btn btn-info" href="{{ route('subcategory.create') }}">Add</a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table ">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">Category ID</th> --}}
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Subcategory Name</th>
                                    <th scope="col"></th>
                                    {{-- <th scope="col"></th> --}}

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subCategories as $item)
                                    <tr>
                                        <td>{{ $item->category->category_name }}</td>
                                        <td>{{ $item->sub_category_name }}</td>
                                        {{-- <td style="width: 100px">
                                <a href="{{ route('subcategory.edit', $item->id) }}" class="btn btn-primary">
                                  <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
                                </a>
                              </td>
                              <td style="width: 100px">
                                <a href="{{ route('subcategory.delete', $item->id)}}" class="btn btn-danger" onclick="confirmation(event)">
                                  <i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>
                                </a>
                              </td> --}}
                                        <td style="width: 100px">
                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                <a href="{{ route('subcategory.edit', $item->id) }}"
                                                    class="btn btn-primary">
                                                    <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
                                                </a>
                                                <a href="{{ route('subcategory.delete', $item->id) }}"
                                                    class="btn btn-danger" onclick="confirmation(event)">
                                                    <i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $subCategories->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
