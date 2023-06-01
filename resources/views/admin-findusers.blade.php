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
            background-image: linear-gradient(#93186c, #93186c);
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

    <body>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-NQSK80GP6J"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-NQSK80GP6J');

        </script>

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KHQR3RD" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <div class="main-content" style="margin-left: 0px;">
            <div class="page-content" style="padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                <div class="row" id="card1" style="margin-left: 0px;margin-right: 0px;">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body" style="padding-bottom: 0px;padding-top: 0px;">

                                {{-- <h4 class="card-title mb-2 d-flex justify-content-left" style="font-size: 18px">
                                    Client Search
                                </h4>

                                <hr style="color: #93186c ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #93186c; background-color: #93186c; opacity: 100%;"> --}}

                                <div class="heading-fica-id mb-4">
                                    <div class="text-center">
                                        <h4 class="font-size-18"
                                            style="color: #fff; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                                            Client Search
                                        </h4>
                                    </div>
                                </div>

                                <!-- <form id="search-form">
                                    <input type="text" name="query">
                                    <button type="submit">Search</button>
                                </form> -->

                                <form method="POST" action="" id="searchclient">

                                    {{-- <div id="errordisplay">
                                        @if (Session::has('exception'))
                                            <div class="alert alert-danger">
                                                Failed - Reason: User(s) Not Found
                                            </div>
                                        @endif
                                    </div> --}}

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

                                            <div class="col-md-2">
                                                <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0)">Risk Status:</label>

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
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    <script>
        
        function clearAll() {
            $('#search-container').html('');
            document.getElementById("error_msg").style.display = 'none';
            document.getElementById("IDNumber").value = '';
            document.getElementById("FirstName").value = '';
            document.getElementById("LastName").value = '';
            document.getElementById("PhoneNumber").value = '';
            document.getElementById("FICAStatus").value = ''; 
            document.getElementById("FICARiskStatus").value = '';            
        }

        var btn = document.getElementById("clearall");
        btn.addEventListener("click", clearAll);

        
    </script>

  


<script>
    

    $(document).ready(function() {
    //loadEmployees(1);
    // var IDNUMBER = sessionStorage.getItem("idNumber");
    // console.log(IDNumber);
    // if(IDNUMBER != null || IDNUMBER != ''){
    //     document.getElementById("IDNumber").value = IDNUMBER;
    //     validateForm();
    // }

    $(document).on('submit', '#searchclient', function(e) { 
        e.preventDefault();
        validateForm();
    });

    function validateForm()
    {      
        $('#search-container').empty();  
        document.getElementById("error_msg").style.display = 'none';
        var idVal = document.getElementById("IDNumber").value;
        var fname = document.getElementById("FirstName").value;
        var lname = document.getElementById("LastName").value;
        var phonenum = document.getElementById("PhoneNumber").value;
        var ficaStatus = document.getElementById("FICAStatus").value;
        var FICARiskStatus = document.getElementById("FICARiskStatus").value;

        if((idVal === null || idVal === '') && (fname === null || fname === '') && (lname === null || lname === '') && (phonenum === '' || phonenum === null) && (ficaStatus === '' || ficaStatus === null) && (FICARiskStatus === '' || FICARiskStatus === null) )
        { 
            document.getElementById("error_msg").innerHTML = 'Please enter any of the search criteria';
            document.getElementById("error_msg").style.display = 'block';
            return false;
        }else{
            document.getElementById("error_msg").style.display = 'none';
            loadEmployees(1);
            return true;
        }
        return false;

    }
    

    function loadEmployees(page) { 
        var form = $('#searchclient');
        var formData = form.serialize();
        $('#search-container').html('');
        $.ajax({
            url: '{{ route('ajax-search') }}',
            method: 'POST',
            data: formData + '&page=' + page,
            success: function(response) {
                $('#datatable').DataTable({ 
                      "destroy": true, 
                   });

                $('#search-container').html(response);

                $('button.idnumber').on('click', function(val) {
                    //sessionStorage.setItem("idNumber", document.getElementById("IDNumber").value);
                    var readIdNumber = this.id;
                    var IdButton = $('#' + readIdNumber).text();

                    // console.log(IdButton)
                    $("#idnumberResult").val(IdButton)
                    $("#testresult-btn").click();
                });
            }
        });


    }

        // $(document).on('click', '.pagination a', function(e) {
        //     e.preventDefault();
        //     var page = $(this).attr('href').split('page=')[1];
        //     loadEmployees(page);
        // });

    });

    
</script>
@endsection

