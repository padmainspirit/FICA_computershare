@extends('layouts.master-display')

@section('title')
    @lang('translation.User_List')
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>ID Number</th>
                                <th>Email</th>
                                {{-- <th>Password</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($CustomerSearchID as $item)
                                <tr>
                                    <td>{{ $item->FirstName }}</td>
                                    <td>{{ $item->LastName }}</td>
                                    <td>{{ $item->IDNumber }}</td>
                                    <td>{{ $item->Email }}</td>
                                    {{-- <td>{{ $item->Password }}</td> --}}
                                    <td>
                                        {{-- <form method="GET" action="{{ route('users.edit', $item->Id) }}"> --}}
                                        {{-- @csrf --}}
                                        {{-- <button href="{{ route('users.edit', $item->Id) }}" type="submit"
                                            class="btn btn-primary w-md text-decoration-underline"
                                            style="color: #ffffff;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;">
                                            Edit
                                        </button> --}}
                                        <a class="btn btn-primary" href="{{ route('users.edit', $item->Id) }}">Edit</a>

                                        <input id="SelectUser" name="SelectUser" value="{{ $item->Id }}"
                                            style="display: none;">
                                        {{-- </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
