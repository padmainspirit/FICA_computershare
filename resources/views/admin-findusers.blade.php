@extends('layouts.master-findusers')

{{-- @section('title')
@lang('translation.Form_Wizard')
@endsection --}}


@section('css')
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .hide,
        #testresult-btn,
        #idnumberResult {
            display: none;

        }

        .show {
            display: block;
        }

        table.mystyles {
            padding: 20px;
        }

        table.mystyles td {
            padding: 20px;
            text-align: center;
        }

        .show {
            display: block;
        }

        table.mystyles {
            padding: 20px;
        }

        table.mystyles td {
            padding: 20px;
            text-align: center;
        }

        .heading-fica-id {
            height: 10%;
            background-image: linear-gradient(#0e425b, #056895);
        }
    </style>
@endsection


@section('content')
    {{-- @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Fica Progress
        @endslot
    @endcomponent --}}

    <div class="main-content" style="margin-left: 0px;">
        <div class="page-content" style="padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
            <div class="row" id="card1" style="margin-left: 0px;margin-right: 0px;">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body" style="padding-bottom: 0px;padding-top: 0px;">

                            {{-- <h4 class="card-title mb-2 d-flex justify-content-left" style="font-size: 18px">
                                Client Search
                            </h4>

                            <hr style="color: #1a4f6e ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #1a4f6e; background-color: #1a4f6e; opacity: 100%;"> --}}

                            <div class="heading-fica-id mb-4">
                                <div class="text-center">
                                    <h4 class="font-size-18"
                                        style="color: #fff; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                        Client Search
                                    </h4>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('display-admin-findusers') }}" id="searchclient">

                                <div id="errordisplay">
                                    @if (Session::has('exception'))
                                        <div class="alert alert-danger">
                                            Failed - Reason: User(s) Not Found
                                        </div>
                                        {{-- <p class="alert {{ Session::get('alert-class', 'alert-info') }}"></p> --}}
                                    @endif
                                </div>

                                {{-- @error('exception')
                                <div class="alert alert-danger">
                                   
                                    {{ $exception }}
                                    
                                </div>
                                @enderror --}}

                                {{-- <span class="text-danger">
                                    @error('SURNAME')
                                        {{ $SURNAME }}
                                    @enderror
                                </span>
                                <span class="text-danger">
                                    @error('FIRSTNAME')
                                        {{ $FIRSTNAME }}
                                    @enderror
                                </span>
                                <span class="text-danger">
                                    @error('CONTACTNO')
                                        {{ $CONTACTNO }}
                                    @enderror
                                </span>
                                <span class="text-danger">
                                    @error('CLIENTREF')
                                        {{ $CLIENTREF }}
                                    @enderror
                                </span> --}}
                                @csrf

                                <div class="col-lg-12">
                                    <div class="row">

                                        {{-- <p style="color: #000000;">{{ $exception }}</p> --}}

                                        <div class="col-md-2">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">ID Number:</label>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <input autocomplete="off" type="text" class="form-control input-sm"
                                                    style="height: 27px; width: 10px; padding-left: 24px; width: 225px; text-transform: uppercase;"
                                                    id="IDNumber" name="IDNumber" placeholder="Enter ID Number"
                                                    value="">

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">FICA Status:</label>

                                            </div>
                                        </div>

                                        <div class="col-md-4 ">
                                            <div class="mb-3">
                                                <div class="input-group" style="height: 27px; width: 225px;">

                                                    <div class="input-group" style="height: 27px; width: 225px;">
                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px;"
                                                            id="FICAStatus" name="FICAStatus">
                                                            <option selected style="font-size: 12px;" disabled>
                                                                Select
                                                            </option>

                                                            <option value="Completed" style="font-size: 12px;">
                                                                Completed
                                                            </option>

                                                            <option value="Failed" style="font-size: 12px;">
                                                                Failed
                                                            </option>

                                                            <option value="In Progress" style="font-size: 12px;">
                                                                In Progress
                                                            </option>

                                                            <option value="Correction" style="font-size: 12px;">
                                                                Correction
                                                            </option>

                                                            <option value="Rejected" style="font-size: 12px;">
                                                                Rejected
                                                            </option>

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">Last Name:</label>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <input autocomplete="off" type="text" class="form-control input-sm"
                                                    style="height: 27px; width: 10px; padding-left: 24px; width: 225px; text-transform: uppercase;"
                                                    id="LastName" name="LastName" placeholder="Enter Last Name"
                                                    value="">

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">First Name:</label>

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <div class="input-group" style="height: 27px; width: 225px;">

                                                    <input autocomplete="off" type="text" class="form-control"
                                                        style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;"
                                                        id="FirstName" name="FirstName" placeholder="Enter First Name"
                                                        value="">

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">Cell Phone No.:</label>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">

                                                <input autocomplete="off" type="text" class="form-control input-sm"
                                                    style="height: 27px; width: 10px; padding-left: 24px; width: 225px; text-transform: uppercase;"
                                                    id="PhoneNumber" name="PhoneNumber"
                                                    placeholder="Enter Contact Number" value="">

                                            </div>
                                        </div>

                                        {{-- <div class="col-md-2">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">Client Refernce
                                                    Number:</label>

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <div class="input-group" style="height: 27px; width: 225px;">

                                                    <input autocomplete="off" type="text" class="form-control"
                                                        style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;s"
                                                        id="ClientUniqueRef" name="ClientUniqueRef"
                                                        placeholder="Enter Client Refernce No." value="">

                                                </div>
                                            </div>
                                        </div> --}}

                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-sm-6 col-form-label">FICA Status</label>
                                            <select class="form-select" autocomplete="off" id="FICAStatus"
                                                name="FICAStatus">
                                                <option value="" selected disabled>Select Type</option>
                                                <option value="In progress">In Progress</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Failed">Failed</option>
                                                <option value="Rejected">Rejected</option>
                                            </select>
                                        </div>
                                </div> --}}

                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <button type="submit" id="submit"
                                                style="background-color: #1a4f6e; border-color: #1a4f6e"
                                                class="btn btn-primary w-lg waves-effect waves-light">Search</button>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <button type="button" id="clearall" name="clearall"
                                                style="background-color: #1a4f6e; border-color: #1a4f6e"
                                                class="btn btn-danger w-lg waves-effect waves-light">Clear</button>
                                        </div>
                                    </div>

                                </div>

                            </form>

                            <form method="POST" action='{{ route('testresult') }}' id="idForm">
                                @csrf
                                <input type="type" id="idnumberResult" name="idnumberResult">
                                <button type="submit" id="testresult-btn"></button>
                            </form>

                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

            </div>

            <div class="row" id="card2" style="display: none;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- <div class="col-sm-9 col-md-3" style="text-align: right;">
                                <div class="dataTables_filter mb-3"><input id="search" type="search" id="datatable_filter"
                                        class="form-control form-control-sm" placeholder="Search..." value=""
                                        aria-controls="datatable">
                                </div>
                                <button type="button" class="btn btn-secondary" id="submit">Submit</button>
                                <button type="button" class="btn btn-outline-danger" id="clear">Clear</button>
                            </div> --}}

                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">IDNumber</th>
                                            <th class="align-middle">Last Name</th>
                                            <th class="align-middle">First Name</th>
                                            <th class="align-middle">Last Updated</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tablebody">
                                        <form method="POST" action="{{ route('display-admin-findusers') }}" id="returnid">
                                            <tr>
                                                {{-- <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                        data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                                        View Details
                                                    </button>
                                                </td>

                                                @foreach ($output_data as $clientDetails)
                                                    <tr>
                                                        <td>{{ $clientDetails->IDNUMBER }}</td>
                                                        <td>{{ $clientDetails->LastName }}</td>
                                                        <td>{{ $clientDetails->FirstName }}</td>
                                                        <td>{{ $clientDetails->PhoneNumber }}</td>
                                                        <td>{{ $clientDetails->ClientUniqueRef }}</td>
                                                        <td>{{ $clientDetails->LastUpdatedDate }}</td>
                                                    </tr>
                                                @endforeach --}}
                                            </tr>
                                        </form>
                                    </tbody>
                                </table>
                            </div>

                            {{-- <div class="table-responsive">
                                <table id="datatable" class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">IDNumber</th>
                                            <th class="align-middle">Last Name</th>
                                            <th class="align-middle">First Name</th>
                                            <th class="align-middle">Last Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablebody">
                                        <form method="POST" action="{{ route('display-admin-findusers') }}"
                                            id="returnid">

                                            <tr>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                        data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                                        View Details
                                                    </button>
                                                </td>

                                                @foreach ($output_data as $clientDetails)
                                                    <tr>
                                                        <td>{{ $clientDetails->IDNUMBER }}</td>
                                                        <td>{{ $clientDetails->LastName }}</td>
                                                        <td>{{ $clientDetails->FirstName }}</td>
                                                        <td>{{ $clientDetails->PhoneNumber }}</td>
                                                        <td>{{ $clientDetails->ClientUniqueRef }}</td>
                                                        <td>{{ $clientDetails->LastUpdatedDate }}</td>
                                                    </tr>
                                                @endforeach

                                            </tr>
                                        </form>
                                    </tbody>
                                </table>
                            </div> --}}

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
    </div>
@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    <script>
        function clearAll() {
            document.getElementById("IDNumber").value = '';
            document.getElementById("FirstName").value = '';
            document.getElementById("LastName").value = '';
            document.getElementById("PhoneNumber").value = '';
            document.getElementById("FICAStatus").value = '';
            // document.getElementById("ClientUniqueRef").value = '';

        }

        var btn = document.getElementById("clearall");

        btn.addEventListener("click", clearAll);
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $('#searchclient').on('submit', function(e) {
                //  var verified = '<?php $IDN; ?>';
                e.preventDefault();
                var form_data = new FormData(this);
                //var form_data = $('#fileUpload').serialize();

                $.ajax({
                    url: '{{ route('display-admin-findusers') }}',
                    method: 'POST',
                    data: form_data,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        //document.querySelector("#loader").style.visibility = "visible";
                    },
                    complete: function() {
                        // document.querySelector("#loader").style.display = "none";
                    },
                    success: function(output_data) {
                        //  foreach(response.status as value){
                        //    alert(value);
                        //}

                        document.getElementById('card1').style.display = 'none';
                        document.getElementById('card2').style.display = 'block';

                        // console.log(output_data.searchResponse);

                        /*$(document.createElement('button')).prop({
                            type: 'button',
                            innerHTML: 'Press me',
                            class: 'btn-styled',
                            click: function () { alert('hi'); }
                        })*/

                        // WORKING DISPLAY /**/

                        var newRows = "";
                        // console.log(output_data.data);

                        for (let i = 0; i < output_data.data.length; i++) {
                            // console.log(output_data.data[i]);

                            let idNumber = 'idnumber' + i;
                            console.log(idNumber);

                            newRows +=
                                "<tbody>" + "<tr><td>" +
                                /* $('<button>Test</button>').click(function () { alert('hi'); }) +*/
                                '<button class="idnumber" id=' + '"' + idNumber + '"' +
                                'style="background: none!important;border: none;padding: 0!important;font-family: arial, sans-serif;color: #0000FF;font-weight: 600;text-decoration: underline;cursor: pointer;">' +
                                output_data.data[i].IDNUMBER + '</button>' + "</td><td>" +
                                /*'<a id="idnumberpass" name="idnumbs" type="submit" href="{{ url('/admin-dashboard') }}">' +
                                output_data.data[i].IDNUMBER + "</a></td><td>" +*/
                                output_data.data[i].Surname + "</td><td>" +
                                output_data.data[i].FirstName + "</td><td>" +
                                // output_data.data[i].ClientUniqueRef + "</td><td>" +
                                output_data.data[i].LastUpdatedDate + "</td></tr>" +
                                "</tbody>&nbsp;&nbsp;&nbsp;";
                            // console.log(idNumber);


                            // IdGeneretor(idNumber);
                        }
                        $("#tablebody").after(newRows);
                        
                        $('button.idnumber').on('click', function(value) {
                            var readIdNumber = this.id;
                            var IdButton = $('#' + readIdNumber).text();
                            
                            // console.log(IdButton)
                            $("#idnumberResult").val(IdButton)
                            $("#testresult-btn").click();
                        });
                    },
                });
            });
        });
    </script>

    <script>
        var table = document.getElementById("datatable");
        document.getElementById('submit').onclick = function() {
            if (table.styl.display == "none") {
                table.style.display = "block";
            } else {
                table.style.display = "none";
            }
        };
    </script>

    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#errordisplay").load(location.href + " #errordisplay");
            }, 1600);
        });
    </script>
@endsection
