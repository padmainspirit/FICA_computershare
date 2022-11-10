@extends('layouts.master-tabs')

{{-- @section('title')
@lang('translation.Form_Wizard')
@endsection --}}


@section('css')

    <style>

        td.one {
            vertical-align: bottom;
            font-weight: bold;
            color: #1a4f6e
        }

        td.two {
            vertical-align: bottom;
            color: black
        }

        th. {
            text-align: left;
            background-color: rgb(4, 4, 4);
            font-size: 15px
        }

        h2.b {
            visibility: hidden;
        }

        .card {
            background-color: #E8E8E8 border: 10px solid blue;
        }

        #downloadPDF {

            font-family: 'Arial';
            color: rgb(218, 24, 24);
        }

        .card-title.h5 {
            text-decoration: underline;
        }

        #my-table {
            color: #ff3c00
        }

        P {
            font-weight: bold;
            font-size: 20px;
        }

        .heading-fica-id {
            height: 5%;
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

        <div class="page-content" style="padding-bottom: 0px;padding-right: 0px;padding-top: 0px;padding-left: 0px;">

            {{--  <ol class="breadcrumb" style="padding-right: 0px;padding-bottom: 0px;padding-top: 0px;padding-left: 0px;margin-bottom: 0px;margin-top: 26px;margin-right: 80px;">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Search User</a></li>
                <li class="breadcrumb-item text-decoration-underline"  style="font-weight: 500"><a href="javascript: void(0);">{{ $FirstName }} {{ $SURNAME }}</a></li>
            </ol>  --}}

            <div class="row">
                <div class="col-md-9"></div>

                <div class="col-md-3">

                    <ol class="breadcrumb" style="margin-bottom: 0px;padding-right: 0px;padding-top: 0px;padding-left: 82px;">
                        <li class="breadcrumb-item"><a type="button"
                                onclick="window.history.back()">Find Users</a></li>
                        <li class="breadcrumb-item text-decoration-underline"
                            style="font-weight: 500"><a href="javascript: void(0);">Client Information</a></li>
                    </ol>

                </div>
            </div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block" style="color: #93186c;">Results</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block" style="color: #93186c;">Personal Details</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab3" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                        <span class="d-none d-sm-block" style="color: #93186c;">Address Details</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab4" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-money-check"></i></span>
                        <span class="d-none d-sm-block" style="color: #93186c;">Financials</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab5" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-list-alt"></i></span>
                        <span class="d-none d-sm-block" style="color: #93186c;">Other Details</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab6" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-certificate"></i></span>
                        <span class="d-none d-sm-block" style="color: #93186c;">Documents</span>
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content p-3 text-muted">

                <div class="tab-pane active" id="tab1" role="tabpanel">

                    <div class="row justify-content-center">

                        <div class="col-sm-2">
                            <div class="card" style="width: 100%;">
                                <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                    <h5 class="card-title" style="text-align: center;">
                                        User Profile
                                    </h5>

                                    @if ($Identity_status == 1)
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="bx bx-check-circle  bx-md" style="color: #6ec300"></i>
                                    </h6>
                                    @elseif ($Identity_status == 0)
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="bx bx-x-circle  bx-md" style="color: #E0474C"></i>
                                    </h6>
                                    @else
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="dripicons-question  bx-md" style="color: #FFA500"></i>
                                    </h6>
                                    @endif

                                    <div class="form-floating mb-3">
                                        <img src="/images/results/client1.gif" alt="" height="100" width="100" class="auth-logo-light"
                                            style="display: block; margin: auto">
                                    </div>

                                    <div class="mb-2"></div>


                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-sm-2">
                            <div class="card" style="width: 100%;">
                                <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                    <h5 class="card-title" style="text-align: center;">
                                        KYC</h5>

                                        @if ($KYC_Status == 1)
                                        <h6 class="card-title" style="text-align: center;">
                                            <i class="bx bx-check-circle  bx-md" style="color: #6ec300"></i>
                                        </h6>
                                        @elseif ($KYC_Status == 0)
                                        <h6 class="card-title" style="text-align: center;">
                                            <i class="bx bx-x-circle  bx-md" style="color: #E0474C"></i>
                                        </h6>
                                        @else
                                        <h6 class="card-title" style="text-align: center;">
                                            <i class="dripicons-question bx-md" style="color: #FFA500"></i>
                                        </h6>
                                        @endif

                                    <div class="form-floating mb-3">
                                        <img src="/images/results/notes2.gif" alt="" height="100" width="100" class="auth-logo-light"
                                            style="display: block; margin: auto">
                                    </div>

                                    <div class="mb-2"></div>

                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-sm-2">
                            <div class="card" style="width: 100%;">
                                <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                    <h5 class="card-title" style="text-align: center;">Banking Details</h5>

                                        @if ($AVS_Status == 1)
                                        <h6 class="card-title" style="text-align: center;">
                                            <i class="bx bx-check-circle  bx-md" style="color: #6ec300"></i>
                                        </h6>
                                        @elseif ($AVS_Status == 0)
                                        <h6 class="card-title" style="text-align: center;">
                                            <i class="bx bx-x-circle  bx-md" style="color: #E0474C"></i>
                                        </h6>
                                        @else
                                        <h6 class="card-title" style="text-align: center;">
                                            <i class="dripicons-question  bx-md" style="color: #FFA500"></i>
                                        </h6>
                                        @endif

                                    <div class="form-floating mb-3">
                                        <img src="/images/results/money3.gif" alt="" height="100" width="100" class="auth-logo-light"
                                            style="display: block; margin: auto">
                                    </div>

                                    <div class="mb-2"></div>

                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-sm-2">
                            <div class="card" style="width: 100%;">
                                <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                    <h5 class="card-title" style="text-align: center;">
                                        Facial Recognition</h5>

                                        @if ($DOVS_Status == 1)
                                        <h6 class="card-title" style="text-align: center;">
                                            <i class="bx bx-check-circle  bx-md" style="color: #6ec300"></i>
                                        </h6>
                                        @elseif ($DOVS_Status == 0)
                                        <h6 class="card-title" style="text-align: center;">
                                            <i class="bx bx-x-circle  bx-md" style="color: #E0474C"></i>
                                        </h6>
                                        @else
                                        <h6 class="card-title" style="text-align: center;">
                                            <i class="dripicons-question  bx-md" style="color: #FFA500"></i>
                                        </h6>
                                        @endif

                                    <div class="form-floating mb-3">
                                        <img src="/images/results/facephone4.gif" alt="" height="100" width="100" class="auth-logo-light"
                                            style="display: block; margin: auto">
                                    </div>

                                    <div class="mb-2"></div>

                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-sm-2">
                            <div class="card" style="width: 100%;">
                                <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                    <h5 class="card-title" style="text-align: center;">
                                        Compliance
                                    </h5>

                                    @if ($Compliance_Status == 1)
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="bx bx-check-circle  bx-md" style="color: #6ec300"></i>
                                    </h6>
                                    @elseif ($Compliance_Status == 0)
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="bx bx-x-circle  bx-md" style="color: #E0474C"></i>
                                    </h6>
                                    @else
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="dripicons-question  bx-md" style="color: #FFA500"></i>
                                    </h6>
                                    @endif

                                    <div class="form-floating mb-3">
                                        <img src="/images/results/policy5.gif" alt="" height="100" width="100" class="auth-logo-light"
                                            style="display: block; margin: auto">
                                    </div>

                                    <div class="mb-2"></div>

                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                    </div>

                    {{-- <div class="row d-flex justify-content-center"></div> --}}

                    <div class="row">

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body" style="padding-top: 0px;">

                                    {{--  <button type="button" id="buildpdf" name="buildpdf" onclick="buildpdf();"
                                    class="btn btn-rounded waves-effect waves-light mt-2 mb-2 text-white font-size-14"
                                    style="background-color: rgb(31, 59, 219); width: 120px;padding-top: 0px;
                                    padding-right: 0px;padding-bottom: 0px;padding-left: 0px;margin-left: 35px;">
                                    buildpdf TEST
                                    </button>  --}}

                                    {{--  <button type="button" id="btnExportToPDF" name="btnExportToPDF"
                                        class="btn btn-rounded waves-effect waves-light mt-2 mb-2 text-white font-size-14"
                                        style="background-color: rgb(0, 0, 0); width: 120px;padding-top: 0px;
                                    padding-right: 0px;padding-bottom: 0px;padding-left: 0px;margin-left: 35px;">
                                    btnExportToPDF
                                    </button>

                                    <button type="button" id="getpdf" onclick="generateALL();"
                                        class="btn btn-rounded waves-effect waves-light mt-2 mb-2 text-white font-size-14"
                                        style="background-color: rgb(193, 22, 28); width: 120px;padding-top: 0px;
                                    padding-right: 0px;padding-bottom: 0px;padding-left: 0px;margin-left: 35px;">
                                        Export to PDF
                                    </button>  --}}

                                    {{-- <button type="submit" id="downloadPDF" style="font-size:15px" onclick="Export();">
                                        <i class="fa fa-file-pdf-o">
                                        PDF
                                        </i>
                                    </button> --}}

                                    {{-- <p class="card-title-desc">Report</p> --}}<br>
                                    </br>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                                aria-orientation="vertical">
                                                <a class="nav-link mb-2 active" id="v-pills-profile-tab"
                                                    data-bs-toggle="pill" href="#v-pills-profile" role="tab"
                                                    aria-controls="v-pills-profile" aria-selected="true">Profile</a>
                                                <a class="nav-link mb-2" id="v-pills-kyc-tab"
                                                    data-bs-toggle="pill" href="#v-pills-kyc" role="tab"
                                                    aria-controls="v-pills-kyc" aria-selected="false">Know Your Customer (KYC)</a>
                                                <a class="nav-link mb-2" id="v-pills-banking-tab"
                                                    data-bs-toggle="pill" href="#v-pills-banking" role="tab"
                                                    aria-controls="v-pills-banking" aria-selected="false">Bank
                                                    Account Verification</a>
                                                <a class="nav-link mb-2" id="v-pills-facialrecognition-tab"
                                                    data-bs-toggle="pill" href="#v-pills-facialrecognition"
                                                    role="tab" aria-controls="v-pills-facialrecognition"
                                                    aria-selected="false">Facial
                                                    Recognition</a>
                                                <a class="nav-link" id="v-pills-Compliance-tab"
                                                    data-bs-toggle="pill" href="#v-pills-Compliance"
                                                    role="tab" aria-controls="v-pills-Compliance"
                                                    aria-selected="false">Compliance</a>
                                            </div>

                                            <div class="row justify-content-center">
                                                <button type="button" id="newpdf" name="newpdf" onclick="generate();"
                                                class="btn btn-rounded waves-effect waves-light mt-3 text-white font-size-14"
                                                style="background-color: rgb(193, 22, 28); width: 120px;padding-top: 0px;
                                                padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                                Export to PDF
                                                </button>
                                            </div>

                                        </div>
                                        <div class="col-md-9">

                                            <div class="tab-content text-muted mt-4 mt-md-0"
                                                id="v-pills-tabContent">

                                                <div class="tab-pane fade show active" id="v-pills-profile"
                                                    role="tabpanel" aria-labelledby="v-pills-profile-tab">

                                                    <!-- Profile Details -->

                                                    <section>
                                                        {{-- <form class="form-horizontal" method="POST" action="{{ route('admin-tabs-pdfexport') }}"> --}}

                                                        @csrf

                                                        <div class="heading-fica-id">
                                                            <div class="text-left">
                                                                <h4 style="color: #fff; padding-top:8px;padding-bottom: 8px;padding-left: 11px;">
                                                                    Personal Profile
                                                                </h4>
                                                            </div>
                                                        </div>

                                                        <div class="row">

                                                            <div class="col-md-12">

                                                                <div class="table-responsive">
                                                                    <table class="table table-hover mb-0" id="downloadProfile">
                                
                                                                        {{--  <thead style="background-color: #1a4f6e;border-bottom-color: #1a4f6e">
                                                                            <tr>
                                                                                <th class="col-md-6" style="color:#ffffff;">Personal Details</th>
                                                                                <th class="col-md-6" style="color:#ffffff;">Result</th>
                                                                            </tr>
                                                                        </thead>  --}}

                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="col-md-2" style="font-weight: bold;">
                                                                                    Full Name
                                                                                </td>
                                                                                <td class="col-md-4">
                                                                                    {{ $FirstName }} {{ $SecondName }} {{ $SURNAME }}
                                                                                </td>
                                                                                <td class="col-md-2" style="font-weight: bold;">
                                                                                    Gender
                                                                                </td>
                                                                                <td class="col-md-4">
                                                                                    @if ($Gender == 'Male')
                                                                                    Male
                                                                                    @elseif ($Gender == 'Female')
                                                                                    Female
                                                                                    @endif
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Email
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Email }}
                                                                                </td>
                                                                                <td style="font-weight: bold;">
                                                                                    Telephone (H)
                                                                                </td>
                                                                                <td>
                                                                                    {{ $HomeNumberCode }}{{ $HomeNumber }} 
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Telephone (W)
                                                                                </td>
                                                                                <td>
                                                                                    {{ $WorkNumberCode }}{{ $WorkNumber }}
                                                                                </td>
                                                                                <td style="font-weight: bold;">
                                                                                    Telephone (C)
                                                                                </td>
                                                                                <td>
                                                                                    {{ $CellNumberCode }}{{ $CellNumber }} 
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Residential Address
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Res_OriginalAdd1 }},
                                                                                    {{ $Res_OriginalAdd2 }},
                                                                                    {{ $Res_OriginalAdd3 }},
                                                                                    {{ $Res_Pcode }}
                                                                                </td>
                                                                                <td style="font-weight: bold;">
                                                                                    Postal Address
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Post_OriginalAdd1 }},
                                                                                    {{ $Post_OriginalAdd2 }},
                                                                                    {{ $Post_OriginalAdd3 }},
                                                                                    {{ $Post_Pcode }}
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Work Address
                                                                                </td>
                                                                                <td>
                                                                                {{ $Work_OriginalAdd1 }},
                                                                                {{ $Work_OriginalAdd2 }},
                                                                                {{ $Work_OriginalAdd3 }},
                                                                                {{ $Work_Pcode }}
                                                                                </td>
                                                                                <td style="font-weight: bold;">
                                                                                    Nationality
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Nationality }}
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Date of Birth
                                                                                </td>
                                                                                <td>
                                                                                    {{ $BirthDate }}
                                                                                </td>
                                                                                <td style="font-weight: bold;">
                                                                                    Country of Birth
                                                                                </td>
                                                                                <td>
                                                                                    {{ $ID_CountryResidence }}
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    ID Date of Issue
                                                                                </td>
                                                                                <td>
                                                                                    {{ $ID_DateofIssue }}
                                                                                </td>
                                                                            </tr>

                                                                        </tbody>

                                                                    </table>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </section>

                                                </div>

                                                <div class="tab-pane fade" id="v-pills-kyc" role="tabpanel"
                                                    aria-labelledby="v-pills-kyc-tab">

                                                    <section>

                                                        {{--  <div class="heading-fica-id">
                                                            <div class="text-left">
                                                                <h4 style="color: #fff; padding-top:8px;padding-bottom: 8px;padding-left: 11px;">
                                                                    Know Your Customer
                                                                </h4>
                                                            </div>
                                                        </div>  --}}

                                                        <div class="row">

                                                            <div class="col-md-12">

                                                                <div class="table-responsive">
                                                                    <table class="table table-hover mb-0" id="downloadKYC">
                                
                                                                        <thead style="background-color: #1a4f6e;border-bottom-color: #1a4f6e">
                                                                            <tr>
                                                                                <th class="col-md-4" style="color:#ffffff;">KYC</th>
                                                                                <th class="col-md-7" style="color:#ffffff;">Result</th>
                                                                                <th class="col-md-1" style="color:#ffffff;padding-left: 0px;">Pass/Fail</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    KYC Result
                                                                                </td>
                                                                                <td>
                                                                                    @if ($KYC_Status == 1)
                                                                                        Passed
                                                                                    @else
                                                                                        Failed
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @if ($KYC_Status == 1)
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                   KYC Desc.
                                                                                </td>
                                                                                <td>
                                                                                    {{ $KYCStatusDesc }}
                                                                                    {{-- {{ substr($KYCStatusDesc, 0, 9) }} --}}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($KYCStatusDesc == "Confirmed : SLA Compliant (KYC Confirmed)")
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Residential Address
                                                                                </td>
                                                                                <td>
                                                                                    {{ $ResidentialAddress }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($residential == 'Confirmed')
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    ID Status
                                                                                </td>
                                                                                <td>
                                                                                {{ $IDStatus }}
                                                                                     
                                                                                </td>
                                                                                <td>
                                                                                    @if ($IDStatus == 1)
                                                                                        {{--  <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>  --}}
                                                                                    @else
                                                                                        {{--  <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>  --}}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    ID Status Desc
                                                                                </td>
                                                                                <td>
                                                                                    {{ $IDStatusDesc }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($Identity_status == 1)
                                                                                        {{--  <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>  --}}
                                                                                    @else
                                                                                        {{--  <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>  --}}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Sources Used
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Sources }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($Sources != null)
                                                                                        {{--  <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>  --}}
                                                                                    @else
                                                                                        {{--  <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>  --}}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Total Sources Used
                                                                                </td>
                                                                                <td>
                                                                                    {{ $TotalSourcesUsed }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($TotalSourcesUsed != null)
                                                                                        {{--  <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>  --}}
                                                                                    @else
                                                                                        {{--  <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>  --}}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        

                                                                        </tbody>

                                                                    </table>
                                                                </div>

                                                            </div>

                                                        </div>    

                                                    </section>
                                                </div>

                                                <div class="tab-pane fade" id="v-pills-banking" role="tabpanel"
                                                    aria-labelledby="v-pills-banking-tab">

                                                    <section>

                                                        {{--  <div class="heading-fica-id">
                                                            <div class="text-left">
                                                                <h4 style="color: #fff; padding-top:8px;padding-bottom: 8px;padding-left: 11px;">
                                                                    Bank Account Verification
                                                                </h4>
                                                            </div>
                                                        </div>  --}}

                                                        <div class="row">

                                                            <div class="col-md-12">

                                                                <div class="table-responsive">
                                                                    <table class="table table-hover mb-0" id="downloadBank">
                                
                                                                        <thead style="background-color: #1a4f6e;border-bottom-color: #1a4f6e">
                                                                            <tr>
                                                                                <th class="col-md-4" style="color:#ffffff;">Bank Account Details</th>
                                                                                <th class="col-md-7" style="color:#ffffff;">Result</th>
                                                                                <th class="col-md-1" style="color:#ffffff;padding-left: 0px;">Pass/Fail</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Account Holder
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Account_name }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($Account_name != null)
                                                                                        {{--  <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>  --}}
                                                                                    @else
                                                                                        {{--  <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>  --}}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Bank Name
                                                                               </td>
                                                                                <td>
                                                                                    {{ $Bank_name }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($Bank_name != null)
                                                                                        {{--  <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>  --}}
                                                                                    @else
                                                                                        {{--  <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>  --}}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Account Number
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Account_no }}
                                                                                </td>
                                                                                <td>
                                                                                   @if ($Account_no != null)
                                                                                        {{--  <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>  --}}
                                                                                    @else
                                                                                        {{--  <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>  --}}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Branch Code
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Branch_code }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($Branch_code != null)
                                                                                        {{--  <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>  --}}
                                                                                    @else
                                                                                        {{--  <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>  --}}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                           
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Account Type
                                                                                </td>
                                                                                <td>
                                                                                    {{ $AccountType }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($AccountType != null)
                                                                                        {{--  <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>  --}}
                                                                                    @else
                                                                                        {{--  <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>  --}}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            {{-- <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Branch Name
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Branch }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($Branch != null)
                                                                                         <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p> 
                                                                                    @else
                                                                                         <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p> 
                                                                                    @endif
                                                                                </td>
                                                                            </tr> --}}
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    AVS Status
                                                                                </td>
                                                                                <td>
                                                                                    @if ($AVS_Status == 1)
                                                                                    AVS Completed
                                                                                    @else
                                                                                    AVS Incomplete
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @if ($AVS_Status == 1)
                                                                                            <i class="far fa-check-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Account Exists
                                                                                </td>
                                                                                <td>
                                                                                    {{ $ACCOUNT_OPEN }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($ACCOUNT_OPEN == 'Yes')
                                                                                         <i class="far fa-check-circle" style="font-size: 24px; color: green;"></i> 
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle" style="font-size: 24px; color: red;"></i>  
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Initials Match
                                                                                </td>
                                                                                <td>
                                                                                    {{ $INITIALS }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($INITIALS != null)
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Surname Match
                                                                                </td>
                                                                                <td>
                                                                                    {{ $SURNAME }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($SNameMatch == 'Yes')
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                           <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    ID Number Match
                                                                                </td>
                                                                                <td>
                                                                                    {{ $IDNUMBER }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($IDMatch == 'Yes')
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Email Address Match
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Email }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($EmailMatch == 'Yes')
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Tax References Match
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Tax_Number }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($TaxNumMatch == 'Yes')
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                         
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Account Active
                                                                                </td>
                                                                                <td>
                                                                                    {{ $ACCOUNT_OPEN }}
                                                                                </td>
                                                                                <td>
                                                                                    {{--  @if ($ACCOUNT_OPEN != null)
                                                                                        <i class="far fa-check-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Account Dormant
                                                                                </td>
                                                                                <td>
                                                                                    {{ $ACCOUNTDORMANT }}
                                                                                </td>
                                                                                <td>
                                                                                    {{--  @if ($ACCOUNTDORMANT == 'Not Available')
                                                                                        <i class="far fa-check-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Account open for at least three months
                                                                                </td>
                                                                                <td>
                                                                                    {{ $ACCOUNTOPENFORATLEASTTHREEMONTHS }}
                                                                                </td>
                                                                                <td>
                                                                                    {{--  @if ($ACCOUNTOPENFORATLEASTTHREEMONTHS != 'No' and $ACCOUNTOPENFORATLEASTTHREEMONTHS != NULL)
                                                                                        <i class="far fa-check-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Account accepts debits
                                                                                </td>
                                                                                <td>
                                                                                    {{ $ACCOUNTACCEPTSDEBITS }}
                                                                                </td>
                                                                                <td>
                                                                                    {{--  @if ($ACCOUNTACCEPTSDEBITS == 'Yes')
                                                                                        <i class="far fa-check-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Account accepts credits
                                                                                </td>
                                                                                <td>
                                                                                    {{ $ACCOUNTACCEPTSCREDITS }}
                                                                                </td>
                                                                                <td>
                                                                                    {{--  @if ($ACCOUNTACCEPTSCREDITS == 'Yes')
                                                                                        <i class="far fa-check-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                   @else
                                                                                        <i class="far fa-times-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                               <td style="font-weight: bold;">
                                                                                    Account Issuer
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Bank_name }}
                                                                                </td>
                                                                                <td>
                                                                                    {{--  @if ($Bank_name != null)
                                                                                        <i class="far fa-check-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Account Type Match
                                                                                </td>
                                                                                <td>
                                                                                    @if ($BankTypeid != null)
                                                                                        Yes
                                                                                    @else
                                                                                        No
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    {{--  @if ($BankTypeid != null)
                                                                                        <i class="far fa-check-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                                </td>
                                                                            </tr>

                                                                        </tbody>

                                                                    </table>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </section>
                                                </div>

                                                <div class="tab-pane fade" id="v-pills-facialrecognition"
                                                    role="tabpanel" aria-labelledby="v-pills-facialrecognition-tab">

                                                    <section>

                                                        {{--  <div class="heading-fica-id">
                                                            <div class="text-left">
                                                                <h4 style="color: #fff; padding-top:8px;padding-bottom: 8px;padding-left: 11px;">
                                                                    Facial Recognition
                                                                </h4>
                                                            </div>
                                                        </div>  --}}

                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <div class="table-responsive">
                                                                    <table class="table table-hover mb-0" id="downloadFace">
                                
                                                                        <thead style="background-color: #1a4f6e;border-bottom-color: #1a4f6e">
                                                                            <tr>
                                                                                <th class="col-md-5" style="color:#ffffff;">Facial Recognition Details</th>
                                                                                <th class="col-md-6" style="color:#ffffff;">Result</th>
                                                                                <th class="col-md-1" style="color:#ffffff;padding-left: 0px;">Pass/Fail</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Liveliness Detection
                                                                                </td>
                                                                                <td>
                                                                                    @if ($LivenessDetectionResult == 'Passed')
                                                                                        Passed
                                                                                    @else
                                                                                        Failed
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @if ($LivenessDetectionResult != null)
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                           <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    ID Photo Matched
                                                                                </td>
                                                                                <td>
                                                                                    {{ $ConsumerIDPhotoMatch }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($ConsumerIDPhotoMatch == 'Matched')
                                                                                            <i class="far fa-check-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Deceased Status
                                                                                </td>
                                                                                <td>
                                                                                    @if ($DeceasedStatus == "Deceased")
                                                                                    Deceased
                                                                                    @else
                                                                                    Alive
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    {{--  @if ($DeceasedStatus == "Alive")
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @elseif ($DeceasedStatus == "Deceased")
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Latitude
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Latitude }}
                                                                                </td>
                                                                                <td>
                                                                                    {{--  @if ($Latitude !== 'Device Location Disabled/Denied')
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Longitude
                                                                                </td>
                                                                                <td>
                                                                                    {{ $Longitude }}
                                                                                </td>
                                                                                <td>
                                                                                    {{--  @if ($Longitude !== 'Device Location Disabled/Denied')
                                                                                        <i class="far fa-check-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="far fa-times-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                                </td>
                                                                            </tr>
                                                                           

                                                                        </tbody>

                                                                    </table>
                                                                </div>

                                                                <div class="table-responsive">

                                                                    <table class="table table-hover mb-0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Client Captured Photo
                                                                                </td>
                                                                                <td>
                                                                                    <img align="middle"
                                                                                        src="data:image/png;base64,{{ $ConsumerIDPhoto }}"
                                                                                        alt=""
                                                                                        height="20%"
                                                                                        width="20%"
                                                                                        class="auth-logo-light"
                                                                                        style="margin-left: 140px;">
                                                                                    </img>

                                                                                    <img align="middle"
                                                                                        src="data:image/png;base64,{{ $ConsumerCapturedPhoto }}"
                                                                                        alt=""
                                                                                        height="20%"
                                                                                        width="20%"
                                                                                        class="auth-logo-light"
                                                                                        style="margin-left: 30px;">
                                                                                    </img>
                                                                                </td>
                                                                            </tr>
                                                                            {{--  <tr>
                                                                                <td style="font-weight: bold;">
                                                                                    Client Captured Photo
                                                                                </td>
                                                                                <td>
                                                                                    <img align="left"
                                                                                        src="data:image/png;base64,{{ $ConsumerCapturedPhoto }}"
                                                                                        alt=""
                                                                                        height="275px;"
                                                                                        width="25%"
                                                                                        class="auth-logo-light"
                                                                                        style="display: block;margin-left: 175px;">
                                                                                    </img>
                                                                                </td>
                                                                                <td></td>
                                                                            </tr>  --}}
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </section>
                                                </div>

                                                <div class="tab-pane fade" id="v-pills-Compliance" role="tabpanel"
                                                    aria-labelledby="v-pills-Compliance-tab">

                                                    <!-- Compliance -->

                                                    <section>

                                                        <div class="heading-fica-id">

                                                            <div class="text-left">
                                                                <h4 style="color: #fff; padding-top:8px;padding-bottom: 8px;padding-left: 11px;">
                                                                    Compliance
                                                                </h4>
                                                            </div>

                                                        </div>

                                                        <div class="col-xl-12">
                                                            <div class="mt-2">

                                                                <div class="accordion" id="accordionExample">

                                                                    <div class="accordion-item">

                                                                        <h2 class="accordion-header" id="headingOne">
                                                                            <button class="accordion-button fw-medium collapsed"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#collapseOne"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapseOne">
                                                                                Identity Verification Details
                                                                            </button>
                                                                        </h2>

                                                                        <div id="collapseOne"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="headingOne"
                                                                            data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body">

                                                                                <div class="table-responsive">

                                                                                    <table class="table mb-1" id="downloadCompliance1">

                                                                                        <thead style="background-color: #1a4f6e;border-bottom-color: #1a4f6e;">
                                                                                            <tr>
                                                                                                <th style="color:#ffffff;">
                                                                                                    Compliance Details
                                                                                                </th>
                                                                                                <th style="color:#ffffff;padding-left: 110px;">
                                                                                                    Result
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>

                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td class="table-light"
                                                                                                    style="width: 50%; font-weight: bold;">
                                                                                                    Enquiry Date
                                                                                                </td>

                                                                                                <td>
                                                                                                    {{ $EnquiryDate }}
                                                                                                </td>

                                                                                            </tr>
                                                                                        </tbody>

                                                                                    </table>

                                                                                    <table class="table mb-1" id="downloadCompliance2">

                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th class="table-light"
                                                                                                    style="width: 50%;">
                                                                                                    Enquiry Input</th>
                                                                                                <td>{{ $EnquiryInput }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>

                                                                                    </table>

                                                                                    <table class="table mb-1" id="downloadCompliance3">

                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th class="table-light"
                                                                                                    style="width: 50%;">
                                                                                                    Verified First Name
                                                                                                </th>
                                                                                                <td>{{ $VerifFirstName }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>

                                                                                    </table>

                                                                                    <table class="table mb-1" id="downloadCompliance4">

                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th class="table-light"
                                                                                                    style="width: 50%;">
                                                                                                    Verified Surame</th>
                                                                                                <td>{{ $VerifSurname }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>

                                                                                    </table>

                                                                                    <table class="table mb-1" id="downloadCompliance5">

                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th class="table-light"
                                                                                                    style="width: 50%;">
                                                                                                    Verified Deceased
                                                                                                    Status</th>
                                                                                                <td>{{ $VerifDeseaStat }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>

                                                                                    </table>

                                                                                    <table class="table mb-1" id="downloadCompliance6">

                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th class="table-light"
                                                                                                    style="width: 50%;">
                                                                                                    Verified Deceased
                                                                                                    Date</th>
                                                                                                <td>
                                                                                                    @if ($VerifDeseaDate == null)
                                                                                                    N/A
                                                                                                    @elseif ($VerifDeseaDate != null)  
                                                                                                    {{ $VerifDeseaDate }}                                                                                                 
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>

                                                                                    </table>

                                                                                    <table class="table mb-1" id="downloadCompliance7">

                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th class="table-light"
                                                                                                    style="width: 50%;">
                                                                                                    Verified Cause of
                                                                                                    Death</th>
                                                                                                <td>
                                                                                                    @if ($VerifDeathCause == null)
                                                                                                    N/A
                                                                                                    @elseif ($VerifDeathCause != null)  
                                                                                                    {{ $VerifDeathCause }}                                                                                                 
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>

                                                                                    </table>

                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="accordion-item">

                                                                        <h2 class="accordion-header"
                                                                            id="headingTwo">
                                                                            <button
                                                                                class="accordion-button fw-medium collapsed"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#collapseTwo"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapseTwo">
                                                                                Sanction Screening - (<?php echo count($FetchComplianceSanct) ?>)
                                                                            </button>
                                                                        </h2>

                                                                        <div id="collapseTwo"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="headingTwo"
                                                                            data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body">


                                                                                <div style="overflow: scroll;">

                                                                                    <div style="height:414px; overflow:auto;">

                                                                                        <table class="table mb-1" id="downloadCompliance8">

                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th class="table-light font-size-12" style="width:12%;">
                                                                                                        Date Listed
                                                                                                    </th>
                                                                                                    <th class="table-light font-size-12" style="width:12%;">
                                                                                                        Reason Listed
                                                                                                    </th>
                                                                                                    <th class="table-light font-size-12" style="width:10%;">
                                                                                                        Ent. Type
                                                                                                    </th>
                                                                                                    <th class="table-light font-size-12" style="width:8%;">
                                                                                                        Gender
                                                                                                    </th>
                                                                                                    <th class="table-light font-size-12" style="width:12%;">
                                                                                                        Ent. Name
                                                                                                    </th>
                                                                                                    <th class="table-light font-size-12" style="width:10%;">
                                                                                                        Ent. Score
                                                                                                    </th>
                                                                                                    <th class="table-light font-size-12 text-wrap" style="width:30%;">
                                                                                                        Comments
                                                                                                    </th>
                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                                @foreach ($FetchComplianceSanct as $listing)
                                                                                                <tr>
                                                                                                    <td class="font-size-10">{{ $listing->date_listed }}</td>
                                                                                                    <td class="font-size-10">{{ $listing->ReasonListed }}</td>
                                                                                                    <td class="font-size-10">{{ $listing->Entity_type }}</td>
                                                                                                    <td class="font-size-10">{{ $listing->Gender }}</td>
                                                                                                    <td class="font-size-10">{{ $listing->Entityname }}</td>
                                                                                                    <td class="font-size-10">{{ $listing->BestNameScore }}</td>

                                                                                                    <td class="font-size-10 text-wrap" height="114">
                                                                                                        <div style="height: 114px; overflow: auto">
                                                                                                            {{ $listing->Comments }}
                                                                                                        </div>
                                                                                                    </td>     

                                                                                                </tr>
                                                                                                @endforeach

                                                                                            </tbody>

                                                                                        </table>

                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="accordion-item">

                                                                        <h2 class="accordion-header"
                                                                            id="headingThree">
                                                                            <button
                                                                                class="accordion-button fw-medium collapsed"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#collapseThree"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapseThree">
                                                                                Entity Additional Information - (<?php echo count($FetchComplianceAdd) ?>)
                                                                            </button>
                                                                        </h2>

                                                                        <div id="collapseThree"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="headingThree"
                                                                            data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body">

                                                                                <div class="table-responsive" style="height: 300px; overflow: scroll;">

                                                                                    <table class="table mb-1" id="downloadCompliance9">

                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th class="table-light font-size-12">
                                                                                                    Type
                                                                                                </th>
                                                                                                <th class="table-light font-size-12">
                                                                                                    Value
                                                                                                </th>
                                                                                                <th class="table-light font-size-12">
                                                                                                    Comment
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>

                                                                                        <tbody>

                                                                                            @foreach ($FetchComplianceAdd as $listing)
                                                                                            <tr>
                                                                                                <td class="font-size-10">{{ $listing->Additional_type }}</td>
                                                                                                <td class="font-size-10">{{ $listing->Additional_value }}</td>
                                                                                                <td class="font-size-10">{{ $listing->Additional_comment }}</td>
                                                                                            </tr>
                                                                                            @endforeach

                                                                                        </tbody>

                                                                                    </table>

                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <!-- end accordion -->
                                                            </div>
                                                        </div>
                                                        <!-- end col -->

                                                    </section>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->

                        </div>{{-- END OF TAB 6 --}}

                    </div>

                </div>{{-- END OF TAB 1 --}}

                <div class="tab-pane" id="tab2" role="tabpanel">

                    <form class="form-horizontal" method="POST" action="{{ route('admin-tabs-personal') }}">

                        @csrf

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="cardarea1">

                                        <div class="row">

                                            {{-- <div class="col-lg-1">
                                                <h4 class="card-title mb-2 d-flex justify-content-left"
                                                    style="font-size: 18px">
                                                    Personal
                                                    <i class="fas fa-user"
                                                        style="font-size: 25px; margin-left: 25px;"></i>
                                                </h4>
                                            </div> --}}

                                            <div class="heading-fica-id mb-3">
                                                <div class="text-center">
                                                    <h4 class="font-size-18" style="color: #fff; padding-top:10px;">
                                                        Personal
                                                    </h4>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <hr style="color: #1a4f6e ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #1a4f6e; background-color: #1a4f6e; opacity: 100%;"> --}}

                                        <div class="col-lg-12 mt-2">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">First
                                                            Name:</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <input type="text" id="FirstName" name="FirstName"
                                                            class="form-control input-sm" value="{{ $FirstName }}"
                                                            style="height: 27px; width: 225px;padding-left: 24px; 
                                                            text-transform: uppercase; font-size: 11px;"
                                                            placeholder="Enter Your First Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Last
                                                            Name:</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 225px;">

                                                            <input type="text" id="SURNAME" name="SURNAME"
                                                                class="form-control input-sm"
                                                                value="{{ $SURNAME }}"
                                                                placeholder="Enter Your Last Name"
                                                                style="height: 27px; padding-left: 24px; font-size: 11px;
                                                                width: 100px; text-transform: uppercase;"></input>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                {{-- <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Second
                                                            Name:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">

                                                        <input type="text" id="SecondName" name="SecondName"
                                                            class="form-control input-sm" value="{{ $SecondName }}"
                                                            style="height: 27px; width: 225px; padding-left: 24px; font-size: 11px;
                                                            text-transform: uppercase;"
                                                            placeholder="Enter Your Second Name"></input>

                                                    </div>
                                                </div> --}}

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">
                                                            Gender:
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 225px;">

                                                            <select class="form-select" autocomplete="off"
                                                                style="height: 27px; padding-left: 21px;padding-top: 2px;padding-bottom: 2px;
                                                                text-transform: uppercase; font-size: 11px;"
                                                                id="Gender" name="Gender"
                                                                aria-placeholder="Select">
                                                                <option value="" selected="" disabled="">Select</option>

                                                                <option value=1
                                                                {{ isset($Gender) && $Gender == 'Male' ? 'selected' : '' }}>
                                                                MALE
                                                                </option>

                                                                <option value=2
                                                                {{ isset($Gender) && $Gender == 'Female' ? 'selected' : '' }}>
                                                                FEMALE
                                                                </option>

                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Email
                                                            Address:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">

                                                        <input type="text" id="Email" name="Email"
                                                            class="form-control input-sm" value="{{ $Email }}"
                                                            style="height: 27px; width: 10px; padding-left: 24px; font-size: 11px;
                                                             width: 225px; text-transform: uppercase;"
                                                            placeholder="Enter Your Email"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Date of
                                                            Birth:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 225px;">

                                                            <input class="form-control" type="date" id="BirthDate"
                                                                name="BirthDate"
                                                                value="{{ substr($BirthDate, 0, 10) }}"
                                                                style="height: 27px;padding-left: 21px; font-size: 12px;
                                                                padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;"
                                                                readonly></input>

                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Identity
                                                            Date Issued:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input class="form-control" type="date" id="testing"
                                                            name="testing"
                                                            value="{{ substr($ID_DateofIssue, 0, 10) }}"
                                                            style="height: 27px;padding-left: 21px; font-size: 12px;
                                                            padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;"
                                                            readonly/>

                                                    </div>
                                                </div> --}}

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">
                                                            Identity Country of Issue:
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 225px;">

                                                            <input type="text" id="ID_CountryResidence"
                                                                name="ID_CountryResidence"
                                                                value="{{ $ID_CountryResidence }}"
                                                                class="form-control input-sm"
                                                                style="height: 27px; width: 10px; font-size: 12px;
                                                                padding-left: 24px; text-transform: uppercase;"
                                                                placeholder="Enter The Country Issuer"></input>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-12">
                                            <div class="row">

                                                

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Maritial
                                                            Status:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">

                                                    <div class="input-group" style="height: 27px; width: 225px;">

                                                        <input type="text" id="MaritalStatusDesc"
                                                            name="MaritalStatusDesc" class="form-control input-sm"
                                                            value="{{ $MaritalStatusDesc }}"
                                                            style="height: 27px; width: 225px; font-size: 12px;
                                                             padding-left: 24px; text-transform: uppercase;"
                                                            placeholder="Enter Your Marriage Status"></input>
                                                        </select>

                                                    </div>
                                                </div>

                                            </div>
                                        </div> --}}

                                        {{-- <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Type
                                                            of Marriage:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 225px;">

                                                            <input type="text" id="Married_under"
                                                                name="Married_under" class="form-control input-sm"
                                                                value="{{ $Married_under }}"
                                                                style="height: 27px; width: 225px; font-size: 12px;
                                                                padding-left: 24px; text-transform: uppercase;"
                                                                placeholder="Enter Your Marriage Type"></input>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Date of
                                                            Marriage:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input class="form-control" type="date" id="Marriage_date"
                                                            name="Marriage_date" value="{{ $Marriage_date }}"
                                                            style="height: 27px;padding-left: 21px; font-size: 12px;
                                                            padding-bottom: 2px;padding-top: 2px; text-transform: uppercase;">
                                                        </input>

                                                    </div>

                                                </div>

                                            </div>
                                        </div> --}}

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="cardarea2">

                                        {{-- <form class="form-horizontal" method="POST"
                                        action="{{ route('admin-tabs-personal') }}"> --}}

                                        <div class="row">

                                            {{-- <div class="col-lg-3">
                                                <h4 class="card-title mb-2 d-flex justify-content-left"
                                                    style="font-size: 18px">
                                                    Identity Details
                                                    <i class="fas fa-address-card"
                                                        style="font-size: 25px; margin-left: 25px;"></i>
                                                </h4>
                                            </div> --}}

                                            <div class="heading-fica-id mb-3">
                                                <div class="text-center">
                                                    <h4 class="font-size-18" style="color: #fff; padding-top:10px;">
                                                        Identity Details
                                                    </h4>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <hr style="color: #1a4f6e ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #1a4f6e; background-color: #1a4f6e; opacity: 100%;"> --}}

                                        <div class="col-lg-12 mt-2">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Work
                                                            Number:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="input-group mb-3" style="height: 27px; width: 225px;">

                                                        <input type="text" id="WorkTelephoneNo"
                                                            name="WorkTelephoneNo" class="form-control input-sm"
                                                            value="{{ $WorkNumberCode }}{{ $WorkNumber }}"
                                                            style="padding-left: 24px; height: 27px; font-size: 12px;
                                                             width: 225px; text-transform: uppercase;"
                                                            placeholder="Enter Work Number">
                                                        </input>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Home
                                                            Telephone:</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 225px;">

                                                            <input type="text" id="HomeTelephoneNo"
                                                                name="HomeTelephoneNo" class="form-control input-sm"
                                                                value="{{ $HomeNumberCode }}{{ $HomeNumber }}" 
                                                                style="height: 27px; padding-left: 24px; font-size: 12px;
                                                                text-transform: uppercase;"
                                                                placeholder="Enter Home Number">
                                                            </input>

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
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Mobile
                                                            Telephone:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="input-group" style="height: 27px; width: 225px;">

                                                        <input type="text" id="CellularNo" name="CellularNo"
                                                            class="form-control input-sm" 
                                                            value="{{ $CellNumberCode }}{{ $CellNumber }}" 
                                                            style="height: 27px; padding-left: 24px; font-size: 12px;
                                                            text-transform: uppercase;"
                                                            placeholder="Enter Cell Number">
                                                        </input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="cardarea3">

                                        <div class="row">

                                            {{-- <div class="col-lg-3">
                                                <h4 class="card-title mb-2 d-flex justify-content-left"
                                                    style="font-size: 18px">
                                                    Employment Details
                                                    <i class="fas fa-user-tie"
                                                        style="font-size: 25px; margin-left: 25px;"></i>
                                                </h4>
                                            </div> --}}

                                            <div class="heading-fica-id mb-3">
                                                <div class="text-center">
                                                    <h4 class="font-size-18" style="color: #fff; padding-top:10px;">
                                                        Employment Details
                                                    </h4>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <hr style="color: #1a4f6e ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #1a4f6e; background-color: #1a4f6e; opacity: 100%;"> --}}

                                        <div class="row d-flex justify-content-center">

                                            <div class="col-lg-12 mt-2">
                                                <div class="row">

                                                    <div class="col-md-2">
                                                        <div class="mb-3">

                                                            <label for="basicpill-vatno-input"
                                                                class="font-weight-bold"
                                                                style="font-size: 12px; color: rgb(0, 0, 0)">Employment
                                                                Status:</label>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="input-group" style="height: 27px; width: 225px;">

                                                            <?php
                                                            if ($Employmentstatus == 1) {
                                                                $Employmentstatus = 'Employed';
                                                            } elseif ($Employmentstatus == 0) {
                                                                $Employmentstatus = 'Unemployed';
                                                            }
                                                            ?>

                                                            <input type="text" id="Employmentstatus"
                                                                name="Employmentstatus" class="form-control input-sm"
                                                                value="{{ $Employmentstatus }}"
                                                                style="height: 27px; padding-left: 24px; font-size: 12px;
                                                                 text-transform: uppercase;"
                                                                placeholder="Enter Name Of Employer"></input>

                                                            {{-- <select class="form-select" autocomplete="off"
                                                            style="height: 27px; padding-left: 24px;padding-top: 2px;padding-bottom: 2px;"
                                                            id="EmploymentStatus" name="EmploymentStatus">
                                                            <option value="" selected disabled>Select </option>
                                                            <option value="Employed">Employed</option>
                                                            <option value="Contractor">Contractor</option>
                                                            <option value="Self-Employed">Self-Employed
                                                            </option>
                                                            <option value="Unemployed">Unemployed</option>
                                                        </select> --}}

                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-3">

                                                            <label for="basicpill-vatno-input"
                                                                class="font-weight-bold"
                                                                style="font-size: 12px; color: rgb(0, 0, 0)">
                                                                Name Of Employer:
                                                            </label>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-3">
                                                            <div class="input-group"
                                                                style="height: 27px; width: 225px;">

                                                                <input type="text" id="Nameofemployer"
                                                                    name="Nameofemployer"
                                                                    class="form-control input-sm"
                                                                    value="{{ $Nameofemployer }}"
                                                                    style="height: 27px; padding-left: 24px; font-size: 12px;
                                                                     text-transform: uppercase;"
                                                                    placeholder="Enter Name Of Employer">
                                                                </input>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="row">

                                                    <div class="col-md-2">
                                                        <div class="mb-3">

                                                            <label for="basicpill-vatno-input"
                                                                class="font-weight-bold"
                                                                style="font-size: 12px; color: rgb(0, 0, 0)">Employment
                                                                Industry:
                                                            </label>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-3" style=" width: 225px; height: 27px;">

                                                            <input type="text" id="Industryofoccupation"
                                                                value="{{ $Industryofoccupation }}"
                                                                name="Industryofoccupation"
                                                                class="form-control input-sm"
                                                                style="height: 27px;; padding-left: 24px; font-size: 12px;
                                                                 text-transform: uppercase;"
                                                                placeholder="Enter Employment Industry"></input>

                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="row justify-content-center">

                                                <div class="col-lg-1">
                                                    <button type="submit" id="formsave1"
                                                        class="btn btn-primary w-md"
                                                        style="background-color: rgb(0, 0, 0); border-color: rgb(0, 0, 0)">Save</button>
                                                </div>

                                                <div class="col-lg-1">
                                                    <button type="button" id="formedit1"
                                                        class="btn btn-primary w-md" onclick="formEdit()"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e">Edit</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <button type="button" id="formcancel1"
                                                        class="btn btn-primary w-md" onclick="formCancel()"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e">Cancel</button>
                                                </div>

                                                {{-- <div class="col-lg-1">
                                                    <a onclick="topFunction()">
                                                        <button type="button" class="btn btn-primary w-md"
                                                            style="background-color: #1a4f6e; border-color: #1a4f6e">
                                                            Back to Top
                                                        </button>
                                                    </a>
                                                </div> --}}

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>

                </div>{{-- END OF TAB 2 --}}

                <div class="tab-pane" id="tab3" role="tabpanel">

                    <form class="form-horizontal" method="POST" action="{{ route('admin-tabs-address') }}">

                        @csrf

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="cardarea4">

                                        <div class="row">

                                            {{-- <div class="col-lg-3">
                                                <h4 class="card-title mb-2 d-flex justify-content-left"
                                                    style="font-size: 18px">
                                                    Physical Address
                                                    <i class="fas fa-house-user"
                                                        style="font-size: 25px; margin-left: 25px;"></i>
                                                </h4>
                                            </div> --}}

                                            <div class="heading-fica-id mb-3">
                                                <div class="text-center">
                                                    <h4 class="font-size-18" style="color: #fff; padding-top:10px;">
                                                        Physical Address
                                                    </h4>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <hr style="color: #1a4f6e ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #1a4f6e; background-color: #1a4f6e; opacity: 100%;"> --}}

                                        <div class="col-lg-12 mt-2">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Street Address
                                                            1:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="OriginalAddress1"
                                                            name="OriginalAddress1" class="form-control input-sm"
                                                            value="{{ $Res_OriginalAdd1 }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Street Address Line 1"></input>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Street Address
                                                            2:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="OriginalAddress2"
                                                            name="OriginalAddress2" class="form-control input-sm"
                                                            value="{{ $Res_OriginalAdd2 }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Street Address Line 2"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">City/Town:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="OriginalAddress3"
                                                            name="OriginalAddress3" class="form-control input-sm"
                                                            value="{{ $Res_OriginalAdd3 }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your City/Town"></input>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Province:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 225px;">
                                                            <select class="form-select" autocomplete="off" style="height: 27px;padding-top: 3px; text-transform: uppercase;
                                                                padding-left: 20px;padding-bottom: 3px;font-size: 12px;" id="ResProvince" name="ResProvince">
                                                                <option selected style="text-transform: uppercase;font-size: 12px;" disabled>
                                                                    Select
                                                                </option>

                                                                <option value="Eastern Cape" style="font-size: 12px;"
                                                                    {{ isset($ResProvince) && $ResProvince == 'Eastern Cape' ? 'selected' : '' }}>
                                                                    Eastern Cape
                                                                </option>

                                                                <option value="Free State" style="font-size: 12px;"
                                                                    {{ isset($ResProvince) && $ResProvince == 'Free State' ? 'selected' : '' }}>
                                                                    Free State
                                                                </option>

                                                                <option value="KwaZulu-Natal" style="font-size: 12px;"
                                                                    {{ isset($ResProvince) && $ResProvince == 'KwaZulu-Natal' ? 'selected' : '' }}>
                                                                    KwaZulu-Natal
                                                                </option>

                                                                <option value="Limpopo" style="font-size: 12px;"
                                                                    {{ isset($ResProvince) && $ResProvince == 'Limpopo' ? 'selected' : '' }}>
                                                                    Limpopo
                                                                </option>

                                                                <option value="Mpumalanga" style="font-size: 12px;"
                                                                    {{ isset($ResProvince) && $ResProvince == 'Mpumalanga' ? 'selected' : '' }}>
                                                                    Mpumalanga
                                                                </option>

                                                                <option value="North West" style="font-size: 12px;"
                                                                    {{ isset($ResProvince) && $ResProvince == 'North West' ? 'selected' : '' }}>
                                                                    North West
                                                                </option>

                                                                <option value="Northern Cape" style="font-size: 12px;"
                                                                    {{ isset($ResProvince) && $ResProvince == 'Northern Cape' ? 'selected' : '' }}>
                                                                    Northern Cape
                                                                </option>

                                                                <option value="Western Cape" style="font-size: 12px;"
                                                                    {{ isset($ResProvince) && $ResProvince == 'Western Cape' ? 'selected' : '' }}>
                                                                    Western Cape
                                                                </option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--  <div class="col-md-2">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="ResProvince" name="ResProvince"
                                                            class="form-control input-sm"
                                                            value="{{ $ResProvince }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Province"></input>

                                                    </div>
                                                </div>  --}}

                                                {{-- <div class="col-md-2">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="Province" name="Province"
                                                            class="form-control input-sm" value="{{ $Province }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase"
                                                            placeholder=""></input>

                                                    </div>
                                                </div> --}}

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Zip/Postal
                                                            Code:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="OriginalPostalCode"
                                                            name="OriginalPostalCode" class="form-control input-sm"
                                                            value="{{ $Res_Pcode }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Zip Code"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="cardarea5">

                                        {{-- <form class="form-horizontal" method="POST" action="{{ route('admin-tabs-Address') }}"> --}}

                                        {{-- @csrf --}}

                                        <div class="row">

                                            {{-- <div class="col-lg-3">
                                                <h4 class="card-title mb-2 d-flex justify-content-left"
                                                    style="font-size: 18px">
                                                    Postal Address
                                                    <i class="fas fa-mail-bulk"
                                                        style="font-size: 25px; margin-left: 25px;"></i>
                                                </h4>
                                            </div> --}}

                                            <div class="heading-fica-id mb-3">
                                                <div class="text-center">
                                                    <h4 class="font-size-18" style="color: #fff; padding-top:10px;">
                                                        Postal Address
                                                    </h4>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <hr style="color: #1a4f6e ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #1a4f6e; background-color: #1a4f6e; opacity: 100%;"> --}}

                                        <div class="col-lg-12 mt-2">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Street Address
                                                            1:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="PostOriginalAddress1"
                                                            name="PostOriginalAddress1" class="form-control input-sm"
                                                            value="{{ $Post_OriginalAdd1 }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Street Address Line 1"></input>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Street Address
                                                            2:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="PostOriginalAddress2"
                                                            name="PostOriginalAddress2" class="form-control input-sm"
                                                            value="{{ $Post_OriginalAdd2 }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Street Address Line 2"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">City/Town:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="PostOriginalAddress3"
                                                            name="PostOriginalAddress3" class="form-control input-sm"
                                                            value="{{ $Post_OriginalAdd3 }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your City/Town"></input>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Province:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 225px;">
                                                            <select class="form-select" autocomplete="off" style="height: 27px;padding-top: 3px; text-transform: uppercase;
                                                                padding-left: 20px;padding-bottom: 3px;font-size: 12px;" id="PostProvince" name="PostProvince">
                                                                <option selected style="text-transform: uppercase;font-size: 12px;" disabled>
                                                                    Select
                                                                </option>

                                                                <option value="Eastern Cape" style="font-size: 12px;"
                                                                    {{ isset($PostProvince) && $PostProvince == 'Eastern Cape' ? 'selected' : '' }}>
                                                                    Eastern Cape
                                                                </option>

                                                                <option value="Free State" style="font-size: 12px;"
                                                                    {{ isset($PostProvince) && $PostProvince == 'Free State' ? 'selected' : '' }}>
                                                                    Free State
                                                                </option>

                                                                <option value="KwaZulu-Natal" style="font-size: 12px;"
                                                                    {{ isset($PostProvince) && $PostProvince == 'KwaZulu-Natal' ? 'selected' : '' }}>
                                                                    KwaZulu-Natal
                                                                </option>

                                                                <option value="Limpopo" style="font-size: 12px;"
                                                                    {{ isset($PostProvince) && $PostProvince == 'Limpopo' ? 'selected' : '' }}>
                                                                    Limpopo
                                                                </option>

                                                                <option value="Mpumalanga" style="font-size: 12px;"
                                                                    {{ isset($PostProvince) && $PostProvince == 'Mpumalanga' ? 'selected' : '' }}>
                                                                    Mpumalanga
                                                                </option>

                                                                <option value="North West" style="font-size: 12px;"
                                                                    {{ isset($PostProvince) && $PostProvince == 'North West' ? 'selected' : '' }}>
                                                                    North West
                                                                </option>

                                                                <option value="Northern Cape" style="font-size: 12px;"
                                                                    {{ isset($PostProvince) && $PostProvince == 'Northern Cape' ? 'selected' : '' }}>
                                                                    Northern Cape
                                                                </option>

                                                                <option value="Western Cape" style="font-size: 12px;"
                                                                    {{ isset($PostProvince) && $PostProvince == 'Western Cape' ? 'selected' : '' }}>
                                                                    Western Cape
                                                                </option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--  <div class="col-md-2">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="PostProvince" name="PostProvince"
                                                            class="form-control input-sm"
                                                            value="{{ $PostProvince }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Postal Province"></input>

                                                    </div>
                                                </div>  --}}

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Zip/Postal
                                                            Code:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="PostOriginalPostalCode"
                                                            name="PostOriginalPostalCode"
                                                            class="form-control input-sm" value="{{ $Post_Pcode }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Zip Code"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="cardarea6">

                                        {{-- <form class="form-horizontal" method="POST" action="{{ route('admin-tabs-Address') }}"> --}}

                                        @csrf

                                        <div class="row">

                                            {{-- <div class="col-lg-3">
                                                <h4 class="card-title mb-2 d-flex justify-content-left"
                                                    style="font-size: 18px">
                                                    Work Address
                                                    <i class="fas fa-mail-bulk"
                                                        style="font-size: 25px; margin-left: 25px;"></i>
                                                </h4>
                                            </div> --}}

                                            <div class="heading-fica-id mb-3">
                                                <div class="text-center">
                                                    <h4 class="font-size-18" style="color: #fff; padding-top:10px;">
                                                        Work Address
                                                    </h4>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <hr style="color: #1a4f6e ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #1a4f6e; background-color: #1a4f6e; opacity: 100%;"> --}}

                                        <div class="col-lg-12 mt-2">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Street Address
                                                            1:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="WorkOriginalAddress1"
                                                            name="WorkOriginalAddress1" class="form-control input-sm"
                                                            value="{{ $Work_OriginalAdd1 }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Street Address Line 1"></input>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Street Address
                                                            2:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="WorkOriginalAddress2"
                                                            name="WorkOriginalAddress2" class="form-control input-sm"
                                                            value="{{ $Work_OriginalAdd2 }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Street Address Line 2"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">City/Town:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="WorkOriginalAddress3"
                                                            name="WorkOriginalAddress3" class="form-control input-sm"
                                                            value="{{ $Work_OriginalAdd3 }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your City/Town"></input>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Province:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 225px;">
                                                            <select class="form-select" autocomplete="off" style="height: 27px;padding-top: 3px; text-transform: uppercase;
                                                                padding-left: 20px;padding-bottom: 3px;font-size: 12px;" id="WorkProvince" name="WorkProvince">
                                                                <option selected style="text-transform: uppercase;font-size: 12px;" disabled>
                                                                    Select
                                                                </option>

                                                                <option value="Eastern Cape" style="font-size: 12px;"
                                                                    {{ isset($WorkProvince) && $WorkProvince == 'Eastern Cape' ? 'selected' : '' }}>
                                                                    Eastern Cape
                                                                </option>

                                                                <option value="Free State" style="font-size: 12px;"
                                                                    {{ isset($WorkProvince) && $WorkProvince == 'Free State' ? 'selected' : '' }}>
                                                                    Free State
                                                                </option>

                                                                <option value="KwaZulu-Natal" style="font-size: 12px;"
                                                                    {{ isset($WorkProvince) && $WorkProvince == 'KwaZulu-Natal' ? 'selected' : '' }}>
                                                                    KwaZulu-Natal
                                                                </option>

                                                                <option value="Limpopo" style="font-size: 12px;"
                                                                    {{ isset($WorkProvince) && $WorkProvince == 'Limpopo' ? 'selected' : '' }}>
                                                                    Limpopo
                                                                </option>

                                                                <option value="Mpumalanga" style="font-size: 12px;"
                                                                    {{ isset($WorkProvince) && $WorkProvince == 'Mpumalanga' ? 'selected' : '' }}>
                                                                    Mpumalanga
                                                                </option>

                                                                <option value="North West" style="font-size: 12px;"
                                                                    {{ isset($WorkProvince) && $WorkProvince == 'North West' ? 'selected' : '' }}>
                                                                    North West
                                                                </option>

                                                                <option value="Northern Cape" style="font-size: 12px;"
                                                                    {{ isset($WorkProvince) && $WorkProvince == 'Northern Cape' ? 'selected' : '' }}>
                                                                    Northern Cape
                                                                </option>

                                                                <option value="Western Cape" style="font-size: 12px;"
                                                                    {{ isset($WorkProvince) && $WorkProvince == 'Western Cape' ? 'selected' : '' }}>
                                                                    Western Cape
                                                                </option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--  <div class="col-md-2">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="WorkProvince" name="WorkProvince"
                                                            class="form-control input-sm"
                                                            value="{{ $WorkProvince }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Postal Province"></input>

                                                    </div>
                                                </div>  --}}

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Zip/Postal
                                                            Code:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="WorkOriginalPostalCode"
                                                            name="WorkOriginalPostalCode"
                                                            class="form-control input-sm" value="{{ $Work_Pcode }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Zip Code"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="row justify-content-center">

                                                <div class="col-lg-1">
                                                    <button type="submit" id="formsave2"
                                                        class="btn btn-primary w-md"
                                                        style="background-color: rgb(0, 0, 0); border-color: rgb(0, 0, 0)">Save</button>
                                                </div>

                                                <div class="col-lg-1">
                                                    <button type="button" id="formedit2"
                                                        class="btn btn-primary w-md" onclick="formEdit()"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e">Edit</button>
                                                </div>

                                                <div class="col-lg-2">
                                                    <button type="button" id="formcancel2"
                                                        class="btn btn-primary w-md" onclick="formCancel()"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e">Cancel</button>
                                                </div>

                                                {{-- <div class="col-lg-1">
                                                    <a onclick="topFunction()">
                                                        <button type="button" class="btn btn-primary w-md"
                                                            style="background-color: #1a4f6e; border-color: #1a4f6e">
                                                            Back to Top
                                                        </button>
                                                    </a>
                                                </div> --}}

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>

                </div>{{-- END OF TAB 3 --}}

                <div class="tab-pane" id="tab4" role="tabpanel">

                    <form class="form-horizontal" method="POST" action="{{ route('admin-tabs-screening') }}">

                        @csrf

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="cardarea7">

                                        <div class="row">

                                            {{-- <div class="col-lg-2">
                                                <h4 class="card-title mb-2 d-flex justify-content-left"
                                                    style="font-size: 18px">
                                                    Bank Details
                                                    <i class="bx bxs-bank" style="font-size: 25px; margin-left: 25px;"></i>
                                                </h4>
                                            </div> --}}

                                            <div class="heading-fica-id mb-3">
                                                <div class="text-center">
                                                    <h4 class="font-size-18" style="color: #fff; padding-top:10px;">
                                                        Bank Details
                                                    </h4>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <hr style="color: #1a4f6e ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #1a4f6e; background-color: #1a4f6e; opacity: 100%;"> --}}

                                        <div class="col-lg-12 mt-2">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Bank
                                                            Name:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="Bank_name" name="Bank_name"
                                                            value="{{ $Bank_name }}" class="form-control input-sm"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Bank Name"></input>

                                                    </div>
                                                </div>


                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Account
                                                            Type:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <div class="input-group" style="height: 27px; width: 225px;">

                                                            {{--  <select class="form-select" autocomplete="off"
                                                                style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;"
                                                                id="BankTypeid" name="BankTypeid">
                                                                <option selected style="font-size: 14px; text-transform: uppercase;font-size: 12px;" disabled>
                                                                    {{ $AccountType }}
                                                                </option>
                                                                @foreach ($accounttype as $type)
                                                                <option value="{{ isset($type->BankTypeid) }}  {{ isset($insidedata->BankTypeid) == $type->BankTypeid ? 'selected' : '' }} ">
                                                                {{ $type->AccountType }}
                                                                </option>
                                                                @endforeach
                                                            </select>  --}}

                                                            <select class="form-select" autocomplete="off"
                                                                style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;font-size: 12px;"
                                                                id="BankTypeid" name="BankTypeid">
                                                                <option selected style="text-transform: uppercase;font-size: 12px;" disabled>
                                                                    Select
                                                                </option>

                                                                <option value=1 style="font-size: 12px;"
                                                                {{ isset($AccountType) && $AccountType == 'CURRENT CHEQUE ACCOUNT' ? 'selected' : '' }}>
                                                                CURRENT CHEQUE ACCOUNT
                                                                </option>

                                                                <option value=2 style="font-size: 12px;"
                                                                {{ isset($AccountType) && $AccountType == 'SAVINGS ACCOUNT' ? 'selected' : '' }}>
                                                                SAVINGS ACCOUNT
                                                                </option>

                                                                <option value=3 style="font-size: 12px;"
                                                                {{ isset($AccountType) && $AccountType == 'TRANSMISSION' ? 'selected' : '' }}>
                                                                TRANSMISSION
                                                                </option>

                                                                <option value=4 style="font-size: 12px;"
                                                                {{ isset($AccountType) && $AccountType == 'BOND' ? 'selected' : '' }}>
                                                                BOND
                                                                </option>

                                                                <option value=5 style="font-size: 12px;"
                                                                {{ isset($AccountType) && $AccountType == 'SUBSCRIPTION SHARE' ? 'selected' : '' }}>
                                                                SUBSCRIPTION SHARE
                                                                </option>

                                                                    {{--  <?php 
                                                                    
                                                                    if ($BankTypeid == 1) {
                                                                        $AccountType = 'CURRENT CHEQUE ACCOUNT';
                                                                    } elseif ($BankTypeid == 2) {
                                                                        $AccountType = 'SAVINGS ACCOUNT';
                                                                    } elseif ($BankTypeid == 3) {
                                                                        $AccountType = 'TRANSMISSION';
                                                                    } elseif ($BankTypeid == 4) {
                                                                        $AccountType = 'TRANSMISSION';
                                                                    } elseif ($BankTypeid == 5) {
                                                                        $AccountType = 'SUBSCRIPTION SHARE';
                                                                    }

                                                                    ?> --}}

                                                                    {{-- {{ $AccountType }}
                                                                </option>

                                                                <option value="1"
                                                                    {{ $chequeaccVal == 1 ? 'selected' : '' }}>
                                                                    CURRENT CHEQUE ACCOUNT
                                                                </option>
                                                                <option value="2"
                                                                    {{ $savingsaccVal == 2 ? 'selected' : '' }}>
                                                                    SAVINGS ACCOUNT
                                                                </option>
                                                                <option value="3"
                                                                    {{ $transmissionVal == 3 ? 'selected' : '' }}>
                                                                    TRANSMISSION
                                                                </option>
                                                                <option value="4"
                                                                    {{ $bondVal == 4 ? 'selected' : '' }}>
                                                                    BOND
                                                                </option>
                                                                <option value="5"
                                                                    {{ $subscrVal == 5 ? 'selected' : '' }}>
                                                                    SUBSCRIPTION SHARE
                                                                </option> --}}

                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                {{-- <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">
                                                            Branch Name:
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="Branch" name="Branch"
                                                            class="form-control input-sm" value="{{ $Branch }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Branch Name">
                                                        </input>

                                                    </div>
                                                </div> --}}

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Bank
                                                            Code:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="Branch_code" name="Branch_code"
                                                            class="form-control input-sm"
                                                            value="{{ $Branch_code }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Bank Code">

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Account Holder
                                                            Surname:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="AccountName" name="AccountName"
                                                            class="form-control input-sm"
                                                            value="{{ $Account_name }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Account Surname"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">
                                                
                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Account
                                                            Number:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="Account_no" name="Account_no"
                                                            class="form-control input-sm" value="{{ $Account_no }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Account Number"></input>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Account Holder
                                                            Initials:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="INITIALS" name="INITIALS"
                                                            class="form-control input-sm" value="{{ $INITIALS }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Account Initials"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Tax
                                                            Obligations outside of SA?</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <div class="input-group">

                                                            <select class="form-select" autocomplete="off"
                                                                style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;"
                                                                id="Tax_Oblig_outside_SA" name="Tax_Oblig_outside_SA">
                                                                <option selected disabled> Select </option>
                                                                <option value=1 style="font-size: 12px;"
                                                                {{ isset($Tax_Oblig_outside_SA) && $Tax_Oblig_outside_SA == 1 ? 'selected' : '' }}>
                                                                YES
                                                                </option>

                                                                <option value=0 style="font-size: 12px;"
                                                                {{ isset($Tax_Oblig_outside_SA) && $Tax_Oblig_outside_SA == 0 ? 'selected' : '' }}>
                                                                NO
                                                                </option>
                                                            </select>

                                                            {{--  <select class="form-select" autocomplete="off"
                                                                style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;"
                                                                id="Tax_Oblig_outside_SA" name="Tax_Oblig_outside_SA">
                                                                <option selected disabled>
                                                                    {{ $Display1 }}
                                                                </option>
                                                                <option value=1>Yes</option>
                                                                <option value=0>No</option>
                                                            </select>  --}}

                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">
                                                            Income Tax Number:
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="Tax_Number" name="Tax_Number"
                                                            class="form-control input-sm"
                                                            value="{{ $Tax_Number }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Income Tax Number"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">
                                                            Foreign Tax Number:
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3" style=" width: 225px; height: 27px;">

                                                        <input type="text" id="Foreign_Tax_Number"
                                                            name="Foreign_Tax_Number" class="form-control input-sm"
                                                            value="{{ $Foreign_Tax_Number }}"
                                                            style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                            placeholder="Enter Your Foreign Tax Number"></input>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="cardarea8">

                                        <div class="row">

                                            {{-- <div class="col-lg-1">
                                                <h4 class="card-title mb-2 d-flex justify-content-left"
                                                    style="font-size: 18px">
                                                    Screening
                                                    <i class="bx bxs-user-badge" style="font-size: 25px; margin-left: 25px;"></i>
                                                </h4>
                                            </div> --}}

                                            <div class="heading-fica-id mb-3">
                                                <div class="text-center">
                                                    <h4 class="font-size-18" style="color: #fff; padding-top:10px;">
                                                        Screening
                                                    </h4>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <hr style="color: #1a4f6e ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #1a4f6e; background-color: #1a4f6e; opacity: 100%;"> --}}

                                        <div class="row d-flex justify-content-center">

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0)">Do
                                                        you occupy a prominent official position or perform a public
                                                        function at a senior level?
                                                    </label>

                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0)">Do
                                                        you have any immediate family members/close associates that are
                                                        Domestic Prominent Influential Persons?
                                                    </label>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row d-flex justify-content-center">

                                            <div class="col-lg-6">
                                                <div class="mb-3">

                                                    <select class="form-select" style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;font-size: 12px;"
                                                    name="Public_official" id="Public_official" required>
                                                        <option selected disabled>Select</option>
                                                        <option value=1
                                                            {{ isset($Public_official) && $Public_official == 1 ? 'selected' : '' }}>
                                                            YES</option>
                                                        <option value=0
                                                            {{ isset($Public_official) && $Public_official == 0 ? 'selected' : '' }}>
                                                            NO</option>
                                                    </select>

                                                    <div class="col-md-8 mt-3" id="options1">

                                                        <div class="form-check">
                                                            <input class="form-check-input big-checkbox" type="checkbox"
                                                                value="Domestic Prominent influential Persons"
                                                                id="public-offical-domestic-prominent-checkbox"
                                                                name="public-offical-domestic-prominent-checkbox"
                                                                style="width: 20px; height:20px;"
                                                                {{ isset($Public_official_type_DPIP) && $Public_official_type_DPIP == 'Domestic Prominent influential Persons' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="salary-checkbox"
                                                                style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0);">
                                                                Domestic Prominent influential Persons
                                                            </label>
                                                        </div>
                    
                                                        <div class="form-check">
                                                            <input class="form-check-input big-checkbox" type="checkbox"
                                                                value="FPPO (Foreign Prominent Public Officials)"
                                                                id="public-offical-eppo-checkbox" name="public-offical-eppo-checkbox"
                                                                style="width: 20px; height:20px;"
                                                                {{ isset($Public_official_type_FPPO) && $Public_official_type_FPPO == 'FPPO (Foreign Prominent Public Officials)' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="salary-checkbox"
                                                                style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0); ">
                                                                FPPO (Foreign Prominent Public Officials)
                                                            </label>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-lg-6">

                                                <div class="mb-3">

                                                    <select class="form-select" style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;font-size: 12px;"
                                                    name="Public_official_Family" id="Public_official_Family" required>
                                                    <option selected disabled>Select</option>
                                                    <option value=1
                                                        {{ isset($Public_official_Family) && $Public_official_Family == 1 ? 'selected' : '' }}>
                                                        YES</option>
                                                    <option value=0
                                                        {{ isset($Public_official_Family) && $Public_official_Family == 0 ? 'selected' : '' }}>
                                                        NO</option>
                                                    </select>

                                                    <div class="col-md-8 mt-3" id="options2">

                                                        <div class="form-check">
                                                            <input class="form-check-input big-checkbox" type="checkbox"
                                                                value="Domestic Prominent influential Persons"
                                                                id="public-offica-family-domestic-prominent-checkbox"
                                                                name="public-offica-family-domestic-prominent-checkbox"
                                                                style="width: 20px; height:20px;"
                                                                {{ isset($Public_official_type_family_DPIP) && $Public_official_type_family_DPIP == 'Domestic Prominent influential Persons' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="salary-checkbox"
                                                                style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0);">
                                                                Domestic Prominent influential Persons
                                                            </label>
                                                        </div>
                    
                                                        <div class="form-check">
                                                            <input class="form-check-input big-checkbox" type="checkbox"
                                                                value="FPPO (Foreign Prominent Public Officials)"
                                                                id="public-offica-family-eppo-checkbox" 
                                                                name="public-offica-family-eppo-checkbox"
                                                                style="width: 20px; height:20px;"
                                                                {{ isset($Public_official_type_family_FPPO) && $Public_official_type_family_FPPO == 'FPPO (Foreign Prominent Public Officials)' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="salary-checkbox"
                                                                style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0); ">
                                                                FPPO (Foreign Prominent Public Officials)
                                                            </label>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <br>
                                        <br>

                                        <div class="personal-details">

                                            <div class="row d-flex justify-content-center">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Have
                                                            you appeared on any sanctions list in relation to anti-money
                                                            laundering or counter terrorists financing?
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Have
                                                            you been associate with any adverse or negative media
                                                            published in the domain?
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row d-flex justify-content-center">

                                                <div class="col-lg-6">
                                                    <div class="mb-3">

                                                        <select class="form-select" style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;"
                                                        name="SanctionList" id="SanctionList" required>
                                                        <option selected disabled>Select</option>
                                                        <option value=1 {{ isset($SanctionList) && $SanctionList == 1 ? 'selected' : '' }}>
                                                            YES</option>
                                                        <option value=0 {{ isset($SanctionList) && $SanctionList == 0 ? 'selected' : '' }}>
                                                            NO</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="mb-3">

                                                        <select class="form-select" id="AdverseMedia"
                                                        style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;"
                                                        name="AdverseMedia" required>
                                                        <option selected disabled>Select</option>
                                                        <option value=1
                                                            {{ isset($AdverseMedia) && $AdverseMedia == 1 ? 'selected' : '' }}>
                                                            YES</option>
                                                        <option value=0
                                                            {{ isset($AdverseMedia) && $AdverseMedia == 0 ? 'selected' : '' }}>
                                                            NO</option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <br>

                                            <div class="row d-flex justify-content-center">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">If
                                                            you are a non-resident client, do you possess
                                                            residance in these countries? (Syria; Sudan;
                                                            Iran; Cuba; North Korea; or
                                                            Crimea/Sevastopol regions of Ukraine)
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row d-flex justify-content-center">

                                                <div class="col-lg-6">
                                                    <div class="mb-3">

                                                        <select class="form-select" style="height: 27px;padding-top: 3px;padding-left: 20px;padding-bottom: 3px;"
                                                        name="NonResidentOther" id="NonResidentOther" required>
                                                        <option selected disabled>Select</option>
                                                        <option value=1
                                                            {{ isset($NonResidentOther) && $NonResidentOther == 1 ? 'selected' : '' }}>
                                                            YES</option>
                                                        <option value=0
                                                            {{ isset($NonResidentOther) && $NonResidentOther == 0 ? 'selected' : '' }}>
                                                            NO</option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="row justify-content-center">

                                                <div class="col-lg-1 mb-2">
                                                    <button type="submit" id="formsave3" class="btn btn-primary w-md"
                                                        style="background-color: rgb(0, 0, 0); border-color: rgb(0, 0, 0)">Save</button>
                                                </div>

                                                <div class="col-lg-1 mb-2">
                                                    <button type="button" id="formedit3" class="btn btn-primary w-md"
                                                        onclick="formEdit()"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e">Edit</button>
                                                </div>

                                                <div class="col-lg-2 mb-2">
                                                    <button type="button" id="formcancel3" class="btn btn-primary w-md"
                                                        onclick="formCancel()"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e">Cancel</button>
                                                </div>

                                                {{-- <div class="col-lg-1 mb-2">
                                                    <a onclick="topFunction()">
                                                        <button type="button" class="btn btn-primary w-md"
                                                            style="background-color: #1a4f6e; border-color: #1a4f6e">
                                                            Back to Top
                                                        </button>
                                                    </a>
                                                </div> --}}
                                            
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>

                </div>{{-- END OF TAB 4 --}}

                <div class="tab-pane" id="tab5" role="tabpanel">

                    <form class="form-horizontal" method="POST" action="{{ route('admin-tabs-other') }}">

                        @csrf

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body" id="cardarea9">

                                        <div class="row">

                                            {{-- <div class="col-lg-2">
                                                <h4 class="card-title mb-2 d-flex justify-content-left"
                                                    style="font-size: 18px">
                                                    Other Details
                                                    <i class="fas fa-user-edit"
                                                        style="font-size: 25px; margin-left: 25px;"></i>
                                                </h4>
                                            </div> --}}

                                            <div class="heading-fica-id mb-3">
                                                <div class="text-center">
                                                    <h4 class="font-size-18" style="color: #fff; padding-top:10px;">
                                                        Other Details
                                                    </h4>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- <hr style="color: #1a4f6e ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #1a4f6e; background-color: #1a4f6e; opacity: 100%;"> --}}

                                        <div class="col-lg-12 mt-2">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Client Due
                                                            Diligence:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">

                                                        <select class="form-select" autocomplete="off"
                                                            id="ClientDueDiligence" name="ClientDueDiligence"
                                                            style="height: 27px; width: 225px; padding-bottom: 3px;padding-top: 3px;font-size: 12px;">
                                                        <option selected disabled>Select</option>
                                                        <option value="Once off sale transaction" style="font-size: 12px;"
                                                            {{ isset($ClientDueDiligence) && $ClientDueDiligence == 'Once off sale transaction' ? 'selected' : '' }}>
                                                            Once off sale transaction</option>
                                                        <option value="Ongoing trading(R50 000 above)" style="font-size: 12px;"
                                                            {{ isset($ClientDueDiligence) && $ClientDueDiligence == 'Ongoing trading(R50 000 above)' ? 'selected' : '' }}>
                                                            Ongoing trading(R50 000 above)</option>
                                                        <option value="Ongoing trading (Estimated value between R1 to R50 000)" style="font-size: 12px;"
                                                            {{ isset($ClientDueDiligence) && $ClientDueDiligence == 'Ongoing trading (Estimated value between R1 to R50 000)' ? 'selected' : '' }}>
                                                            Ongoing trading (Estimated value between R1 to R50 000)</option>
                                                        <option value="Other - please specify" style="font-size: 12px;"
                                                            {{ isset($ClientDueDiligence) && $ClientDueDiligence == 'Other - please specify' ? 'selected' : '' }}>
                                                            Other - please specify</option>
                                                        </select>

                                                        {{--  <select class="form-select" autocomplete="off"
                                                            id="ClientDueDiligence" name="ClientDueDiligence"
                                                            style="height: 27px; width: 225px; padding-bottom: 3px;padding-top: 3px;">
                                                            <option value="" selected="" disabled="">
                                                                Select A
                                                                Response
                                                            </option>
                                                            <option value="" selected="" disabled="">
                                                                {{ $ClientDueDiligence }}</option>
                                                            <option value="Once Off Sale Transaction">Once Off Sale
                                                                Transaction
                                                            </option>
                                                            <option
                                                                value="Ongoing Trading(Estimated Value R1 To R50 000)">
                                                                Ongoing Trading(Estimated Value R1 To R50 000)</option>
                                                            <option value="Ongoing Trading(Above R50 000)">Ongoing
                                                                Trading(Above R50 000)
                                                            </option>
                                                            <option value=0>Other(Please Specify)
                                                            </option>
                                                        </select>  --}}

                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-3" id="newoptions1">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Specify
                                                            Other:
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-md-1" id="newoptions2">
                                                    <div class="mb-3">
                                                        <div class="input-group"
                                                            style="height: 27px; width: 225px;">

                                                            <input type="text" id="OtherOptions"
                                                                name="OtherOptions" class="form-control input-sm"
                                                                style="height: 27px; padding-left: 24px; text-transform: uppercase;font-size: 12px;"
                                                                placeholder="State Other">

                                                        </div>
                                                    </div>
                                                </div> --}}

                                                <div class="col-md-3">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Nominee Declaration:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-3">

                                                        {{--  <select class="form-select" autocomplete="off"
                                                            style="height: 27px; width: 225px; padding-bottom: 3px;padding-top: 3px;"
                                                            id="NomineeDeclaration" name="NomineeDeclaration">
                                                            <option value="" selected="" disabled="">
                                                                Select A
                                                                Response
                                                            </option>
                                                            <option value="" selected="" disabled="">
                                                                {{ $NomineeDeclaration }}</option>
                                                            <option
                                                                value="I confirm that I am not acting in the capacity of a nominee intending to hold Securities on behalf of a beneficial owner.">
                                                                I confirm that I am not acting in the capacity of a
                                                                nominee intending to hold Securities on behalf of a
                                                                beneficial owner.
                                                            </option>
                                                            <option
                                                                value="I/We confirm that I am/We are a nominee and intend to hold Securities on behalf of the beneficial owners.">
                                                                I/We confirm that I am/We are a nominee and intend to
                                                                hold Securities on behalf of the beneficial owners.
                                                            </option>
                                                        </select>  --}}

                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px; width: 225px; padding-bottom: 3px;padding-top: 3px;font-size: 12px;"
                                                            id="NomineeDeclaration" name="NomineeDeclaration">
                                                        <option selected disabled>Select</option>

                                                        <option value="NO"
                                                            {{ isset($NomineeDeclaration) && $NomineeDeclaration == 'NO' ? 'selected' : '' }}>
                                                            NO
                                                        </option>

                                                        <option value='I confirm  that I am  not acting in the capacity of nominee intending to hold securities on behalf of a beneficial owner.' style="font-size: 12px;"
                                                        {{ isset($NomineeDeclaration) &&
                                                        $NomineeDeclaration ==
                                                            'I confirm  that I am  not acting in the capacity of nominee intending to hold securities on behalf of a beneficial owner.'
                                                            ? 'selected'
                                                            : '' }}>
                                                        I confirm that I am not acting in the capacity of nominee intending to hold
                                                        securities on behalf of a beneficial owner.</option>

                                                        <option value="I/We confirm that I  am/we  are a nominee and intend to hold Securities on behalf of the beneficial owners." style="font-size: 12px;"
                                                            {{ isset($NomineeDeclaration) && $NomineeDeclaration == 'I/We confirm that I  am/we  are a nominee and intend to hold Securities on behalf of the beneficial owners.' ? 'selected' : '' }}>
                                                            I/We confirm that I am/we are a nominee and intend to hold Securities on
                                                            behalf of the beneficial owners.</option>
                                                        </select>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Issuer
                                                            Communication Selection:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">

                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;font-size: 12px;"
                                                            id="IssuerCommunication" name="IssuerCommunication">
                                                        <option selected disabled>Select</option>
                                                        <option value="I wish to continue to receive an annual report" style="font-size: 12px;"
                                                            {{ isset($IssuerCommunication) && $IssuerCommunication == 'I wish to continue to receive an annual report' ? 'selected' : '' }}>
                                                            I wish to continue to receive an annual report</option>
                                                        <option value="I do not wish to receive an report" style="font-size: 12px;"
                                                            {{ isset($IssuerCommunication) && $IssuerCommunication == 'I do not wish to receive an report' ? 'selected' : '' }}>
                                                            I do not wish to receive an report</option>
                                                        <option value="Summary financial statement for Securities" style="font-size: 12px;"
                                                            {{ isset($IssuerCommunication) && $IssuerCommunication == 'Summary financial statement for Securities' ? 'selected' : '' }}>
                                                            Summary financial statement for Securities</option>
                                                        {{-- <option value="Electronic communication" style="font-size: 12px;"
                                                            {{ isset($IssuerCommunication) && $IssuerCommunication == 'Electronic communication' ? 'selected' : '' }}>
                                                            Electronic communication</option> --}}
                                                        </select>

                                                        {{--  <select class="form-select" autocomplete="off"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;"
                                                            id="IssuerCommunication" name="IssuerCommunication">
                                                            <option value="" selected="" disabled="">
                                                                Select A
                                                                Response
                                                            </option>
                                                            <option value="" selected="" disabled="">
                                                                {{ $IssuerCommunication }}</option>
                                                            <option value="Continue To Recieve Anual Reports">
                                                                I
                                                                wish to continue to receive an anual
                                                                report.
                                                            </option>
                                                            <option value="Don Not Recieve Anual Reports">I
                                                                do
                                                                not wish to recieve any reports.
                                                            </option>
                                                            <option value="Security Summary Financial Statement">
                                                                Summary financial statements for
                                                                Securities.
                                                            </option>
                                                            <option value="Electronic Communication">I
                                                                wish
                                                                to
                                                                recieve electronic communication.
                                                            </option>
                                                        </select>  --}}

                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">
                                                            Communication Type:
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">

                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;font-size: 12px;"
                                                            id="CommunicationType" name="CommunicationType">

                                                            <option selected disabled>Select</option>
                                                            <option value="Electronic" style="font-size: 12px;"
                                                                {{ isset($CommunicationType) && $CommunicationType == 'Electronic' ? 'selected' : '' }}>
                                                                Electronic</option>
                                                            <option value="Post" style="font-size: 12px;"
                                                                {{ isset($CommunicationType) && $CommunicationType == 'Post' ? 'selected' : '' }}>
                                                                Post</option>
                                                        </select>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Custody
                                                            Service Selection:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">

                                                    <div class="mb-3">

                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;font-size: 12px;"
                                                            id="CustodyService" name="CustodyService">
                                                        <option selected disabled>Select</option>
                                                        <option value="Securities held on my behalf must be register" style="font-size: 12px;"
                                                            {{ isset($CustodyService) && $CustodyService == 'Securities held on my behalf must be register' ? 'selected' : '' }}>
                                                            Securities must be registered in my own name and maintained by ComputerShare's Deal Routing Service.</option>
                                                        <option value="Securities must be registered in my Own Name" style="font-size: 12px;"
                                                            {{ isset($CustodyService) && $CustodyService == 'Securities must be registered in my Own Name' ? 'selected' : '' }}>
                                                            Securities must be registered in my own name and maintained by ComputerShare utilizing my own broker.</option>
                                                        </select>

                                                        {{--  <select class="form-select" autocomplete="off"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;"
                                                            id="CustodyService" name="CustodyService">
                                                            <option value="" selected disabled>Select A
                                                                Response
                                                            </option>
                                                            <option value="" selected="" disabled="">
                                                                {{ $CustodyService }}</option>
                                                            <option value="Securities Regarded">
                                                                Securities
                                                                held
                                                                on my behalf must be regarded.</option>
                                                            <option value="Securities In My Own Name">
                                                                Securities
                                                                must be registered in my own name.
                                                            </option>
                                                        </select>  --}}

                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Segregated
                                                            Depository Accounts:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">

                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;font-size: 12px;"
                                                            id="SegregatedDeposit" name="SegregatedDeposit">
                                                        <option selected disabled>Select</option>
                                                        <option value="Confirm SDA" style="font-size: 12px;"
                                                                {{ isset($SegregatedDeposit) && $SegregatedDeposit == 'Confirm SDA' ? 'selected' : '' }}>
                                                                I confirm that I would like to open a SDA Strate.</option>
                                                            <option value="Do not confirm SDA" style="font-size: 12px;"
                                                                {{ isset($SegregatedDeposit) && $SegregatedDeposit == 'Do not confirm SDA' ? 'selected' : '' }}>
                                                                I confirm that I would not like to open a SDA Strate.</option>
                                                        </select>

                                                        {{--  <select class="form-select" autocomplete="off"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;"
                                                            id="SegregatedDeposit" name="SegregatedDeposit">
                                                            <option value="" selected disabled>Select A
                                                                Response
                                                            </option>
                                                            <option value="" selected="" disabled="">
                                                                {{ $SegregatedDeposit }}</option>
                                                            <option value="Confirmation of SDA">
                                                                Confirmation
                                                                of
                                                                SDA</option>
                                                            <option value="Do Not Confirm to SDA">Do Not Confirm to SDA</option>
                                                        </select>  --}}

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12" id="newoptions1">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Broker:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">

                                                        <input type="text" id="Broker"
                                                            name="Broker" class="form-control input-sm"
                                                            value="{{ $Broker }}"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;font-size: 12px;"
                                                            placeholder="Enter Broker">

                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Broker Communication:</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">

                                                        <input type="text" id="BrokerContact"
                                                            name="BrokerContact" class="form-control input-sm"
                                                            value="{{ $BrokerContact }}"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;font-size: 12px;"
                                                            placeholder="Enter Broker Communication">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Are you
                                                            exempt or subject to a reduced rate of Dividend Tax?</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">

                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;font-size: 12px;"
                                                            id="DividendTax" name="DividendTax">
                                                        <option selected disabled>Select</option>
                                                        <option value=1 style="font-size: 12px;"
                                                            {{ isset($DividendTax) && $DividendTax == 1 ? 'selected' : '' }}>
                                                            YES</option>
                                                        <option value=0 style="font-size: 12px;"
                                                            {{ isset($DividendTax) && $DividendTax == 0 ? 'selected' : '' }}>
                                                            NO</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="mb-3">

                                                        <label for="basicpill-vatno-input" class="font-weight-bold"
                                                            style="font-size: 12px; color: rgb(0, 0, 0)">Do you want
                                                            to purchase BEE shares?</label>

                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="mb-3">

                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px;width:225px;padding-bottom: 3px;padding-top: 3px;font-size: 12px;"
                                                            id="BeeShareholder" name="BeeShareholder">
                                                        <option selected disabled>Select</option>
                                                        <option value=1 style="font-size: 12px;"
                                                                {{ isset($BeeShareholder) && $BeeShareholder == 1 ? 'selected' : '' }}>
                                                                YES</option>
                                                            <option value=0 style="font-size: 12px;"
                                                                {{ isset($BeeShareholder) && $BeeShareholder == 0 ? 'selected' : '' }}>
                                                                NO</option>
                                                        </select>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="row d-flex justify-content-center">

                                            <div class="col-lg-6">
                                                <div class="mb-5 mt-3">

                                                    <label for="basicpill-vatno-input" class="font-weight-bold"
                                                        style="font-size: 12px; color: rgb(0, 0, 0)">Stamp
                                                        Duty Reserve Tax - I/We confirm that I/We will not hold in the
                                                        Securities Account regarding any securities which would transfer
                                                        into the
                                                        Securities Account.
                                                    </label>

                                                    <div class="input-group mt-1">

                                                        <select class="form-select" autocomplete="off"
                                                            style="height: 27px;padding-bottom: 3px;padding-top: 3px;font-size: 12px;"
                                                            id="StampDuty" name="StampDuty">
                                                            <option selected>Select</option>
                                                            
                                                            <option value=1 style="font-size: 12px;"
                                                                {{ isset($StampDuty) && $StampDuty == 1 ? 'selected' : '' }}>
                                                                YES
                                                            </option>

                                                            <option value=0 style="font-size: 12px;"
                                                                {{ isset($StampDuty) && $StampDuty == 0 ? 'selected' : '' }}>
                                                                NO
                                                            </option>

                                                        </select>

                                                        {{--  <select class="form-select" autocomplete="off"
                                                            style="height: 27px;padding-bottom: 3px;padding-top: 3px;"
                                                            id="StampDuty" name="StampDuty" readonly>
                                                            <option value="" selected disabled>
                                                                {{ $StampDuty }}
                                                            </option>
                                                            <option value=1>Agree To Services</option>
                                                        </select>  --}}

                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">

                                            <div class="row justify-content-center">

                                                <div class="col-lg-1">
                                                    <button type="submit" id="formsave4"
                                                        class="btn btn-primary w-md"
                                                        style="background-color: rgb(0, 0, 0); border-color: rgb(0, 0, 0)">Save</button>
                                                </div>

                                                <div class="col-lg-1">
                                                    <button type="button" id="formedit4"
                                                        class="btn btn-primary w-md" onclick="formEdit()"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e">Edit</button>
                                                </div>

                                                <div class="col-lg-1">
                                                    <button type="button" id="formcancel4"
                                                        class="btn btn-primary w-md" onclick="formCancel()"
                                                        style="background-color: #1a4f6e; border-color: #1a4f6e">Cancel</button>
                                                </div>

                                                {{-- <div class="col-lg-1">
                                                    <a onclick="topFunction()">
                                                        <button type="button" class="btn btn-primary w-md"
                                                            style="background-color: #1a4f6e; border-color: #1a4f6e">
                                                            Back to Top
                                                        </button>
                                                    </a>
                                                </div> --}}

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>

                </div>{{-- END OF TAB 5 --}}

                <div class="tab-pane" id="tab6" role="tabpanel">

                    <div class="row d-flex justify-content-center">

                        <div class="col-sm-4">
                            <div class="card" id="card"
                                style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary"
                                                style="background-color: #52bdee; background-image: linear-gradient(315deg, #52bdee 0%, #52bdee 74%);">
                                                <i class="mdi mdi-account-details font-size-24"
                                                    style="color: rgb(0, 0, 0);"></i>
                                            </span>
                                        </div>
                                        <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">
                                            Identity Document
                                        </h3>
                                    </div>
                                    <div class="mt-4">
                                        <a href="#" class="button">
                                            <button type="submit" class="btn btn-primary w-md"
                                                onclick=" window.open('{{ $IDDoc }}')"
                                                style="background-color: rgb(0, 0, 0); border-color: #1a4f6e; background-color: #1a4f6e">View</button>
                                        </a>
                                    </div>
                                    {{-- <div class="mt-4">
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-primary w-md"
                                                style="background-color: rgb(0, 0, 0); border-color: #1a4f6e; background-color: #1a4f6e">View</button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="card" id="card"
                                style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary"
                                                style="background-color: #52bdee; background-image: linear-gradient(315deg, #52bdee 0%, #52bdee 74%);">
                                                <i class="mdi mdi-home font-size-24"
                                                    style="color: rgb(0, 0, 0);"></i>
                                            </span>
                                        </div>
                                        <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">
                                            Proof of Address Document
                                        </h3>
                                    </div>
                                    <div class="mt-4">
                                        <a href="#" class="button">
                                            <button type="submit" class="btn btn-primary w-md"
                                                onclick=" window.open('{{ $AddressDoc }}')"
                                                style="background-color: rgb(0, 0, 0); border-color: #1a4f6e; background-color: #1a4f6e">View</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="card" id="card"
                                style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title rounded-circle bg-primary bg-soft text-primary"
                                                style="background-color: #52bdee; background-image: linear-gradient(315deg, #52bdee 0%, #52bdee 74%);">
                                                <i class="mdi mdi-bank font-size-24"
                                                    style="color: rgb(0, 0, 0);"></i>
                                            </span>
                                        </div>
                                        <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">
                                            Proof of Banking Document
                                        </h3>
                                    </div>
                                    <div class="mt-4">
                                        <a href="#" class="button">
                                            <button type="submit" class="btn btn-primary w-md"
                                                onclick=" window.open('{{ $BankDoc }}')"
                                                style="background-color: rgb(0, 0, 0); border-color: #1a4f6e; background-color: #1a4f6e">View</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>{{-- END OF TAB 6 --}}

            </div>

        </div>
    </div>

@endsection

@section('script')

    <script>
        document.getElementById("formsave1").style.display = "none";
        document.getElementById("formsave2").style.display = "none";
        document.getElementById("formsave3").style.display = "none";
        document.getElementById("formsave4").style.display = "none";


        document.getElementById("formcancel1").style.display = "none";
        document.getElementById("formcancel2").style.display = "none";
        document.getElementById("formcancel3").style.display = "none";
        document.getElementById("formcancel4").style.display = "none";


        document.getElementById("cardarea1").style.pointerEvents = "none";
        document.getElementById("cardarea2").style.pointerEvents = "none";
        document.getElementById("cardarea3").style.pointerEvents = "none";
        document.getElementById("cardarea4").style.pointerEvents = "none";
        document.getElementById("cardarea5").style.pointerEvents = "none";
        document.getElementById("cardarea6").style.pointerEvents = "none";
        document.getElementById("cardarea7").style.pointerEvents = "none";
        document.getElementById("cardarea8").style.pointerEvents = "none";
        document.getElementById("cardarea9").style.pointerEvents = "none";
    </script>

    <script>
        document.getElementById("formedit1").addEventListener("click", formEdit1);

        function formEdit1() {

            document.getElementById("formsave1").style.display = "block";
            document.getElementById("formcancel1").style.display = "block";
            document.getElementById("formedit1").style.display = "none";

            document.getElementById("cardarea1").style.pointerEvents = "visible";
            document.getElementById("cardarea2").style.pointerEvents = "visible";
            document.getElementById("cardarea3").style.pointerEvents = "visible";

        }
    </script>

    <script>
        document.getElementById("formcancel1").addEventListener("click", formCancel1);

        function formCancel1() {

            document.getElementById("formsave1").style.display = "none";
            document.getElementById("formcancel1").style.display = "none";
            document.getElementById("formedit1").style.display = "block";

            document.getElementById("cardarea1").style.pointerEvents = "none";
            document.getElementById("cardarea2").style.pointerEvents = "none";
            document.getElementById("cardarea3").style.pointerEvents = "none";

        };
    </script>

    <script>
        document.getElementById("formedit2").addEventListener("click", formEdit1);

        function formEdit1() {

            document.getElementById("formsave2").style.display = "block";
            document.getElementById("formcancel2").style.display = "block";
            document.getElementById("formedit2").style.display = "none";

            document.getElementById("cardarea4").style.pointerEvents = "visible";
            document.getElementById("cardarea5").style.pointerEvents = "visible";
            document.getElementById("cardarea6").style.pointerEvents = "visible";

        }
    </script>

    <script>
        document.getElementById("formcancel2").addEventListener("click", formCancel1);

        function formCancel1() {

            document.getElementById("formsave2").style.display = "none";
            document.getElementById("formcancel2").style.display = "none";
            document.getElementById("formedit2").style.display = "block";

            document.getElementById("cardarea4").style.pointerEvents = "none";
            document.getElementById("cardarea5").style.pointerEvents = "none";
            document.getElementById("cardarea6").style.pointerEvents = "none";

        };
    </script>

    <script>
        document.getElementById("formedit3").addEventListener("click", formEdit1);

        function formEdit1() {

            document.getElementById("formsave3").style.display = "block";
            document.getElementById("formcancel3").style.display = "block";
            document.getElementById("formedit3").style.display = "none";

            document.getElementById("cardarea7").style.pointerEvents = "visible";
            document.getElementById("cardarea8").style.pointerEvents = "visible";

        }
    </script>

    <script>
        document.getElementById("formcancel3").addEventListener("click", formCancel1);

        function formCancel1() {

            document.getElementById("formsave3").style.display = "none";
            document.getElementById("formcancel3").style.display = "none";
            document.getElementById("formedit3").style.display = "block";

            document.getElementById("cardarea7").style.pointerEvents = "none";
            document.getElementById("cardarea8").style.pointerEvents = "none";

        };
    </script>

    <script>
        document.getElementById("formedit4").addEventListener("click", formEdit1);

        function formEdit1() {

            document.getElementById("formsave4").style.display = "block";
            document.getElementById("formcancel4").style.display = "block";
            document.getElementById("formedit4").style.display = "none";


            document.getElementById("cardarea9").style.pointerEvents = "visible";

        }
    </script>

    <script>
        document.getElementById("formcancel4").addEventListener("click", formCancel1);

        function formCancel1() {

            document.getElementById("formsave4").style.display = "none";
            document.getElementById("formcancel4").style.display = "none";
            document.getElementById("formedit4").style.display = "block";

            document.getElementById("cardarea9").style.pointerEvents = "none";

        };
    </script>

    <script>
        function selectOnlyThis(id) {
            for (var i = 1; i <= 2; i++) {
                document.getElementById("check" + i).checked = false;
            }
            document.getElementById(id).checked = true;
        }
    </script>

    <script>
        document.getElementById("options1").style.display = "none";

        document.getElementById('Public_official').addEventListener('change', function() {
            var style = this.value == 1 ? 'block' : 'none';
            document.getElementById('options1').style.display = style;
        });
    </script>

    <script>
        document.getElementById("options2").style.display = "none";

        document.getElementById('Public_official_Family').addEventListener('change', function() {
            var style = this.value == 1 ? 'block' : 'none';
            document.getElementById('options2').style.display = style;
        });
    </script>

    

    {{-- <script>
        document.getElementById("newoptions1").style.display = "none";
        // document.getElementById("newoptions2").style.display = "none";
        // document.getElementById("newoptions3").style.display = "none";
        // document.getElementById("newoptions4").style.display = "none";

        document.getElementById('CustodyService').addEventListener('change', function() {
            var style = this.value == "Securities must be registered in my Own Name" ? 'block' : 'none';
            document.getElementById("newoptions1").style.display = style;
            // document.getElementById("newoptions2").style.display = style;
            // document.getElementById("newoptions3").style.display = style;
            // document.getElementById("newoptions4").style.display = style;
        });
    </script> --}}

    <script>
        //Get the button:
        mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>

    <script type="text/javascript">  
        function generate() {  
            var doc = new jsPDF('p', 'pt', 'letter');

            var SancData = [];
            var SancList = {!! json_encode($FetchComplianceSanct) !!};

            var AddData = [];
            var AddList = {!! json_encode($FetchComplianceAdd) !!};

            {{--  console.log(SancList);  --}}

            var kyc = ({{ $KYC_Status }} == 1) ? 'Passed' : 'Failed';
            var avs = ({{ $AVS_Status }} == 1) ? 'Passed' : 'Failed';
            var taxObl = ({{ $Tax_Oblig_outside_SA }} == 1) ? 'Yes' : 'No';
            var acc = ({{ $BankTypeid }} == 1) ? 'Passed' : 'Failed';
            var pubOff = ({{ $Public_official }} == 1) ? 'Yes' : 'No';
            var pubOffFam = ({{ $Public_official_Family }} == 1) ? 'Yes' : 'No';
            var sanc = ({{ $SanctionList }} == 1) ? 'Yes' : 'No';
            var advs = ({{ $AdverseMedia }} == 1) ? 'Yes' : 'No';
            var nonRes = ({{ $NonResidentOther }} == 1) ? 'Yes' : 'No';
            var divTax = ({{ $DividendTax }} == 1) ? 'Yes' : 'No';
            var bee = ({{ $BeeShareholder }} == 1) ? 'Yes' : 'No';
            var stamp = ({{ $StampDuty }} == 1) ? 'Yes' : 'No';

            // var title = isset($TitleDesc) ? $TitleDesc : null;

            var htmlstring = '';  
            var tempVarToCheckPageHeight = 0;  
            var pageHeight = 0;
            {{--  const date = new Date();  --}}

            var logo = 'data:image/png;base64,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ZCFtm4hV46DObWA0FopeFERBSSqXt7NWZjIW0rAayLzPmYFwjJGAclCW5gbGRPVJVRRFb2C72hzpHXjg2f10j4NdDNzyNctOOX3N6KrheCyuL6+sWr9CrKxmhQojQQQBJbCAAQhAQCygYA0IAeEgDMyCGTocyMbR5tG9R/KjLTvXbx2YOfTks0f2HmJzY2EUKYfmoGcI4XFsedhjgy5RYqjMXWKzwmZ5OFDL4iSJ4ml5cDZsj5xzyhtufNulN17BxyIQ3TlyUK5cQ4AYcUxj/AwBKAIIHMeAiAEI4Xme53me53me53me93OP4+eMtVZr7ZzjnDPGOOfVajUIgnd99U/y/Z377tz1yF2PTP/0SLM5G9sw/H/ag7dXTc+zDsC/+9m87/d+u7WdmcxMZprJpGmamRqj1ohoQClIWwMeVCy4ORPEAxXBY8898k/okSKeeFYUFQtF3MQmpiS1SUgzzexnbWatb/u+z/Pct2utNLSW0YywYAXW77p8c/7sxmS693B7G7DVQTNYXRGBZv1gueu9r+sYffRWutymAznNd4dyyMSjlNLmNucul1Tc8O7kzoN37rbopmlvoYsSS6h8PW5WVlbW19cHg4GIqCoA51yM0czkiKouFov9/f35fL58O3sJQZ1kxIyIahCazeonbvutNhcUDRYa54dSN7GRsLp171ZVRd/EHG0RbOrKvJ66evmV3/3tJ68/c/6nnsMFt9Ayme0P+2F86SKIiIiIiIiIiOixBZwy7kjOuZTivQcQj3y/LNd+cvxLL7zyhT98Zev17df/7l///R/++b03371//9bGyua5S+vS2f7W7vZsO8IN0PRXKlHTtl2Uqao6jxh80wtpmsOBGA5AtLIC9LyISyt6YFlclAu9s3CWNOeUd965Wbskw1mKnarmnM1MRObzuXMuHBGRlFK3WGQsNzBewXgwGqOOc3R7y+W0s+kyySioahXiODbocruzO8NdwD493tyZ793cu72Prnl689rLP/35X3n5uRev9VaSrFdWoQUyfO780kmAFxARERERERER0eMKOH1CCCJiR0QER6LHAl0RH7z1nh2+dO4XPv9rL+Vl/vuv/e133njr3771n9rmp/oXLq89VWVZ7s/7rcEJoCpZJTknVRWqqnqwbLNkTXneJivqnKtDROX3p/eKZYVGxNo13rmSTZGfHV8BkHPu5l3J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'
            var HomeAffPhoto = 'data:image/png;base64,{{ $ConsumerIDPhoto }}';
            var CapturedPhoto = 'data:image/png;base64,{{ $ConsumerCapturedPhoto }}';

            pageHeight = doc.internal.pageSize.height;  
            specialElementHandlers = {  
                // element with id of "bypass" - jQuery style selector  
                '#bypassme': function(element, renderer) {  
                    // true = "handled elsewhere, bypass text extraction"  
                    return true  
                }  
            };  
            margins = {  
                top: 100,  
                bottom: 40,  
                left: 20,  
                right: 20,  
                width: 700,
                height: 700,  
            };

            doc.addImage(logo, 'png', 430, 45, 120, 22);
            {{--  doc.addImage(HomeAffPhoto, 'png', 100, 50, 75, 75);  --}}
            {{--  doc.addImage(CapturedPhoto, 'png', 380, 75, 90, 110);  --}}

            doc.setFontSize(6);
            doc.text('Computershare Proprietary Limited', 450, 85);
            doc.text('Reg. no. 2000/006082/07', 475, 92);

            doc.setFontSize(8);
            {{--  doc.text('Inspirit Data Analytics Services(Pty) Ltd, an authorized agent of XDS, shall not be liable for any damage or loss, both directly or indirectly, as a result\nof the use of or the omission to use the statement made in response to the enquiry made herein or for any consequential / inconsequential damages, loss\nof profit or special damages arising out of the issuing of that statement or any use thereof. Copyright 2022 Inspirit Data Analytics Services(Pty) Ltd \n(Reg No: 2017653373) Powered by Xpert Decision Systems(XDS).', 295, 762, 'center');  --}}
            {{--  doc.text(`© ${new Date().getFullYear()} Inspirit Data Analytics Services(Pty) Ltd, an authorized agent of XDS, All Rights Reserved.`, 295, 1362, 'center');  --}}

            {{--  doc.text(`Date of Report:  ${new Date().getDay()} / ${new Date().getMonth() + 1} / ${new Date().getFullYear()}`, 45, 55);  --}}
            {{--  doc.text(`Date of Report:        ${new Date().toLocaleDateString()}`, 45, 55);
            doc.text(`Extracted By:           {{ $LogUserName }} {{ $LogUserSurname }}`, 45, 70);
            doc.text(`Extracted For:          {{ $FirstName }} {{ $SURNAME }}`, 45, 85);
            doc.text(`Identity Number:      {{ $IDNUMBER }}`, 45, 100);  --}}

            doc.autoTable({
                body: [
                    [ 'Date of Report:', `${new Date().toLocaleDateString()}`],
                    [ 'Extracted By:', `{{ $LogUserName }} {{ $LogUserSurname }}`],
                    [ 'Extracted For:', `{{ $FirstName }} {{ $SURNAME }}`],
                    [ 'Identity Number:', `{{ $IDNUMBER }}`],
                ],
                startY: 45,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 75, fontStyle: 'bold' }, 1: { cellWidth: 75 }},
            });

            doc.autoTable({
                head: [['Personal Details', '', '', '']],
                body: [
                    ['Full Name(s):', '{{ $TitleDesc }} {{ $FirstName }} {{ $SecondName }} {{ $SURNAME }}','Gender', '{{ $Gender }}'],
                    ['Email:', '{{ $Email }}', 'Nationality:', '{{ $Nationality }}'],
                    ['Telephone (W):', '{{ $WorkNumberCode }}{{ $WorkNumber }}', 'Telephone (H):', '{{ $HomeNumberCode }}{{ $HomeNumber }}'],
                    ['Telephone (C):', '{{ $CellNumberCode }}{{ $CellNumber }}','Date of Birth:', '{{ $BirthDate }}'],
                    ['ID Date of Issue:', '{{ $ID_DateofIssue }}','Country of Birth:', '{{ $ID_CountryResidence }}'],
                    ['Employment Industry:', '{{ $Industryofoccupation }}','Employment Status:', '{{ $Employmentstatus }}'],
                    ['Name Of Employer:', '{{ $Nameofemployer }}'],
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 100, fontStyle: 'bold' }, 1: { cellWidth: 140 }, 2: { cellWidth: 100, fontStyle: 'bold' }, 3: { cellWidth: 190 } },
                headStyles :{fillColor : [26, 79, 110], textColor: [255, 255, 255]},
            });

            doc.autoTable({
                head: [['Address Details', '']],
                body: [
                    ['Residential Address:', '{{ $Res_OriginalAdd1 }}, {{ $Res_OriginalAdd2 }}, {{ $Res_OriginalAdd3 }}, {{ $Res_Pcode }}, {{ $ResProvince }}', '', ''],
                    ['Postal Address:', '{{ $Post_OriginalAdd1 }}, {{ $Post_OriginalAdd2 }}, {{ $Post_OriginalAdd3 }}, {{ $Post_Pcode }}, {{ $PostProvince }}', '', ''],
                    ['Work Address:', '{{ $Work_OriginalAdd1 }}, {{ $Work_OriginalAdd2 }}, {{ $Work_OriginalAdd3 }}, {{ $Work_Pcode }}, {{ $WorkProvince }}', '', ''],
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 140, fontStyle: 'bold' }, 1: { cellWidth: 390 }},
                headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            });

            doc.autoTable({
                head: [['Bank Details', '', '', '']],
                body: [
                    ['Bank Name:', '{{ $Bank_name }}','Account Type:', '{{ $AccountType }}'],   
                    ['Branch Code:', '{{ $Branch_code }}','Account Holder:', '{{ $Account_name }}'],
                    ['Account Number:', '{{ $Account_no }}','AVS Status:', `${avs}`],
                    ['Account Exists:', '{{ $ACCOUNT_OPEN }}','Initials Match:', '{{ $INITIALS }}'],
                    ['Surname Match:', '{{ $SURNAME }}','ID Number Match:', '{{ $IDNUMBER }}'],
                    ['Email Address Match:', '{{ $Email }}','Tax References Match:', '{{ $Tax_Number }}'],
                    ['Income Tax Number:', '{{ $Tax_Number }}','Tax Obligations:', `${taxObl}`],

                    ['Account Type Match:', '{{ $ACCOUNT_OPEN }}','Account Dormant:', '{{ $ACCOUNTDORMANT }}'],
                    ['Account Open Three Months:', '{{ $ACCOUNTOPENFORATLEASTTHREEMONTHS }}','Account Accepts Debits:', '{{ $ACCOUNTACCEPTSDEBITS }}'],
                    ['Account Accepts Credits:', '{{ $ACCOUNTACCEPTSCREDITS }}','Account Issuer:', '{{ $Bank_name }}'],
                    ['Account Type Match:', `${acc}`],
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 150, fontStyle: 'bold' }, 1: { cellWidth: 120 }, 2: { cellWidth: 140, fontStyle: 'bold' }, 3: { cellWidth: 120 }},
                headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            });

            doc.autoTable({
                head: [['Screening', '', '', '']],
                body: [
                    ['Occupying prominent official position or perform public function? :', `${pubOff}`, 'Family occupying prominent official position or perform public function?:', `${pubOffFam}`],
                    ['Is a DPIP (Domestic Prominent Influential Person)? :', '{{ $Public_official_type_DPIP }}', 'Is a FPPO (Foreign Prominent Public Official)?:', '{{ $Public_official_type_FPPO }}'],
                    ['Family is a DPIP (Domestic Prominent Influential Person)? :', '{{ $Public_official_type_family_DPIP }}', 'Family is a FPPO (Foreign Prominent Public Official)?:', '{{ $Public_official_type_family_FPPO }}'],
                    ['On any sanction lists? :', `${sanc}`, 'Assoicated with adverse media:', `${advs}`],
                    ['Is a non-client resident? :', `${nonRes}`, '', ''],
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 150, fontStyle: 'bold' }, 1: { cellWidth: 120 }, 2: { cellWidth: 140, fontStyle: 'bold' }, 3: { cellWidth: 120 }},
                headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            });

            doc.autoTable({
                head: [['Other Details', '']],
                body: [
                    ['Client Due Diligence:', '{{ $ClientDueDiligence }}'],
                    ['Nominee Declaration:', '{{ $NomineeDeclaration }}'],
                    ['Issuer Communication Selection:', '{{ $IssuerCommunication }}'],
                    ['Custody Service Selection:', '{{ $CustodyService }}'],
                    ['Segregated Depository Accounts:', '{{ $SegregatedDeposit }}'],
                    ['Dividend Tax:', `${divTax}`],
                    ['BEE Shares:', `${bee}`],
                    ['Stamp Duty:', `${stamp}`],
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 150, fontStyle: 'bold' }, 1: { cellWidth: 380 }},
                headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            });

            doc.autoTable({
                head: [['Know Your Customer (KYC)', '', '']],
                body: [
                    ['KYC Result:', `${kyc}`, ''],
                    ['Total Sources Used:', '{{ $TotalSourcesUsed }}', ''],
                    ['KYC Status Desc:','{{ $KYCStatusDesc }}', ''],
                    ['Residential Address:', '{{ $ResidentialAddress }}',''],
                    ['ID Status:', '{{ $IDStatus }}', ''],
                    ['ID Status Description:', '{{ $IDStatusDesc }}', ''],
                    ['Sources Used:', '{{ $Sources }}', '']
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 150, fontStyle: 'bold' }, 1: { cellWidth: 270 }, 2: { cellWidth: 0 }},
                headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            });

            doc.autoTable({
                head: [['Bank Account Verification', '', '', '']],
                body: [
                    ['Account Dormant:', '{{ $ACCOUNTDORMANT }}', 'Account open for at least three months:', '{{ $ACCOUNTOPENFORATLEASTTHREEMONTHS }}'],
                    ['Account accepts debits:', '{{ $ACCOUNTACCEPTSDEBITS }}', 'Account accepts credits:', '{{ $ACCOUNTACCEPTSCREDITS }}'],
                    ['Account Issuer:', '{{ $Bank_name }}', 'Account Type Match:', `${acc}`],
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 150, fontStyle: 'bold' }, 1: { cellWidth: 120 }, 2: { cellWidth: 140, fontStyle: 'bold' }, 3: { cellWidth: 120 }},
                headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            });

            doc.autoTable({
                head: [['Facial Recognition Details', '', '']],
                body: [
                    ['Liveliness Detection:', '{{ $LivenessDetectionResult }}', ''],
                    ['ID Photo Matched:', '{{ $ConsumerIDPhotoMatch }}', ''],
                    ['Deceased Status:', '{{ $DeceasedStatus }}', ''],
                    ['Latitude:', 'Device Location Disabled/Denied', ''],
                    ['Longitude:', 'Device Location Disabled/Denied', '']
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 150, fontStyle: 'bold' }, 1: { cellWidth: 270 }, 2: { cellWidth: 0 }},
                headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            });

            doc.autoTable({
                head: [['Compliance Details', '']],
                body: [
                    ['Enquiry Date:', '{{ $EnquiryDate }}'],
                    ['Enquiry Input:', '{{ $EnquiryInput }}'],
                    ['Verified First Name:', '{{ $VerifFirstName }}'],
                    ['Verified Surame:', '{{ $VerifSurname }}'],
                    ['Verified Deceased Status:', '{{ $VerifDeseaStat }}'],
                    ['Verified Deceased Date:', '{{ $VerifDeseaDate }}'],
                    ['Verified Cause of Death:', '{{ $VerifDeathCause }}']
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 150, fontStyle: 'bold' }, 1: { cellWidth: 380 }},
                headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            });

            // doc.autoTable({
            //     body: [
            //         {{--  ['Home Affairs Photo:', 'data:image/png;base64,{{ $ConsumerIDPhoto }}'],  --}}
            //         {{--  ['Client Captured Photo:', 'data:image/png;base64,{{ $ConsumerCapturedPhoto }}'],  --}}
            //     ],
            //     startY: doc.lastAutoTable.finalY + 7,
            //     styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
            //     columnStyles: { 0: { cellWidth: 150, fontStyle: 'bold' }, 1: { cellWidth: 380 }},
            //     headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            // });

            // Client Captured Photos

            doc.text('Home Affairs Captured Photo', 148, 180);
            doc.text('Client Captured Photo', 352, 180);

            doc.addImage(HomeAffPhoto, 'png', 160, 190, 85, 120);
            doc.addImage(CapturedPhoto, 'png', 350, 190, 85, 120);
            // {{--  doc.addImage(CapturedPhoto, 'png', 485, 90, 85, 110);  --}}

            // {{--  doc.autoTable({
            //     head: [['Date Listed', 'Reason Listed', 'Ent. Type', 'Gender', 'Ent. Name', 'Ent. Score', 'Comments']],
            //     body: [
            //         ['', '', '', '', '', '', ''],
            //     ],
            //     startY: 540,
            //     styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
            //     columnStyles: { 0: { cellWidth: 60 }, 1: { cellWidth: 120 }, 2: { cellWidth: 60 }, 3: { cellWidth: 60 }, 4: { cellWidth: 70 }, 5: { cellWidth: 55 }, 6: { cellWidth: 120 }},
            //     headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            // });  --}}

            // {{--  bodyData = ['{{ $Additional_type }}', '{{ $Additional_value }}', '{{ $Additional_comment }}'];

            // bodyData.forEach((item, index) => {
            // console.log(`${index} : ${item}`);
            // });  --}}

            AddList.forEach((element, index) => {
        
                var temp = [
                    element.Additional_type,
                    element.Additional_value,
                    element.Additional_comment,
                ]
                AddData.push(temp)
            })
        
            console.log(AddData);

            doc.autoTable({
                head: [['Type', 'Value', 'Comment']],
                body: AddData,
                startY: doc.lastAutoTable.finalY + 190,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 150 }, 1: { cellWidth: 190 }, 2: { cellWidth: 190 }},
                headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            });

            SancList.forEach((element, index) => {
        
                var temp = [
                    element.ReasonListed,
                    element.date_listed,
                    element.Entity_type,
                    element.Gender,
                    element.Entityname,
                    element.BestNameScore,
                    element.Comments,
                ]
                SancData.push(temp)
                
            })
        
            console.log(SancData);

            doc.autoTable({
                head: [['Date Listed', 'Reason Listed', 'Entity Type', 'Gender', 'Entity Name', 'Entity Score', 'Comments']],
                body: SancData,
                startY: doc.lastAutoTable.finalY + 7,
                styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
                columnStyles: { 0: { cellWidth: 60 }, 1: { cellWidth: 60 }, 2: { cellWidth: 60 }, 3: { cellWidth: 40 }, 4: { cellWidth: 60 }, 5: { cellWidth: 55 }, 6: { cellWidth: 195 }},
                headStyles :{fillColor : [26, 79, 110], textColor : [255, 255, 255]},
            });


            // PAGE NUMBERING
            // Add Page number at bottom-right
            // Get the number of pages
            const pageCount = doc.internal.getNumberOfPages();
            
            // For each page, print the page number and the total pages
            for(var i = 1; i <= pageCount; i++) {
                // Go to page i
                doc.setPage(i);
                //Print Page 1 of 4 for example

                doc.setFontSize(7);
                doc.text('Page ' + String(i) + ' of ' + String(pageCount),614-20,800-30,null,null,"right");
                doc.text('Inspirit Data Analytics Services(Pty) Ltd, an authorized agent of XDS, shall not be liable for any damage or loss, both directly or indirectly, as a result\nof the use of or the omission to use the statement made in response to the enquiry made herein or for any consequential / inconsequential damages, loss\nof profit or special damages arising out of the issuing of that statement or any use thereof. Copyright 2022 Inspirit Data Analytics Services(Pty) Ltd \n(Reg No: 2017653373) Powered by Xpert Decision Systems(XDS).', 295, 762, 'center');

            }  

            doc.save('{{ $FirstName }} {{ $SURNAME }} - Information Report.pdf');  
        }  
    </script>

    <script>
        window.onload = function() {

        var getPub = document.getElementById("Public_official");
        var showPub = getPub.value;

        if (showPub == 1) {
            document.getElementById("options1").style.display = "block";
        } 
        else {
            document.getElementById("options1").style.display = "none"; 
        }

        console.log(showPub);

        var getPubFam = document.getElementById("Public_official_Family");
        var showPubFam = getPubFam.value;

        if (showPubFam == 1) {
            document.getElementById("options2").style.display = "block";
        } 
        else {
            document.getElementById("options2").style.display = "none";
        }

        console.log(showPubFam);

        };
    </script>

    <script>
        window.onload = function() {

        var getNom = document.getElementById("NomineeDeclaration");
        var showNom = getNom.value;

        if (showNom == 'Securities held on my behalf must be register') {
            document.getElementById("newoptions1").style.display = "none";
        } 
        else {
            document.getElementById("newoptions1").style.display = "block"; 
        }

        console.log(showPub);
        console.log(showPubFam);

        };
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>


@endsection
