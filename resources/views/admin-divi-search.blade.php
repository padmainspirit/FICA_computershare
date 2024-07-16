@extends('layouts.master-dashboard')

@section('title')
{{-- @lang('translation.User_List') --}}
@endsection

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
            background-image: linear-gradient(#93186c, #93186c);
        }
    </style>
@endsection

@section('content')

<body>
    <div class="main-content" style="margin-left: 0px;">
        <div class="page-content" style="padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
            <div class="row" id="card1" style="margin-left: 0px;margin-right: 0px;">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body" style="padding-bottom: 0px;padding-top: 0px;">

                            <div class="heading-fica-id mb-4">
                                <div class="text-center">
                                    <h4 class="font-size-18"
                                        style="color: #fff; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                        Client Search
                                    </h4>
                                </div>
                            </div>

                            <form method="POST" action="" id="searchclient">

                                @csrf

                                <div class="col-lg-12">
                                    <div class="row">

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
                                                    style="font-size: 12px; color: rgb(0, 0, 0)">Action:</label>

                                            </div>
                                        </div>

                                        <div class="col-md-4 ">
                                            <div class="mb-3">
                                                <div class="input-group" style="height: 27px; width: 225px;">

                                                    <div class="input-group" style="height: 27px; width: 225px;">
                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px;"
                                                            id="FICAStatus" name="FICAStatus">
                                                            <option value="" style="font-size: 12px;">
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

                                        <div class="col-md-2">
                                            <div class="mb-3">

                                                <label for="basicpill-vatno-input" class="font-weight-bold" style="font-size: 12px; color: rgb(0, 0, 0)">Company:</label>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <div class="input-group" style="height: 27px; width: 225px;">

                                                    <div class="input-group" style="height: 27px; width: 225px;">
                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px;padding-left: 24px;padding-bottom: 2px;padding-top: 2px;"
                                                            id="FICARiskStatus" name="FICARiskStatus">
                                                            <option value="" selected style="font-size: 12px;" >
                                                                Select
                                                            </option>

                                                            <option value="LOW" style="font-size: 12px;">
                                                                LOW
                                                            </option>

                                                            <option value="MEDIUM" style="font-size: 12px;">
                                                                MEDIUM
                                                            </option>

                                                            <option value="HIGH" style="font-size: 12px;">
                                                                HIGH
                                                            </option>

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <span class="text-danger" id="error_msg" styel="display:none"></span><br/>
                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <button type="submit" id="submit"
                                                style="background-color: #93186c; border-color: #93186c"
                                                class="btn btn-primary w-lg waves-effect waves-light">Search</button>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <button type="button" id="clearall" name="clearall"
                                                style="background-color: #93186c; border-color: #93186c"
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

                            <br/><br/>    

                            <div id="search-container"></div>
                            <div id="pagination-links"></div>
                            
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

            </div>
          

        </div>

    </div>
</body>

@endsection

@section('script')



@endsection
