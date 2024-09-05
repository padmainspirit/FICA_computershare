@extends('layouts.master-display')

@section('css')
<style>
    .nav-link {
        display: inline-block !important;
        border-top: 2px solid #7393b3 !important;
        border-bottom: 2px solid #7393b3 !important;
        border-left: 2px solid #7393b3 !important;
        border-right: 2px solid #7393b3 !important;
        padding: 5px 10px !important;
        text-decoration: none !important;
        color: black;

    }

    .nav-link:hover {
        background-color: rgb(163, 149, 149) !important;
        color: rgb(29, 28, 28) !important;
    }

    td.one {
        vertical-align: bottom;
        font-weight: bold;
        color: #1a4f6e
    }

    td.two {
        vertical-align: bottom;
        color: black
    }

    th {
        text-align: left;
        background-color: rgb(4, 4, 4);
        font-size: 15px
    }

    h2.b {
        visibility: hidden;
    }

    .card {
        background-color: #E8E8E8;
        border: 10px solid blue;
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
        /* height: 5%; */
        background-image: linear-gradient(#93186c, #93186c);
        color: white;
    }
</style>
@endsection


@section('content')

<?php
ini_set('memory_limit', '1024M');
?>

<div class="main-content" style="margin-left: 0px;">

    <div class="page-content" style="padding-bottom: 0px;padding-right: 0px;padding-top: 0px;padding-left: 0px;">


        <div class="row">

            <div class="col-md-9"></div>

            <div class="col-md-3">

                <ol class="breadcrumb" style="margin-bottom: 0px;padding-right: 0px;padding-top: 0px;padding-left: 82px;">
                    <li class="breadcrumb-item"><a type="button" onclick="window.history.back()">Previous</a></li>
                    <li class="breadcrumb-item text-decoration-underline" style="font-weight: 500"><a href="javascript: void(0);">Self banking</a></li>
                </ol>

            </div>
        </div>

        <!-- Nav tabs -->
        <div class="heading-fica-id">
            <div class="text-center">
                <h5 style="color: #fff; padding-top:8px;padding-bottom: 8px;padding-left: 11px;">
                    Due Diligence Results
                </h5>
            </div>
        </div>


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

                                @if (-1 != NULL) <!-- ($Identity_status == 1) -->
                                <h6 class="card-title" style="text-align: center;">
                                    <i class="bx bx-check-circle  bx-md" style="color: #028E41"></i>
                                </h6>
                                @elseif (-1 == NULL) <!-- ($Identity_status == 0) -->
                                <h6 class="card-title" style="text-align: center;">
                                    <i class="bx bx-x-circle  bx-md" style="color: #E0474C"></i>
                                </h6>
                                @else
                                <h6 class="card-title" style="text-align: center;">
                                    <i class="dripicons-question  bx-sm" style="color: #FFA500"></i>
                                </h6>
                                @endif

                                <div class="form-floating mb-3">
                                    <img src="/images/results/client1.png" alt="" height="100" width="100" class="auth-logo-light" style="display: block; margin: auto">
                                </div>

                                <div class="mb-2"></div>


                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>


                    <?php if (1 == 1) { ?>
                        <div class="col-sm-2">
                            <div class="card" style="width: 100%;">
                                <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                    <h5 class="card-title" style="text-align: center;">Banking Details</h5>

                                    @if (1 == 1)
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="bx bx-check-circle  bx-md" style="color: #028E41"></i>
                                    </h6>
                                    @elseif (1 == 0)
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="bx bx-x-circle  bx-md" style="color: #E0474C"></i>
                                    </h6>
                                    @else
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="dripicons-question  bx-sm" style="color: #FFA500"></i>
                                    </h6>
                                    @endif

                                    <div class="form-floating mb-3">
                                        <img src="/images/results/AVS.png" alt="" height="100" width="100" class="auth-logo-light" style="display: block; margin: auto">
                                    </div>

                                    <div class="mb-2"></div>

                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    <?php } ?>

                    <?php if (-1 == 1) { ?>
                        <div class="col-sm-2">
                            <div class="card" style="width: 100%;">
                                <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                    <h5 class="card-title" style="text-align: center;">Banking Details</h5>

                                    @if (-1 == 1)
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="bx bx-check-circle  bx-md" style="color: #028E41"></i>
                                    </h6>
                                    @elseif (-1 == 0)
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="bx bx-x-circle  bx-md" style="color: #E0474C"></i>
                                    </h6>
                                    @else
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="dripicons-question  bx-sm" style="color: #FFA500"></i>
                                    </h6>
                                    @endif

                                    <div class="form-floating mb-3">
                                        <img src="/images/results/AVS.png" alt="" height="100" width="100" class="auth-logo-light" style="display: block; margin: auto">
                                    </div>

                                    <div class="mb-2"></div>

                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    <?php } ?>


                        <div class="col-sm-2">
                            <div class="card" style="width: 100%;">
                                <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                    <h5 class="card-title" style="text-align: center;">
                                        Face view</h5>
                                    @if(-1 == -1)
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="dripicons-question  bx-sm" style="color: #FFA500"></i>
                                    </h6>
                                    @elseif (-1 == 'Matched')
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="bx bx-check-circle  bx-md" style="color: #028E41"></i>
                                    </h6>
                                    @else
                                    <h6 class="card-title" style="text-align: center;">
                                        <i class="bx bx-x-circle  bx-md" style="color: #E0474C"></i>
                                    </h6>
                                    @endif

                                    <div class="form-floating mb-3">
                                        <img src="/images/results/facephone4.png" alt="" height="100" width="100" class="auth-logo-light" style="display: block; margin: auto">
                                    </div>

                                    <div class="mb-2"></div>

                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->






                </div>


                <div class="row">

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body" style="padding-top: 0px;">
                                <br>

                                <div class="row">
                                    <div class="col-md-3 ">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link mb-2 active" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">User Input</a>

                                                <a class="nav-link mb-2" id="v-pills-banking-tab" data-bs-toggle="pill" href="#v-pills-banking" role="tab" aria-controls="v-pills-banking" aria-selected="false">Bank
                                                    Account Verification</a>



                                                <a class="nav-link mb-2" id="v-pills-faceview-tab" data-bs-toggle="pill" href="#v-pills-faceview" role="tab" aria-controls="v-pills-faceview" aria-selected="false">Face View</a>


                                        </div>

                                        <div class="row justify-content-center">
                                            <button type="button" id="newpdf" name="newpdf" onclick="generate()" class="btn btn-rounded waves-effect waves-light mt-3 text-white font-size-14" style="background-color: rgb(193, 22, 28); width: 120px;padding-top: 0px;
                                                padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                                Export to PDF
                                            </button>
                                        </div>
                                        <br>
                                        <div>
                                            <span> <img style="height:20px;width:20px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt=""> - Verified - external sources.</span> <br><br>
                                            <span><img style="height:20px;width:20px;position:relative; top:-3px;" src="assets/images/redcircle.png" alt=""> - Not verified - external sources.</span><br><br>
                                            <span> <img style="height:20px;width:20px;position:relative; top:-3px;" src="assets/images/small/tick.png" alt=""> - Verification successful.</span> <br><br>
                                            <span><img style="height:20px;width:20px;position:relative; top:-3px;" src="assets/images/small/cross.png" alt=""> - Verification unsuccessful.</span><br><br>
                                            <span><img style="height:20px;width:20px;position:relative; top:-3px;" src="assets/images/question.png" alt=""> - No response from the source.</span><br><br>

                                        </div>
                                    </div>

                                    <div class="col-md-9">

                                        <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

                                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                                                <!-- Profile Details -->

                                                <section>



                                                    <div class="row">

                                                        <div class="col-md-12">

                                                            <div class="table-responsive">
                                                                <table class="table table-hover mb-0" id="downloadProfile">

                                                                    <thead>
                                                                        <tr>
                                                                            <th class="col-md-5 heading-fica-id" style="color:#ffffff;"></th>
                                                                            <th class="col-md-6 heading-fica-id" style="color:#ffffff;">User Input</th>
                                                                            <th class="col-md-1 heading-fica-id" style="color:#ffffff;padding-left: 0px;">Pass/Fail
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                First Name
                                                                            </td>
                                                                            <td>
                                                                                Fortune


                                                                            </td>

                                                                            <td>
                                                                                <?php

                                                                                    echo '<img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">';

                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Surname
                                                                            </td>
                                                                            <td>
                                                                          Ngwenya

                                                                            </td>

                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/redcircle.png" alt="">

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                ID Number
                                                                            </td>
                                                                            <td>
                                                                                9999999999999

                                                                            </td>

                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Email
                                                                            </td>
                                                                            <td>
                                                                                123@gmail

                                                                            </td>

                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">


                                                                            </td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Phone (H)
                                                                            </td>
                                                                            <td>
                                                                                072333445455

                                                                            </td>

                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">


                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Phone (C)
                                                                            </td>

                                                                            <td>
                                                                                08444444444


                                                                            </td>
                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">

                                                                            </td>

                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Phone (W)
                                                                            </td>
                                                                            <td>
                                                                                08233445555

                                                                            </td>
                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Client Reference Number
                                                                            </td>
                                                                            <td>
                                                                                h13333
                                                                            </td>
                                                                            <td></td>
                                                                        </tr>



                                                                    </tbody>

                                                                </table>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </section>

                                            </div>

                                            <div class="tab-pane fade" id="v-pills-faceview" role="tabpanel" aria-labelledby="v-pills-faceview-tab">

                                                <section>


                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="table-responsive">
                                                                <table class="table table-hover mb-0" id="downloadFace">

                                                                    <thead>
                                                                        <tr>
                                                                            <th class="col-md-5 heading-fica-id" style="color:#ffffff;">Face View Details</th>
                                                                            <th class="col-md-6 heading-fica-id" style="color:#ffffff;">Result</th>
                                                                            <th class="col-md-1 heading-fica-id" style="color:#ffffff;padding-left: 0px;">
                                                                                Pass/Fail</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                ID No. Status
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">

                                                                            </td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Home Affairs Names
                                                                            </td>
                                                                            <td>
                                                                                Fortune

                                                                            </td>

                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">


                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Home Affairs Surname
                                                                            </td>
                                                                            <td>
                                                                                Ngwenya

                                                                            </td>
                                                                            <td>
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">



                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Home Affairs Gender
                                                                            </td>
                                                                            <td>
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Home Affairs DOB
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                ID Number Blocked
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Home Affairs Birth Place
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Deceased Status
                                                                            </td>
                                                                            <td>

                                                                                Alive

                                                                            </td>
                                                                            <td>
                                                                                {{-- @if ($DeceasedStatus == 'Alive')
                                                                                        <i class="fa fa-circle"
                                                                                            style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @elseif ($DeceasedStatus == "Deceased")
                                                                                        <i class="fa fa-circle"
                                                                                            style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                            </td>
                                                                        </tr>

                                                                        <td style="font-weight: bold;">
                                                                            Deceased Date
                                                                        </td>
                                                                        <td>

                                                                        </td>
                                                                        <td></td>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Marital Status
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Marriage Date
                                                                            </td>
                                                                            <td>


                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Green Book ID Date of Issue
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Smart ID Card Date of Issue
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Enquiry Reference
                                                                            </td>
                                                                            <td>
                                                                                H32222

                                                                            </td>
                                                                            <td>

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
                                                                                <img align="middle" src="" alt="" height="20%" width="20%" class="auth-logo-light" style="margin-left: 140px;">
                                                                                </img>

                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </section>
                                            </div>



                                            <div class="tab-pane fade" id="v-pills-banking" role="tabpanel" aria-labelledby="v-pills-banking-tab">

                                                <section>

                                                    <div class="row">

                                                        <div class="col-md-12">

                                                            <div class="table-responsive">
                                                                <table class="table table-hover mb-0" id="downloadBank">

                                                                    <thead>
                                                                        <tr>
                                                                            <th class="col-md-4 heading-fica-id" style="color:#ffffff;">Bank Account Details</th>
                                                                            <th class="col-md-7 heading-fica-id" style="color:#ffffff;">Result</th>
                                                                            <th class="col-md-1 heading-fica-id" style="color:#ffffff;padding-left: 0px;">
                                                                                Pass/Fail</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account Holder
                                                                            </td>
                                                                            <td>
                                                                                F Ngwenya
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Bank Name
                                                                            </td>
                                                                            <td>
                                                                                Capitec
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account Number
                                                                            </td>
                                                                            <td>
                                                                                16522233
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Branch Code
                                                                            </td>
                                                                            <td>
                                                                                67777
                                                                            </td>
                                                                            <td>

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
                                                                            <i class="fa fa-circle" style="font-size: 24px; color: green;"></i>
                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                            @else
                                                                            <i class="fa fa-circle" style="font-size: 24px; color: red;"></i>
                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                            @endif
                                                                        </td>
                                                                        </tr> --}}
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                AVS Status
                                                                            </td>
                                                                            <td>

                                                                                AVS Completed

                                                                            </td>
                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account Exists
                                                                            </td>
                                                                            <td>
                                                                                Yes
                                                                            </td>
                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Initials Match
                                                                            </td>
                                                                            <td>
                                                                                F
                                                                            </td>
                                                                            <td>

                                                                                <?php

                                                                                    echo '<img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">';


                                                                                ?>


                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Surname Match
                                                                            </td>
                                                                            <td>
                                                                                Ngwenya
                                                                            </td>
                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                ID Number Match
                                                                            </td>
                                                                            <td>
                                                                                Yes
                                                                            </td>
                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Email Address Match
                                                                            </td>
                                                                            <td>
                                                                                Yes
                                                                            </td>
                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="assets/images/greencircle.png" alt="">

                                                                            </td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account Active
                                                                            </td>
                                                                            <td>
                                                                                Yes
                                                                            </td>
                                                                            <td>
                                                                                {{-- @if ($ACCOUNT_OPEN != null)
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account Dormant
                                                                            </td>
                                                                            <td>
                                                                                Not Available
                                                                            </td>
                                                                            <td>
                                                                                {{-- @if ($ACCOUNTDORMANT == 'Not Available')
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account open for at least three months
                                                                            </td>
                                                                            <td>
                                                                                Yes
                                                                            </td>
                                                                            <td>
                                                                                {{-- @if ($ACCOUNTOPENFORATLEASTTHREEMONTHS != 'No' and $ACCOUNTOPENFORATLEASTTHREEMONTHS != null)
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account accepts debits
                                                                            </td>
                                                                            <td>
                                                                                Yes
                                                                            </td>
                                                                            <td>
                                                                                {{-- @if ($ACCOUNTACCEPTSDEBITS == 'Yes')
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account Issuer
                                                                            </td>
                                                                            <td>
                                                                                Capitec
                                                                            </td>
                                                                            <td>
                                                                                {{-- @if ($Bank_name != null)
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: red;"></i>
                                                                                            <p style="color: red; text-transform: uppercase; display: none">FAIL</p>
                                                                                    @endif  --}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account Type Match
                                                                            </td>
                                                                            <td>

                                                                                Yes

                                                                            </td>
                                                                            <td>
                                                                                {{-- @if ($BankTypeid != null)
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: green;"></i>
                                                                                            <p style="color: green; text-transform: uppercase; display: none">PASS</p>
                                                                                    @else
                                                                                        <i class="fa fa-circle" style="font-size: 24px; color: red;"></i>
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
        </div>

    </div>

</div>


@endsection


@section('script')
{{--
<script>

    function generate() {
        var doc = new jsPDF('p', 'pt', 'letter');

        var SancData = [];
        var SancList = <?= json_encode($FetchComplianceSanct); ?>;
        var AddInfoList = <?= json_encode($FetchComplianceAdd); ?>;

        var date_listed = SancList.date_listed;
        var ReasonListed = SancList.ReasonListed;
        var Entity_type = SancList.Entity_type;
        var Gender = SancList.Gender;
        var Entityname = SancList.Entityname;
        var Comments = SancList.Comments;
        var BestNameScore = SancList.BestNameScore;

        var Additional_type = AddInfoList.Additional_type;
        var Additional_value = AddInfoList.Additional_value;
        var Additional_comment = AddInfoList.Additional_comment;


        if (typeof Additional_type === 'undefined')
            Additional_type = 'N/A';
        if (typeof Additional_value === 'undefined')
            Additional_value = 'N/A';
        if (typeof Additional_comment === 'undefined')
            Additional_comment = 'N/A';


        if (typeof date_listed === 'undefined')
            date_listed = 'N/A';
        if (typeof ReasonListed === 'undefined')
            ReasonListed = 'N/A';
        if (typeof Entity_type === "undefined")
            Entity_type = 'N/A';
        if (typeof Gender === "undefined")
            Gender = 'N/A';
        if (typeof Entityname === 'undefined')
            Entityname = 'N/A';
        if (typeof Comments === 'undefined')
            Comments = 'N/A';
        if (typeof BestNameScore === 'undefined')
            BestNameScore = 'N/A';


        console.log("best score" + BestNameScore);
        var AddData = [];
        var AddList = <?= json_encode($FetchComplianceAdd); ?>;

       // var personal = ("<?= $fica->ID_Status; ?>" != null) ? 'Passed' : 'Failed';
        var personal_Status = new Date('<?= $fica->ID_Status; ?>');
        var personal;
        if (personal_Status != null) {
            personal = 'Passed';
        } else if (personal_Status == null) {
            personal = 'Server Error';
        } else {
            personal = 'Failed';
        }
        //var kyc = ("<?= $KYC_Status; ?>" == 1) ? 'Passed' : 'Failed';
        var KYC_Status = "<?= $KYC_Status; ?>";
        var kyc;
        if (KYC_Status == 1) {
        kyc = 'Passed';
        } else if (KYC_Status == -1) {
        kyc = 'Server Error';
        } else {
        kyc = 'Failed';
        }
        //var avs = ("<?= $AVS_Status; ?>" == 1) ? 'Passed' : 'Failed';
        var avsStatus = "<?= $AVS_Status; ?>";
        var avs;
        if (avsStatus == 1) {
        avs = 'Passed';
        } else if (avsStatus == -1) {
        avs = 'Server Error';
        } else {
        avs = 'Failed';
        }

        var acc = ("<?= $BankTypeid; ?>" != null) ? 'Passed' : 'Failed';
        var comp = ("<?= $Compliance_Status; ?>" == 1) ? 'Passed' : 'Failed';


        var isFaceView = ("<?= $isFaceView; ?>" == 1) ? 'Yes' : 'No';
        var isFacial = "<?= ($fica->facial ? 'Yes' : 'No'); ?>";
        console.log(isFacial);

        var LogUserName = ("<?= $LogUserName; ?>" != null) ? "<?= $LogUserName; ?>" : '';
        var LogUserSurname = ("<?= $LogUserSurname; ?>" != null) ? "<?= $LogUserSurname; ?>" : '';
        var TitleDesc = ("<?= $TitleDesc; ?>" != null) ? "<?= $TitleDesc; ?>" : '';
        var FirstName = ("<?= $FirstName; ?>" != null) ? "<?= $FirstName; ?>" : '';
        var surname = ("<?= $SURNAME; ?>" != null) ? "<?= $SURNAME; ?>" : '';
        var Client_Ref = ("<?= $Client_Ref; ?>" != null) ? "<?= $Client_Ref; ?>" : '';



        var Email = ("<?= $Email; ?>" != null) ? "<?= $Email; ?>" : '';
        var Nationality = ("<?= $Nationality; ?>" != null) ? "<?= $Nationality; ?>" : '';
        var WorkTelCode = ("<?= $WorkTelCode; ?>" != null) ? "<?= $WorkTelCode; ?>" : '';
        var WorkTelNo = ("<?= $WorkTelNo; ?>" != null) ? "<?= $WorkTelNo; ?>" : '';
        var HomeTelCode = ("<?= $HomeTelCode; ?>" != null) ? "<?= $HomeTelCode; ?>" : '';
        var HomeTelNo = ("<?= $HomeTelNo; ?>" != null) ? "<?= $HomeTelNo; ?>" : '';
        var CellCode = ("<?= $CellCode; ?>" != null) ? "<?= $CellCode; ?>" : '';
        var CellNo = ("<?= $CellNo; ?>" != null) ? "<?= $CellNo; ?>" : '';
        var BirthDate = ("<?= $BirthDate; ?>" != null) ? "<?= $BirthDate; ?>" : '';
        var ID_DateofIssue = ("<?= $ID_DateofIssue; ?>" != null) ? "<?= $ID_DateofIssue; ?>" : '';
        var ID_CountryResidence = ("<?= $ID_CountryResidence; ?>" != null) ? "<?= $ID_CountryResidence; ?>" : '';

        var resadd1 = ("<?= $Res_OriginalAdd1; ?>" != null) ? "<?= $Res_OriginalAdd1; ?>" : '';
        var resadd2 = ("<?= $Res_OriginalAdd2; ?>" != null) ? "<?= $Res_OriginalAdd2; ?>" : '';
        var resadd3 = ("<?= $Res_OriginalAdd3; ?>" != null) ? "<?= $Res_OriginalAdd3; ?>" : '';
        var resprov = ("<?= $ResProvince; ?>" != null) ? "<?= $ResProvince; ?>" : '';
        var reszip = ("<?= $Res_Pcode; ?>" != null) ? "<?= $Res_Pcode; ?>" : '';



        var RefNumber = ("<?= $RefNumber; ?>" != null) ? "<?= $RefNumber; ?>" : '';
        var RiskStatus = ("<?= $RiskStatusbyFICA; ?>" != null) ? "<?= $RiskStatusbyFICA; ?>" : '';
        var customerName = ("<?= $customerName; ?>" != null) ? "<?= $customerName; ?>" : '';
        var modifiedCustomerName = customerName ? `${customerName.charAt(0)}-${RefNumber}` : '';

        var Bank_name = ("<?= $Bank_name; ?>" != null) ? "<?= $Bank_name; ?>" : '';
        //var AccountType = ("<?php // $AccountType;
                                ?>" != null) ? "<?php // $AccountType;
                                                ?>" : '';
        var Branch_code = ("<?= $Branch_code; ?>" != null) ? "<?= $Branch_code; ?>" : '';
        var Account_name = ("<?= $Account_name; ?>" != null) ? "<?= $Account_name; ?>" : '';
        var Account_no = ("<?= $Account_no; ?>" != null) ? "<?= $Account_no; ?>" : '';
        var accopen = ("<?= $ACCOUNT_OPEN; ?>" != null) ? "<?= $ACCOUNT_OPEN; ?>" : '';
        var initials = ("<?= $INITIALS; ?>" != null) ? "<?= $INITIALS; ?>" : '';
        var idnum = ("<?= $IDNUMBER; ?>" != null) ? "<?= $IDNUMBER; ?>" : '';

        var accdormant = ("<?= $ACCOUNTDORMANT; ?>" != null) ? "<?= $ACCOUNTDORMANT; ?>" : '';
        var accthreemonths = ("<?= $ACCOUNTOPENFORATLEASTTHREEMONTHS; ?>" != null) ? "<?= $ACCOUNTOPENFORATLEASTTHREEMONTHS; ?>" : '';
        var accdebit = ("<?= $ACCOUNTACCEPTSDEBITS; ?>" != null) ? "<?= $ACCOUNTACCEPTSDEBITS; ?>" : '';

        var Bank_name = ("<?= $Bank_name; ?>" != null) ? "<?= $Bank_name; ?>" : '';




        var TotalSourcesUsed = ("<?= $TotalSourcesUsed; ?>" != null) ? "<?= $TotalSourcesUsed; ?>" : '';
        var KYCStatusDesc = ("<?= $KYCStatusDesc; ?>" != null) ? "<?= $KYCStatusDesc; ?>" : '';
        var ResidentialAddress = ("<?= $ResidentialAddress; ?>" != null) ? "<?= $ResidentialAddress; ?>" : '';
        var IDStatus = ("<?= $IDStatus; ?>" != null) ? "<?= $IDStatus; ?>" : '';
        var IDStatusDesc = ("<?= $IDStatusDesc; ?>" != null) ? "<?= $IDStatusDesc; ?>" : '';
        var Sources = ("<?= $Sources; ?>" != null) ? "<?= $Sources; ?>" : '';


        var LivenessDetectionResult = ("<?= $LivenessDetectionResult; ?>" != null) ? "<?= $LivenessDetectionResult; ?>" : '';
        var ConsumerIDPhotoMatch = ("<?= $ConsumerIDPhotoMatch; ?>" != null) ? "<?= $ConsumerIDPhotoMatch; ?>" : '';
        var DeceasedStatus = ("<?= $DeceasedStatus; ?>" != null) ? "<?= $DeceasedStatus; ?>" : '';
        //
        var HA_Names = ("<?= $HA_Names; ?>" != null) ? "<?= $HA_Names; ?>" : '';
        var HA_Surname = ("<?= $HA_Surname; ?>" != null) ? "<?= $HA_Surname; ?>" : '';
        var HA_DeceasedDate = ("<?= $HA_DeceasedDate; ?>" != null) ? "<?= $HA_DeceasedDate; ?>" : '';
        var HA_Countryofbirth = ("<?= $HA_Countryofbirth; ?>" != null) ? "<?= $HA_Countryofbirth; ?>" : '';
        var HA_IDCardDate = ("<?= $HA_IDCardDate; ?>" != null) ? "<?= $HA_IDCardDate; ?>" : '';
        var HA_IDBookIssuedDate = ("<?= $HA_IDBookIssuedDate; ?>" != null) ? "<?= $HA_IDBookIssuedDate; ?>" : '';
        var HA_EnquiryReference = ("<?= $HA_EnquiryReference; ?>" != null) ? "<?= $HA_EnquiryReference; ?>" : '';
        var HA_DateOfBirth = ("<?= $HA_DateOfBirth; ?>" != null) ? "<?= $HA_DateOfBirth; ?>" : '';
        var HA_IDNumberBlocked = ("<?= $HA_IDNumberBlocked; ?>" != null) ? "<?= $HA_IDNumberBlocked; ?>" : '';
        var HA_Gender = ("<?= $HA_Gender; ?>" != null) ? "<?= $HA_Gender; ?>" : '';
        var HA_IDNOMatchStatus = ("<?= $HA_IDNOMatchStatus; ?>" != null) ? "<?= $HA_IDNOMatchStatus; ?>" : '';
        var HA_DeceasedStatus = ("<?= $HA_DeceasedStatus; ?>" != null) ? "<?= $HA_DeceasedStatus; ?>" : '';
        if (HA_DeceasedStatus =='Alive')
        {HA_DeceasedDate = "N/A";}
        var emailmatch = ("<?= $emailmatch; ?>" != null) ? "<?= $emailmatch; ?>" : '';
        var cellmatch = ("<?= $cellmatch; ?>" != null) ? "<?= $cellmatch; ?>" : '';
        var homematch = ("<?= $homematch; ?>" != null) ? "<?= $homematch; ?>" : '';
        var workmatch = ("<?= $workmatch; ?>" != null) ? "<?= $workmatch; ?>" : '';
        var AVS_Status = ("<?= $AVS_Status; ?>" != null) ? "<?= $AVS_Status; ?>" : '';
        var Account_name = ("<?= $Account_name; ?>" != null) ? "<?= $Account_name; ?>" : '';
        var EMAILMATCH = ("<?= $EMAILMATCH; ?>" != null) ? "<?= $EMAILMATCH; ?>" : '';
        var initialsmatch = ("<?= $INITIALSMATCH ?>" == 'Yes') ? 'Matched' : 'Unmatched';
        var EMAILMATCHstatus = ("<?= $EMAILMATCH ?>" == 'Yes') ? 'Matched' : 'Unmatched';


        //var INITIALS = ("<?= $INITIALS; ?>" != null) ? "<?= $INITIALS; ?>" : '';


        var name_match = 'Unmatched';
        var surname_match = 'Unmatched';
        var AVSStatusmatch = 'Unmatched';
        var IDNUMBERMATCH = ("<?= $IDNUMBERMATCH; ?>" != null) ? "<?= $IDNUMBERMATCH; ?>" : '';
        var idnummatch = 'Unmatched';


        var idas_firstname_match = ("<?= $idas_firstname_match; ?>");
        var surname_match = ("<?= $idas_surname_match; ?>");
        var name_match = idas_firstname_match

        var banksurnamematch = ("<?= $SURNAMEMATCH ?>" == 'Yes') ? 'Matched' : 'Unmatched';
        var idnummatch = ("<?= $IDNUMBERMATCH ?>" == 'Yes') ? 'Matched' : 'Unmatched';

        var fullnamesmatch = 'Unmatched';

        if (AVS_Status == 1) {
            AVSStatusmatch = 'Matched';
        }

        // {{ strtoupper($SURNAME) }},{{ ($HA_Surname) }}

        /* console.log(FirstName.toUpperCase());
        console.log(HA_Names.split(' ')[0]);

        if (FirstName.toUpperCase() == HA_Names.split(' ')[0]) {
            name_match = 'Matched';
        }
        if (surname.toUpperCase() == HA_Surname) {
            surname_match = 'Matched';
        } */
        if (idas_firstname_match == "Matched" && surname_match == 'Matched') {
            fullnamesmatch = "Matched";
        }


        <?php if ($debt_summary == 1) { ?>
            var NoOfPaidUpOrClosedAccounts = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['NoOfPaidUpOrClosedAccounts']; ?>" != null) ? "<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['NoOfPaidUpOrClosedAccounts']; ?>" : '';
            var TotalMonthlyInstallmentCPA = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['TotalMonthlyInstallmentCPA']; ?>" != null) ? "<?= round($debt_summary_det['ConsumerCPANLRDebtSummary']['TotalMonthlyInstallmentCPA'],2); ?>" : '';
            var TotalOutStandingDebtCPA = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['TotalOutStandingDebtCPA']; ?>" != null) ? "<?= round($debt_summary_det['ConsumerCPANLRDebtSummary']['TotalOutStandingDebtCPA'], 2); ?>" : '';
            var TotalArrearAmountCPA = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['TotalArrearAmountCPA']; ?>" != null) ? "<?= round($debt_summary_det['ConsumerCPANLRDebtSummary']['TotalArrearAmountCPA'],2); ?>" : '';
            var TotalMonthlyInstallmentCPA = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['TotalMonthlyInstallmentCPA']; ?>" != null) ? "<?= round($debt_summary_det['ConsumerCPANLRDebtSummary']['TotalMonthlyInstallmentCPA'],2); ?>" : '';
            var TotalOutStandingDebtCPA = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['TotalOutStandingDebtCPA']; ?>" != null) ? "<?= round($debt_summary_det['ConsumerCPANLRDebtSummary']['TotalOutStandingDebtCPA'], 2); ?>" : '';
            var TotalArrearAmountCPA = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['TotalArrearAmountCPA']; ?>" != null) ? "<?= round($debt_summary_det['ConsumerCPANLRDebtSummary']['TotalArrearAmountCPA'],2); ?>" : '';
            var HighestMonthsinArrearsCPA = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['HighestMonthsinArrearsCPA']; ?>" != null) ? "<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['HighestMonthsinArrearsCPA']; ?>" : '';
            var TotalAdverseAmt = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['TotalAdverseAmt']; ?>" != null) ? "<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['TotalAdverseAmt']; ?>" : '';
            var NoOfEnquiriesLast90DaysOWN = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['NoOfEnquiriesLast90DaysOWN']; ?>" != null) ? "<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['NoOfEnquiriesLast90DaysOWN']; ?>" : '';
            var NoOfEnquiriesLast90DaysOTH = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['NoOfEnquiriesLast90DaysOTH']; ?>" != null) ? "<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['NoOfEnquiriesLast90DaysOTH']; ?>" : '';
            var NoOfAccountsOpenedinLast45DaysNLR = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['NoOfAccountsOpenedinLast45DaysNLR']; ?>" != null) ? "<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['NoOfAccountsOpenedinLast45DaysNLR']; ?>" : '';
            var Description = ("<?= $debt_summary_det['ConsumerScoring']['Description']; ?>" != null) ? "<?= $debt_summary_det['ConsumerScoring']['Description']; ?>" : '';
            var NoofAccountdefaults = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['NoofAccountdefaults']; ?>" != null) ? "<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['NoofAccountdefaults']; ?>" : '';
            var DefaultListingCount = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['DefaultListingCount']; ?>" != null) ? "<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['DefaultListingCount']; ?>" : '';
            if (DefaultListingCount == '0') {
                DefaultListingCount = 'N';
            } else {
                DefaultListingCount = 'Y';
            }
            var JudgementCount = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['JudgementCount']; ?>" != null) ? "<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['JudgementCount']; ?>" : '';
            if (JudgementCount == '0') {
                JudgementCount = 'N';
            } else {
                JudgementCount = 'Y';
            }


            var CourtNoticeCount = ("<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['CourtNoticeCount']; ?>" != null) ? "<?= $debt_summary_det['ConsumerCPANLRDebtSummary']['CourtNoticeCount']; ?>" : '';

            var DebtReviewStatus = ("<?= implode($debt_summary_det['ConsumerCPANLRDebtSummary']['DebtReviewStatus']); ?>" != null) ? "<?= implode($debt_summary_det['ConsumerCPANLRDebtSummary']['DebtReviewStatus']); ?>" : '';
        if (DebtReviewStatus == '' || DebtReviewStatus ==null)
        {
            DebtReviewStatus = 'NONE';
        }
        var DisputeMessage = ("<?= implode($debt_summary_det['ConsumerCPANLRDebtSummary']['DisputeMessage']); ?>" != null) ? "<?= implode($debt_summary_det['ConsumerCPANLRDebtSummary']['DisputeMessage']); ?>" : '';
        if (DisputeMessage == '' || DisputeMessage ==null)
        {
            DisputeMessage = 'NONE';
        }

            <?php } ?>
        var Deceaseddate = "<?= $DATEOFDEATH; ?>";

        var EnquiryDate = ("<?= $EnquiryDate; ?>" != null) ? "<?= $EnquiryDate; ?>" : '';


        var EnquiryInput = ("<?= $EnquiryInput; ?>" != null) ? "<?= $EnquiryInput; ?>" : '';
        var VerifFirstName = ("<?= $VerifFirstName; ?>" != null) ? "<?= $VerifFirstName; ?>" : '';
        var VerifSurname = ("<?= $VerifSurname; ?>" != null) ? "<?= $VerifSurname; ?>" : '';
        var VerifDeseaStat = ("<?= $VerifDeseaStat; ?>" != null) ? "<?= $VerifDeseaStat; ?>" : '';
        var VerifDeseaDate = ("<?= $VerifDeseaDate; ?>" != null) ? "<?= $VerifDeseaDate; ?>" : '';
        var VerifDeathCause = ("<?= $VerifDeathCause; ?>" != null) ? "<?= $VerifDeathCause; ?>" : '';
        if (VerifDeseaStat == 'Alive' || DeceasedStatus == 'Alive') {
            Deceaseddate = VerifDeseaDate = VerifDeathCause = 'N/A';
        }
        var validation_datetime = ("<?= $fica->Validation_Status; ?>" != null) ? "<?= date('d M Y H:i A', strtotime($fica->Validation_Status)); ?>" : '';


        // Variables End
        var htmlstring = '';
        var tempVarToCheckPageHeight = 0;
        var pageHeight = 0;

        var logo = 'data:image/png;base64,' + '<?php echo base64_encode(file_get_contents($Logo)); ?>';

        <?php if ($fica->facial) { ?>
            var HomeAffPhoto = 'data:image/png;base64,<?php echo $AdminConsumerIDPhoto; ?>';
            var CapturedPhoto = 'data:image/png;base64,<?php echo $AdminConsumerCapturedPhoto; ?>';
        <?php } else { ?>
            var HomeAffPhoto = 'data:image/png;base64,<?php echo $ConsumerIDPhoto; ?>';
            var CapturedPhoto = 'data:image/png;base64,<?php echo $ConsumerCapturedPhoto; ?>';
        <?php } ?>
        // var HomeAffPhoto = 'data:image/png;base64,'+'<?php //echo base64_encode(file_get_contents($ConsumerIDPhoto));
                                                        ?>';
        // var CapturedPhoto = 'data:image/png;base64,'+'<?php //echo base64_encode(file_get_contents($ConsumerCapturedPhoto));
                                                            ?>';

        var compliancephoto = 'data:image/png;base64,<?php echo $compliancephoto; ?>';
        var VerificationStaticPhoto = 'data:image/png;base64,<?php echo $VerificationStaticPhoto; ?>';
        var PaymentPhoto = 'data:image/png;base64,<?php echo $PaymentPhoto; ?>';
        var Debtphoto = 'data:image/png;base64,<?php echo $Debtphoto; ?>';

        var KYCPhoto = 'data:image/png;base64,<?php echo $KYCPhoto; ?>';
        var FacialPhoto = 'data:image/png;base64,<?php echo $FacialPhoto; ?>';
        var tick = 'data:image/png;base64,<?php echo $tick; ?>';
        var cross = 'data:image/png;base64,<?php echo $cross; ?>';
        var questionmark = 'data:image/png;base64,<?php echo base64_encode(file_get_contents('assets/images/not-completed.png'));; ?>';
        var question = 'data:image/png;base64,<?php echo base64_encode(file_get_contents('assets/images/question.png'));; ?>';
        var xds = 'data:image/png;base64,<?php echo $xds; ?>';
        var inspiritlogo = 'data:image/png;base64,' + '<?php echo base64_encode(file_get_contents('assets/images/PoweredBy.png')); ?>';
        var custID = ("<?= $custID; ?>" != null) ? "<?= $custID; ?>" : '';
        var bgColour = ("<?= $customer->Client_Font_Code; ?>" != null) ? "<?= $customer->Client_Font_Code ?>" : '';

        /*
         btn-styles {
            background-color: <?= $customer->Client_Font_Code == null ? "#1a4f6e" : $customer->Client_Font_Code ?>;*/

        if (custID != '47B97C4A-E9F6-4283-BDB5-D500CA8851C1')
            doc.addImage(logo, 'png', 45, 25, 110, 40, undefined, 'FAST');
        //doc.addImage(xds, 'png', 510, 25, 60, 40); //xds1
        doc.addImage(inspiritlogo, 'png', 470, 25, 100, 40, undefined, 'FAST'); //inspirit logo
        doc.setFont("Avenir");
        doc.setFontSize(6);


        doc.autoTable({
            head: [
                ['Due Diligence Report']
            ],
            body: [],
            startY: 70,
            styles: {
                fontSize: 14,
                font: 'Avenir',
                textColor: [0, 0, 0]
            },
            columnStyles: {
                0: {
                    cellWidth: 100,
                },
                halign: 'center'
            },
            headStyles: {
                fillColor: bgColour,
                textColor: [255, 255, 255],
                halign: 'center'
            },
        });

        pageHeight = doc.internal.pageSize.height;
        specialElementHandlers = {
            '#bypassme': function(element, renderer) {
                return true;
            }
        };

        margins = {
            top: 100,
            bottom: 60, // Adjust the bottom margin value as needed
            left: 20,
            right: 20,
            width: 700,
            height: 700,
        };

        doc.setFontSize(8);

        doc.autoTable({
            body: [
                ['Extracted By:', `${LogUserName} ${LogUserSurname}`, 'Extracted For:', `${FirstName} ${surname}`],
                ['Date of Report:', `${new Date().toLocaleDateString()}`, 'Identity Number:', `${idnum}`],
                ['Ref. Number:', `${Client_Ref}`, 'Validated On:', `${validation_datetime}`],
            ],
            startY: 100,
            styles: {
                fontSize: 8,
                font: 'Avenir',
                textColor: [0, 0, 0]
            },
            columnStyles: {
                0: {
                    cellWidth: 150,
                    fontStyle: 'bold'
                },
                1: {
                    cellWidth: 120
                },
                2: {
                    cellWidth: 140,
                    fontStyle: 'bold'
                },
                3: {
                    cellWidth: 120
                }
            },
            headStyles: {
                fillColor: bgColour,
                textColor: [255, 255, 255]
            },
        });




        /*  if(isFaceView == 'No' || isFacial == 'Yes')
         {
             // First Image
             var firstImageX = 250;
             var firstImageY = 215;
             var firstImageWidth = 75;
             var firstImageHeight = 100;

             // Add text centered on top of the first image frame
             doc.setFontSize(10);
             var firstImageTextX = firstImageX + firstImageWidth / 2;
             var firstImageTextY = firstImageY - 10;
             doc.text('Home Affairs Captured Photo', firstImageTextX, firstImageTextY, { align: 'center' });

             // Second Image
             var secondImageX = 400;
             var secondImageY = 215;
             var secondImageWidth = 75;
             var secondImageHeight = 100;

             // Add text centered on top of the second image frame
             var secondImageTextX = secondImageX + secondImageWidth / 2;
             var secondImageTextY = secondImageY - 10;
             doc.text('Client Captured Photo', secondImageTextX, secondImageTextY, { align: 'center' });
             // Add the images
             doc.addImage(HomeAffPhoto, 'png', firstImageX, firstImageY, firstImageWidth, firstImageHeight);
             doc.addImage(CapturedPhoto, 'png', secondImageX, secondImageY, secondImageWidth, secondImageHeight);
         }  */
        <?php if ($IDV == 1) { ?>
            doc.autoTable({
                head: [
                    ['Facial Recognition']
                ],
                body: [],
                startY: doc.lastAutoTable.finalY + 20,
                styles: {
                    fontSize: 8,
                    font: 'Avenir',
                    textColor: [0, 0, 0]
                },
                columnStyles: {
                    0: {
                        cellWidth: 100,
                        fontStyle: 'bold',
                        halign: 'left'
                    },
                },
                headStyles: {
                    fillColor: bgColour,
                    textColor: [255, 255, 255],
                    halign: 'left'
                },
            });
        <?php } ?>

        if ("<?= $IDV; ?>" == 1) {

            // First Image
            var firstImageX = 250; //95; //250
            var firstImageY = 230; ////215;
            var firstImageWidth = 75;
            var firstImageHeight = 100;

            // Add text centered on top of the first image frame
            doc.setFontSize(10);
            var firstImageTextX = firstImageX + firstImageWidth / 2;
            var firstImageTextY = firstImageY - 10;
            doc.text('DHA Captured Photo', firstImageTextX, firstImageTextY, {
                align: 'center'
            });
            doc.addImage(HomeAffPhoto, 'png', firstImageX, firstImageY, firstImageWidth, firstImageHeight, undefined, 'FAST');

        }


        var startofscreening = "<?= $IDV; ?>" == 1 ? 140 : 20;
        doc.autoTable({
            head: [
                ['Screening Indicators']
            ],
            body: [],
            startY: doc.lastAutoTable.finalY + startofscreening,
            styles: {
                fontSize: 8,
                font: 'Avenir',
                textColor: [0, 0, 0]
            },
            columnStyles: {
                0: {
                    cellWidth: 100,
                    fontStyle: 'bold',
                    halign: 'left'
                }
            },
            headStyles: {
                fillColor: bgColour,
                textColor: [255, 255, 255],
                halign: 'left'
            },
        });

        var tickfromheight = doc.lastAutoTable.finalY + 8;
        var iconfromheight = doc.lastAutoTable.finalY + 30;
        var icontextfromheight = doc.lastAutoTable.finalY + 90;

        if (personal == 'Passed') {
            doc.addImage(tick, 'png', 65, tickfromheight, 20, 20, undefined, 'FAST');
        }
        else if (personal == 'Server Error') {
                doc.addImage(question, 'png', 65, tickfromheight, 20, 20, undefined, 'FAST');
        }
         else {
            doc.addImage(cross, 'png', 65, tickfromheight, 20, 20, undefined, 'FAST');
        }
        doc.addImage(VerificationStaticPhoto, 'png', 50, iconfromheight, 50, 50);
        doc.text('Personal', 74, icontextfromheight, {
            align: 'center',
            fontSize: 2
        });

        var i = 60;
        <?php if ($KYC == 1) { ?>
            if (kyc == 'Passed') {
                doc.addImage(tick, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            }
            else if (kyc == 'Server Error') {
                doc.addImage(question, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            }
             else {
                doc.addImage(cross, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            }
            doc.addImage(KYCPhoto, 'png', i + 85, iconfromheight, 50, 50, undefined, 'FAST');
            doc.text('KYC', i + 109, icontextfromheight, {
                align: 'center',
                fontSize: 2
            });
            i = i + 90;
        <?php } ?>


        <?php if ($AVS == 1) { ?>
            if (avs == 'Passed') {
                doc.addImage(tick, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            }
            else if (avs == 'Server Error') {
                doc.addImage(question, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            }
             else {
                doc.addImage(cross, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            }
            doc.addImage(PaymentPhoto, 'png', i + 85, iconfromheight, 50, 50, undefined, 'FAST');
            doc.text('Bank', i + 109, icontextfromheight, {
                align: 'center',
                fontSize: 2
            });
            i = i + 90;
        <?php } ?>

        <?php if ($IDV == 1) { ?>
            if (HA_IDNOMatchStatus == 'Matched') {
                doc.addImage(tick, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            } else {
                doc.addImage(cross, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            }
            doc.addImage(FacialPhoto, 'png', i + 85, iconfromheight, 50, 50, undefined, 'FAST');
            doc.text('Face View', i + 109, icontextfromheight, {
                align: 'center',
                fontSize: 2
            });
            i = i + 90;
        <?php } ?>


        <?php if ($Compliance == 1) { ?>
            if (("<?= $Compliance_Status; ?>" == 1 || "<?= $Compliance_Status; ?>" == 2)) {
                doc.addImage(tick, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            } else if (("<?= $Compliance_Status; ?>" == 0)) {
                doc.addImage(cross, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            } else {
                doc.addImage(cross, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            }
            doc.addImage(compliancephoto, 'png', i + 85, iconfromheight, 50, 50, undefined, 'FAST');
            doc.text('Compliance', i + 109, icontextfromheight, {
                align: 'center',
                fontSize: 2
            });
            i = i + 90;
        <?php } ?>


        <?php if ($debt_summary == 1) { ?>
            if (HA_IDNOMatchStatus == 'Matched') {
                doc.addImage(tick, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            } else {
                doc.addImage(cross, 'png', i + 100, tickfromheight, 20, 20, undefined, 'FAST');
            }
            doc.addImage(Debtphoto, 'png', i + 85, iconfromheight, 50, 50, undefined, 'FAST');
            doc.text('Debt Summary', i + 109, icontextfromheight, {
                align: 'center',
                fontSize: 2
            });
            i = i + 90;
        <?php } ?>



        // Define the text to be placed in the center
        var text = "Verification checks completed successfully.";
        var text2 = "Verification checks did not complete successfully.";
        var text3 = "No response from Verification checks."; //assets/images/question.png

        // Get the width of the text
        var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize();

        // Get the width of the document
        var pageWidth = doc.internal.pageSize.getWidth();

        // Calculate the position to place the text in the center
        var xPos = (pageWidth - textWidth) / 2;
        doc.setFont("helvetica", "normal");
        doc.setFontSize(8)

        doc.addImage(tick, 'png', xPos - 175, doc.lastAutoTable.finalY + 104, 10, 10, undefined, 'FAST');
        doc.text(text, xPos - 162, doc.lastAutoTable.finalY + 112);
        doc.addImage(cross, 'png', xPos - 4, doc.lastAutoTable.finalY + 104, 10, 10, undefined, 'FAST');
        doc.text(text2, xPos + 9, doc.lastAutoTable.finalY + 112);
        doc.addImage(question, 'png', xPos + 187, doc.lastAutoTable.finalY + 104, 10, 10, undefined, 'FAST');
        doc.text(text3, xPos + 201, doc.lastAutoTable.finalY + 112);
        /*    doc.addImage(tick, 'png', i - 355, doc.lastAutoTable.finalY + 100, 12, 12, undefined,'FAST');
            doc.text('Verification checks completed succesfully.', i - 250, doc.lastAutoTable.finalY + 110, {
                align: 'center',
                    fontSize: 8,
                    font: 'Avenir'
                });

                doc.addImage(cross, 'png', i - 155, doc.lastAutoTable.finalY + 100, 12, 12, undefined,'FAST');
                doc.text('Verification checks did not complete succesfully.', i - 40, doc.lastAutoTable.finalY + 110, {
                    align: 'center',
                    fontSize: 8,
                    font: 'Avenir'
                });*/

        doc.autoTable({
            /* body: [
                ['ID Number Confirmed:', `${personal}`],
                ['Know Your Customer (KYC):', `${kyc}`],
                ['Bank Account Verification (AVS):', `${avs}`],
                ['Facial Recognition:', `${ConsumerIDPhotoMatch}`],
                ['Compliance Check:', `${comp}`],
            ], */
            startY: doc.lastAutoTable.finalY + 110,
            styles: {
                fontSize: 8,
                font: 'Avenir',
                textColor: [0, 0, 0],
                cellPadding: 5,
            },
            columnStyles: {
                0: {
                    cellWidth: 240,
                    fontStyle: 'bold',
                    halign: 'left'
                },
                1: {
                    cellWidth: 290,
                    halign: 'left'
                },
            },
        });

        <?php if ($Risk == 1) { ?>
            doc.autoTable({
                head: [
                ['Risk and Compliance Indicator', 'Result','','']
            ],
                body: [
                    ['Risk Rating:', `${RiskStatus}`,'',''],
                    //['Nationality:', `${Nationality}`],
                    ['Nationality:', `<?= $ComNationality; ?>`],
                    ['Is the client a DPIP/FPPO?:', `<?= $DPIP_FPPO; ?>`],
                    ['Source of Funds:', `<?= $Source_Of_Income; ?>`],
                    ['Industry of occupation::', `<?= $Occupation; ?>`],
                    ['Any relevant adverse media?:', `<?= $Is_adverse_madia; ?>`],
                    ['Has the client been identified on a sanctions list?:', `<?= $Is_sactions_list; ?>`],
                    //['Compliance Exposure (Sanctions, AML, DPEP, FPEP, PIP, TFS Screening)', `${comp}`],
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: {
                    fontSize: 8,
                    font: 'Avenir',
                    textColor: [0, 0, 0],
                    cellPadding: 5,
                },
                columnStyles: {
                    0: {
                    cellWidth: 220,
                    fontStyle: 'bold'
                },
                1: {
                    cellWidth: 200
                },
                2: {
                    cellWidth: 10,
                    fontStyle: 'bold'
                },
                3: {
                    cellWidth: 100
                }
            },
            headStyles: {
                fillColor: bgColour,
                textColor: [255, 255, 255]
            },

            });
        <?php } ?>


        // Personal Details
        doc.autoTable({
            head: [
                ['User Input Details', 'Result', 'Verified']
            ],
            body: [
                ['Full Name(s):', `${TitleDesc} ${FirstName} ${surname}`, `${fullnamesmatch}`],
                ['Email:', `${Email}`, `${emailmatch}`],
                ['Phone (W):', `${WorkTelCode }${WorkTelNo}`, `${workmatch}`],
                ['Phone (H):', `${HomeTelCode}${HomeTelNo}`,`${homematch}`],
                ['Phone (C):', `${CellCode}${CellNo}`, `${cellmatch}`],
                ['Client Reference Number:', `${Client_Ref}`, ''],
                //['Telephone (C):', `${CellCode}${CellNo}`, 'Date of Birth:', `${BirthDate}`],
                //['ID Date of Issue:', `${ID_DateofIssue}`, 'Country of Birth:', `${ID_CountryResidence}`],
                //['Employment Industry:', `${Industryofoccupation}`,'Employment Status:', `${Employmentstatus}`],
                //['Name Of Employer:', `${Nameofemployer}`],
            ],
            startY: doc.lastAutoTable.finalY + 20,
            styles: {
                fontSize: 8,
                font: 'Avenir',
                textColor: [0, 0, 0]
            },
            columnStyles: {
                0: {
                    cellWidth: 220,
                    fontStyle: 'bold'
                },
                1: {
                    cellWidth: 230
                },
                /* 2: {
                    cellWidth: 110,
                    fontStyle: 'bold'
                }, */
                2: {
                    cellWidth: 80
                }
            },
            headStyles: {
                fillColor: bgColour,
                textColor: [255, 255, 255]
            },
        });

        /* <?php if ($KYC == 1) { ?>
             // Address Details
             doc.autoTable({
                 head: [
                     ['Physical Details', '', '', '']
                 ],
                 body: [
                     ['Street Address 1', `${resadd1}`, 'Street Address 2:', `${resadd2}`],
                     ['City/Town', `${resadd3}`, 'Province:', `${resprov}`],
                     ['Zip/Postal', `${reszip}`, '', ``],
                 ],
                 startY: doc.lastAutoTable.finalY + 7,
                 styles: {
                     fontSize: 8,
                     font: 'Avenir',
                     textColor: [0, 0, 0]
                 },
                 columnStyles: {
                     0: {
                         cellWidth: 100,
                         fontStyle: 'bold'
                     },
                     1: {
                         cellWidth: 140
                     },
                     2: {
                         cellWidth: 100,
                         fontStyle: 'bold'
                     },
                     3: {
                         cellWidth: 190
                     }
                 },
                 headStyles: {
                     fillColor: bgColour,
                     textColor: [255, 255, 255]
                 },
             });
         <?php } ?>

         /* doc.autoTable({
             head: [['Postal Details', '', '', '']],
             body: [
                 ['Street Address 1', `${posadd1}`,'Street Address 2:', `${posadd2}`],
                 ['City/Town', `${posadd3}`,'Province:', `${posprov}`],
                 ['Zip/Postal', `${poszip}`,'', ``],
             ],
             startY: doc.lastAutoTable.finalY + 7,
             styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
             columnStyles: { 0: { cellWidth: 100, fontStyle: 'bold' }, 1: { cellWidth: 140 }, 2: { cellWidth: 100, fontStyle: 'bold' }, 3: { cellWidth: 190 } },
             headStyles :{fillColor : [26, 79, 110], textColor: [255, 255, 255]},
         });

         doc.autoTable({
             head: [['Work Details', '', '', '']],
             body: [
                 ['Street Address 1', `${workadd1}`,'Street Address 2:', `${workadd2}`],
                 ['City/Town', `${workadd3}`,'Province:', `${workprov}`],
                 ['Zip/Postal', `${workzip}`,'', ``],
             ],
             startY: doc.lastAutoTable.finalY + 7,
             styles: { fontSize: 8, font: 'Avenir', textColor: [0, 0, 0] },
             columnStyles: { 0: { cellWidth: 100, fontStyle: 'bold' }, 1: { cellWidth: 140 }, 2: { cellWidth: 100, fontStyle: 'bold' }, 3: { cellWidth: 190 } },
             headStyles :{fillColor : [26, 79, 110], textColor: [255, 255, 255]},
         }); */

        <?php if ($AVS == 1) { ?>

            // doc.addPage();
            doc.autoTable({
                head: [
                    ['Bank Account Verification (Realtime)', 'Result', 'Verified']
                ],
                body: [
                    ['AVS Status:', `${avs}`],
                    ['Branch Code:', `${Branch_code}`],
                    ['Account Holder:', `${Account_name}`],
                    ['Account Number:', `${Account_no}`],
                    ['Bank Name:', `${Bank_name}`],
                    ['Account Exists:', `${accopen}`],
                    ['Initials Match:', `${initials}`, `${initialsmatch}`],
                    ['Surname Match:', `${surname}`, `${banksurnamematch}`],
                    ['ID Number Match:', `${idnum}`, `${idnummatch}`],
                    ['Email Address Match:', `${Email}`, `${EMAILMATCHstatus}`],
                    ['Account Type Match:', `${accopen}`],
                    ['Account Dormant:', `${accdormant}`],
                    ['Account Open Three Months:', `${accthreemonths}`],
                    ['Account Accepts Debits:', `${accdebit}`],
                    ['Account Type Match:', `${acc}`],
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: {
                    fontSize: 8,
                    font: 'Avenir',
                    textColor: [0, 0, 0]
                },
                columnStyles: {
                0: {
                    cellWidth: 220,
                    fontStyle: 'bold'
                },
                1: {
                    cellWidth: 230,
                },
                /* 2: {
                    cellWidth: 110,
                    fontStyle: 'bold'
                }, */
                2: {
                    cellWidth: 80
                }
            },

                headStyles: {
                    fillColor: bgColour,
                    textColor: [255, 255, 255]
                },
            });
        <?php } ?>

        <?php if ($KYC == 1) { ?>
            //doc.addPage();
            doc.autoTable({

                head: [['Know your customer (KYC)','Result','']],

                body: [
                    ['KYC Result:', `${kyc}`],
                    ['Total Sources Used:', `${TotalSourcesUsed}`],
                    ['KYC Status Desc:', `${KYCStatusDesc}`],
                    ['Residential Address:', `${ResidentialAddress}`],
                    ['Province:', `${resprov}`],
                    ['ID Status:', `${IDStatus}`],
                    ['ID Status Description:', `${IDStatusDesc}`],
                    ['Sources Used:', `${Sources}`]
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: {
                    fontSize: 8,
                    font: 'Avenir',
                    textColor: [0, 0, 0]
                },
                columnStyles: {
                0: {
                    cellWidth: 220,
                    fontStyle: 'bold'
                },
                1: {
                    cellWidth: 230
                },
                /* 2: {
                    cellWidth: 110,
                    fontStyle: 'bold'
                }, */
                2: {
                    cellWidth: 80
                }
            },
                headStyles: {
                    fillColor: bgColour,
                    textColor: [255, 255, 255]
                },
            });
        <?php } ?>

        <?php if ($IDV == 1) { ?>
            //doc.addPage();
            doc.autoTable({
                head: [['Face View Biometric: Validated at DHA', 'Result','Verified']],

                body: [

                    ['ID No. Status:', `${idnum}`, `${HA_IDNOMatchStatus}`],
                    ['Home Affairs Names:', `${HA_Names}`,  `${name_match}`],
                    ['Home Affairs Surname:', `${HA_Surname}`,  `${surname_match}`],
                    ['Country of Birth:', `${HA_Countryofbirth}`, ''],
                    ['Green Book ID Date of Issue:', `${HA_IDBookIssuedDate}`, ''],
                    ['Smart ID Card Date of Issue:', `${HA_IDCardDate}`, ''],
                    ['ID Number Blocked:', `${HA_IDNumberBlocked}`, ''],
                    ['Gender:', `${HA_Gender}`, ''],
                    ['Date Of Birth:', `${HA_DateOfBirth}`, ''],
                    ['Deceased Status:', `${HA_DeceasedStatus}`, ''],
                    ['Deceased Date:', `${HA_DeceasedDate}`, ''],
                    ['Marital Status:', `<?= $MaritalStatusDesc; ?>`, ''],
                    ['Marriage Date:', `<?= strtok($Marriage_date, ' '); ?>`, ''],
                    ['Enquiry Reference:', `${HA_EnquiryReference}`, ''],

                    /* ['Latitude:', 'Device Location Disabled/Denied', ''],
                    ['Longitude:', 'Device Location Disabled/Denied', ''] */
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: {
                    fontSize: 8,
                    font: 'Avenir',
                    textColor: [0, 0, 0]
                },
                columnStyles: {
                    0: {
                    cellWidth: 220,
                    fontStyle: 'bold'
                },
                1: {
                    cellWidth: 230
                },
                /* 2: {
                    cellWidth: 110,
                    fontStyle: 'bold'
                }, */
                2: {
                    cellWidth: 80
                }
            },
                headStyles: {
                    fillColor: bgColour,
                    textColor: [255, 255, 255]
                },
            });
        <?php } ?>


        <?php if ($fica->facial) { ?>
            // doc.addPage();
            doc.autoTable({
                //head: [['Facial Recognition Biometric: Validated at Department of Home Affairs', '', '']],
                head: [
                    [{
                        content: 'Facial Recognition Biometric: Validated at Department of Home Affairs',
                        colSpan: 5,
                        styles: {
                            halign: 'left',
                            fillColor: bgColour,
                            textColor: [255, 255, 255]
                        },
                    }, ],
                ],
                body: [
                    ['Liveliness Detection:', `<?= $fica->facial->LivenessDetectionResult; ?>`, ''],
                    ['ID No. Status:', `<?= $fica->facial->HA_IDNOMatchStatus; ?>`, ''],
                    ['Deceased Status:', `<?= $fica->facial->DeceasedStatus; ?>`, ''],
                    ['Latitude:', 'Device Location Disabled/Denied', ''],
                    ['Longitude:', 'Device Location Disabled/Denied', '']
                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: {
                    fontSize: 8,
                    font: 'Avenir',
                    textColor: [0, 0, 0]
                },
                columnStyles: {
                    0: {
                        cellWidth: 150,
                        fontStyle: 'bold'
                    },
                    1: {
                        cellWidth: 270
                    },
                    2: {
                        cellWidth: 0
                    }
                },
                headStyles: {
                    fillColor: bgColour,
                    textColor: [255, 255, 255]
                },
            });
        <?php } ?>


        <?php if ($debt_summary == 1) { ?>
            //doc.addPage();
            doc.autoTable({
                head: [
                    ['Debt Summary','Result','']
                ],
                body: [
                    ['Total No. of Paid Up or Closed Accounts (last 24 months):', `${NoOfPaidUpOrClosedAccounts}`],
                    ['Total Monthly Instalments:', `R${TotalMonthlyInstallmentCPA}`],
                    ['Total Outstanding Debt:', `R${TotalOutStandingDebtCPA}`],
                    ['Total Arrear Amount:', `R${TotalArrearAmountCPA}`],
                    ['Highest Months in Arrears (Last 24 Months):', `${HighestMonthsinArrearsCPA}`],
                    ['Total Adverse Amount (Write offs/Repossessions):', `${TotalAdverseAmt}`],
                    ['Total Enquiries Done in the last 90 days by Subscriber:', `${NoOfEnquiriesLast90DaysOWN}`],
                    ['Total Enquiries Done in the last 90 days by Other Subscribers:', `${NoOfEnquiriesLast90DaysOTH}`],
                    ['Total No. of Accounts opened within the last 45 days:', `${NoOfAccountsOpenedinLast45DaysNLR}`],
                    ['Collection Probability:', `${Description}`],
                    ['Public Domain - Adverse / Defaults:', `${NoofAccountdefaults}`],
                    ['Default listing – Y/N:', `${DefaultListingCount}`],
                    ['Judgements – Y/N:', `${JudgementCount}`],
                    ['Court Notices (Admin Orders/Sequestrations/Rehabilitation Orders) Enquiries (last 24 months):', `${CourtNoticeCount}`],
                    ['Debt Review Status:',`${DebtReviewStatus}`],
                    ['Dispute Information:',`${DisputeMessage}`]

                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: {
                    fontSize: 8,
                    font: 'Avenir',
                    textColor: [0, 0, 0]
                },
                columnStyles: {
                    0: {
                    cellWidth: 220,
                    fontStyle: 'bold'
                },
                1: {
                    cellWidth: 230
                },
                /* 2: {
                    cellWidth: 10,
                    fontStyle: 'bold'
                }, */
                2: {
                    cellWidth: 80
                }
            },
                headStyles: {
                    fillColor: bgColour,
                    textColor: [255, 255, 255]
                },
            });
        <?php } ?>

        <?php if ($Compliance == 1) { ?>
            // doc.addPage();
            doc.autoTable({
                //head: [['Consumer Compliance Exposure (Sanctions, AML, DPEP, FPEP, PIP, TFS Screening)', '']],
                head: [
                    [
                        'Consumer Compliance Exposure ','Result',''
                       ], ['(Sanctions, AML, DPEP, FPEP, PIP, TFS Screening)', '', ''],
                ],
                body: [
                    ['Compliance Status:',`${comp}`],
                    ['Enquiry Date:',`${EnquiryDate}`],
                    ['Enquiry Input:',`${EnquiryInput}`],
                    ['Verified First Name:', `${VerifFirstName}`],
                    ['Verified Surname:',`${VerifSurname}`],
                    ['Verified Deceased Status:', `${VerifDeseaStat}`],
                    ['Verified Deceased Date:',`${VerifDeseaDate}`],
                    ['Verified Cause of Death:',`${VerifDeathCause}`]

                ],
                startY: doc.lastAutoTable.finalY + 7,
                styles: {
                    fontSize: 8,
                    font: 'Avenir',
                    textColor: [0, 0, 0]
                },
                columnStyles: {
                    0: {
                    cellWidth: 220,
                    fontStyle: 'bold'
                },
                1: {
                    cellWidth: 230
                },
                /* 2: {
                    cellWidth: 10,
                    fontStyle: 'bold'
                }, */
                2: {
                    cellWidth: 80
                }
            },
                headStyles: {
                    fillColor: bgColour,
                    textColor: [255, 255, 255]
                },

            });
            AddList.forEach((element, index) => {

                var temp = [
                    element.Additional_type,
                    element.Additional_value,
                    element.Additional_comment,
                ]
                AddData.push(temp)
            })

            console.log(AddData);

            if (AddData.length > 0) {
                doc.autoTable({
                    startY: doc.lastAutoTable.finalY + 7,
                    head: [
                        ['Entity Additional Information']
                    ],
                    styles: {
                        fontSize: 8,
                        font: 'Avenir',
                        textColor: [0, 0, 0],
                        fontStyle: 'bold'
                    },
                    headStyles: {
                        halign: 'left',
                        fillColor: bgColour,
                        textColor: [255, 255, 255]
                    },


                });

                doc.autoTable({

                    head: [
                        ['Type', 'Value', 'Comment']
                    ],
                    body: AddData,
                    startY: doc.lastAutoTable.finalY + 7,
                    styles: {
                        fontSize: 8,
                        font: 'Avenir',
                        textColor: [0, 0, 0]
                    },
                    columnStyles: {
                        0: {
                            cellWidth: 150
                        },
                        1: {
                            cellWidth: 190
                        },
                        2: {
                            cellWidth: 190
                        }
                    },
                    headStyles: {
                        fillColor: "#7393b3",
                        textColor: [255, 255, 255]
                    },
                });
            } else {
                doc.autoTable({
                    startY: doc.lastAutoTable.finalY + 7,
                    head: [
                        ['Entity Additional Information']
                    ],
                    styles: {
                        fontSize: 8,
                        font: 'Avenir',
                        textColor: [0, 0, 0],
                        fontStyle: 'bold'
                    },
                    headStyles: {
                        halign: 'left',
                        fillColor: bgColour,
                        textColor: [255, 255, 255]
                    },

                });
                doc.autoTable({
                    head: [
                        ['Type', 'Value', 'Comment']
                    ],
                    body: [
                        ['', '', 'No results found']
                    ],
                    startY: doc.lastAutoTable.finalY + 7,
                    styles: {
                        fontSize: 8,
                        font: 'Avenir',
                        textColor: [0, 0, 0],

                    },
                    columnStyles: {
                        0: {
                            cellWidth: 150,
                            fontStyle: 'bold'
                        },
                        1: {
                            cellWidth: 190
                        },
                        2: {
                            cellWidth: 190
                        }
                    },
                    headStyles: {
                        fillColor: "#7393b3",
                        textColor: [255, 255, 255],

                    },

                });


            }


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

            console.log("show" + SancData);

            if (SancData.length > 0) {
                doc.autoTable({
                    startY: doc.lastAutoTable.finalY + 7,
                    head: [
                        ['Sanction Screening']
                    ],
                    styles: {
                        fontSize: 8,
                        font: 'Avenir',
                        textColor: [0, 0, 0]
                    },
                    headStyles: {
                        halign: 'left',
                        fillColor: bgColour,
                        textColor: [255, 255, 255]
                    },

                });
                doc.autoTable({
                    head: [
                        ['Date Listed', 'Reason Listed', 'Entity Type', 'Gender', 'Entity Name', 'Entity Score', 'Comments']
                    ],
                    body: SancData,
                    startY: doc.lastAutoTable.finalY + 7,
                    styles: {
                        fontSize: 8,
                        font: 'Avenir',
                        textColor: [0, 0, 0]
                    },
                    columnStyles: {
                        0: {
                            cellWidth: 60
                        },
                        1: {
                            cellWidth: 60
                        },
                        2: {
                            cellWidth: 60
                        },
                        3: {
                            cellWidth: 40
                        },
                        4: {
                            cellWidth: 60
                        },
                        5: {
                            cellWidth: 55
                        },
                        6: {
                            cellWidth: 195
                        }
                    },
                    headStyles: {
                        fillColor: "#7393b3",
                        textColor: [255, 255, 255]
                    },
                });
            } else {
                doc.autoTable({
                    startY: doc.lastAutoTable.finalY + 7,
                    head: [
                        ['Sanction Screening']
                    ],
                    styles: {
                        fontSize: 8,
                        font: 'Avenir',
                        textColor: [0, 0, 0]
                    },
                    headStyles: {
                        halign: 'left',
                        fillColor: bgColour,
                        textColor: [255, 255, 255]
                    },

                });
                doc.autoTable({

                    head: [
                        ['Date Listed', 'Reason Listed', 'Entity Type', 'Gender', 'Entity Name', 'Entity Score', 'Comments']
                    ],
                    body: [
                        ['', '', '', '', '', '', 'No results found']
                    ],
                    startY: doc.lastAutoTable.finalY + 7,
                    styles: {
                        fontSize: 8,
                        font: 'Avenir',
                        textColor: [0, 0, 0]
                    },
                    columnStyles: {
                        0: {
                            cellWidth: 60
                        },
                        1: {
                            cellWidth: 60
                        },
                        2: {
                            cellWidth: 60
                        },
                        3: {
                            cellWidth: 40
                        },
                        4: {
                            cellWidth: 60
                        },
                        5: {
                            cellWidth: 55
                        },
                        6: {
                            cellWidth: 195
                        }
                    },
                    headStyles: {
                        fillColor: "#7393b3",
                        textColor: [255, 255, 255]
                    },
                });


            }


        <?php } ?>






        // PAGE NUMBERING
        // Add Page number at bottom-right
        // Get the number of pages
        const pageCount = doc.internal.getNumberOfPages();

        // For each page, print the page number and the total pages
        for (var i = 1; i <= pageCount; i++) {
            // Go to page i
            doc.setPage(i);

            // Set border color
            doc.setDrawColor(26, 79, 110);

            // Set border around the page excluding the footer
            var pageWidth = doc.internal.pageSize.getWidth();
            var pageHeight = doc.internal.pageSize.getHeight();
            var borderWidth = 2;
            var footerHeight = 45;

            // Draw border
            doc.setLineWidth(borderWidth);
            doc.rect(borderWidth / 2, borderWidth / 2, pageWidth - borderWidth, pageHeight - borderWidth - footerHeight);

            // Print page number and footer text
            doc.setFontSize(7);
            doc.text('Page ' + String(i) + ' of ' + String(pageCount), 594 - 20, 800 - 35, null, null, 'right');
            doc.setFontSize(6);
            doc.text('Inspirit Data Analytics Services(Pty) Ltd, an authorized agent of XDS.\nCopyright 2024 Inspirit Data Analytics Services(Pty) Ltd (Reg No: 2017653373)\nPowered by Xpert Decision Systems(XDS).\nXDS is registered with the National Credit Regulator - Reg# NCR-CB5', 295, 758, 'center');
        }

        doc.save(`{{ $FirstName }} {{ $SURNAME }} - Due Diligence Report.pdf`);

    }
</script>
--}}


<script src="assets/libs/jspdf/jspdf.min.js"></script>
<script src="assets/libs/jspdf/jspdf.plugin.autotable.min.js"></script>

@endsection
