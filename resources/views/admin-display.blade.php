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
                                {{-- <th>Customer ID</th> --}}
                                <th>Trading Name</th>
                                <th>Registration Name</th>
                                <th>Registration Number</th>
                                <th>VAT Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($GetAllCustomers as $item)
                                <tr>
                                    {{-- <td>{{ $item->Id }}</td> --}}
                                    <td>{{ $item->TradingName }}</td>
                                    <td>{{ $item->RegistrationName }}</td>
                                    <td>{{ $item->RegistrationNumber }}</td>
                                    <td>{{ $item->VATNumber }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin-client') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary w-md text-decoration-underline"
                                                style="color: #ffffff;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;">
                                                View Users
                                            </button>
                                            <button type="submit" class="btn btn-primary w-md text-decoration-underline"
                                                style="color: #ffffff;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;padding-right: 0px;">
                                                Edit
                                            </button>

                                            <input id="SelectClient" name="SelectClient" value="{{ $item->Id }}"
                                                style="display: none;">
                                        </form>
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
