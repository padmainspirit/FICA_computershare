@extends('layouts.sbresults-layout')

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

            @if($message!=NULL)
            <div class="alert alert-success" role="alert">
                {{-- {{ Session::get('success') }} --}}
                {{$message}}
            </div>
            @endif


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
                    Self service banking results
                </h5>
            </div>
        </div>


        <!-- Tab panes -->
        <div class="tab-content p-3 text-muted">

            <div class="tab-pane active" id="tab1" role="tabpanel">

                <div class="row justify-content-center">

                    <div class="col-sm-2">
                        <div class="card" style="width: 100%;height:258px;">
                            <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                <div class="" style="padding-left: 9%;">
                                    <h6 class="font-size-14 text-left">Full Names : <span class="text-black">{{ $ha_name }} {{ $ha_secondname }} {{ $ha_surname }}</span></h6>
                                </div>




                                <div class="form-floating mb-3">
                                    @if ($dovs?->ConsumerIDPhoto==NULL)
                                    <img src="/assets/images/ImageNotFound.png" alt="" height="150" width="130" class="auth-logo-light" style="display: block; margin: auto">
                                    </img>
                                    @else
                                    <img src="data:image/png;base64,{{ $dovs?->ConsumerIDPhoto }}" alt="" height="180" width="140" class="auth-logo-light" style="display: block; margin: auto">
                                    </img>
                                    @endif

                                </div>

                                <div class="mb-2"></div>


                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>

                    <div class="col-sm-3">
                        <div class="card" style="width: 100%; height:258px;">
                            <div id="box" class="row d-flex justify-content-evenly" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                <h5 class="card-title" style="text-align: center;">
                                    Flow Status Summary
                                </h5>
                                <div class="col-sm-6 mt-1" style="padding-left: 9%;">
                                    <h6 class="font-size-14 text-left">Date Started :</h6>
                                </div>

                                <div class="col-sm-6 mt-1" style="padding-right: 10%;">
                                    <span class="float-end text-black">{{$selfbankingdetails->CreatedOnDate}}</span>
                                </div>


                                <div class="col-sm-6" style="padding-left: 9%;">
                                    <h5 class="font-size-14 text-left">Identity :</h5>
                                </div>

                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span class="float-end text-black">{{ $selfbankingdetails?->IDNUMBER }}</span>
                                </div>
                                <div class="col-sm-6" style="padding-left: 9%;">
                                    <h5 class="font-size-14 text-left">Personal Info Captured :</h5>
                                </div>
                                @if ($selfbankinglink->PersonalDetails == "1")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: #028E41 !important;" class="float-end text-black">Passed</span>
                                </div>
                            @elseif ($selfbankinglink->PersonalDetails == "-2")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: red !important;" class="float-end text-black">Failed</span>
                                </div>
                            @elseif ($selfbankinglink->PersonalDetails == "2")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: rgb(231, 103, 18) !important;" class="float-end text-black">Needs Review</span>
                                </div>
                            @else
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: orange !important;" class="float-end text-black">In Progress</span>
                                </div>
                            @endif

                                <div class="col-sm-6" style="padding-left: 9%;">
                                    <h6 class="font-size-14 text-left">Banking Details :</h6>
                                </div>
                                @if ($selfbankinglink->BankingDetails == "1")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: #028E41 !important;" class="float-end text-black">Passed</span>
                                </div>
                            @elseif ($selfbankinglink->BankingDetails == "-2")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: red !important;" class="float-end text-black">Failed</span>
                                </div>
                            @elseif ($selfbankinglink->BankingDetails == "2")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: rgb(231, 103, 18) !important;" class="float-end text-black">Needs Review</span>
                                </div>
                            @else
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: orange !important;" class="float-end text-black">In Progress</span>
                                </div>
                            @endif

                                <div class="col-sm-6" style="padding-left: 9%;">
                                    <h6 class="font-size-14 text-left">Face view :</h6>
                                </div>

                                @if ($selfbankinglink->DOVS == "1")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: #028E41 !important;" class="float-end text-black">Passed</span>
                                </div>
                            @elseif ($selfbankinglink->DOVS == "-2")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: red !important;" class="float-end text-black">Failed</span>
                                </div>
                            @elseif ($selfbankinglink->DOVS == "2")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: rgb(231, 103, 18) !important;" class="float-end text-black">Needs Review</span>
                                </div>
                            @else
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: orange !important;" class="float-end text-black">In Progress</span>
                                </div>
                            @endif

                            <div class="col-sm-6" style="padding-left: 9%;">
                                <h6 class="font-size-14 text-left">Flow Overral Status :</h6>
                            </div>

                            @if ($FICAStatus == "Completed")
                            <div class="col-sm-6" style="padding-right: 10%;">
                                <span style="color: #028E41 !important;" class="float-end text-black">{{$FICAStatus}}</span>
                            </div>
                        @elseif ($FICAStatus == "Failed" || $FICAStatus == "Expired" || $FICAStatus == "Rejected")
                            <div class="col-sm-6" style="padding-right: 10%;">
                                <span style="color: red !important;" class="float-end text-black">{{$FICAStatus}}</span>
                            </div>
                        @elseif ($FICAStatus == "Partially Completed")
                            <div class="col-sm-6" style="padding-right: 10%;">
                                <span style="color: rgb(231, 103, 18) !important;" class="float-end text-black">{{$FICAStatus}}</span>
                            </div>
                        @else
                            <div class="col-sm-6" style="padding-right: 10%;">
                                <span style="color: orange !important;" class="float-end text-black">{{$FICAStatus}}</span>
                            </div>
                        @endif
                        <div class="mb-2"></div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>

                    <div class="col-sm-2">
                        <div class="card" style="width: 100%;height:258px;">
                            <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                <h5 class="card-title" style="text-align: center;">
                                    Personal Info
                                </h5>

                                @if ($selfbankinglink->PersonalDetails == "1" )
                                <!-- ($Identity_status == 1) -->
                                <h6 class="card-title" style="text-align: center;">
                                    <i class="bx bx-check-circle  bx-md" style="color: #028E41"></i>
                                </h6>
                                @elseif ($selfbankinglink->PersonalDetails == "-2")
                                <!-- ($Identity_status == 0) -->
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


                    <div class="col-sm-2">
                        <div class="card" style="width: 100%;height:258px;">
                            <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                <h6 class="card-title" style="text-align: center;">Banking Details</h6>

                                @if ($selfbankinglink->BankingDetails == "1")
                                <h6 class="card-title" style="text-align: center;">
                                    <i class="bx bx-check-circle  bx-md" style="color: #028E41"></i>
                                </h6>
                                @elseif ($selfbankinglink->BankingDetails == "-2")
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



                    <div class="col-sm-2">
                        <div class="card" style="width: 100%;height:258px;">
                            <div class="card-body" style="padding-top: 8px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                <h5 class="card-title" style="text-align: center;">
                                    Face view</h5>

                                @if ($selfbankinglink->DOVS == "1")
                                <h6 class="card-title" style="text-align: center;">
                                    <i class="bx bx-check-circle  bx-md" style="color: #028E41"></i>
                                </h6>
                                @elseif ($selfbankinglink->DOVS == "-2")
                                <h6 class="card-title" style="text-align: center;">
                                    <i class="bx bx-x-circle  bx-md" style="color: #E0474C"></i>
                                </h6>
                                @else
                                <h6 class="card-title" style="text-align: center;">
                                    <i class="dripicons-question  bx-sm" style="color: #FFA500"></i>
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
                                            <a class="nav-link mb-2 active" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">Personal Information Captured</a>

                                            <a class="nav-link mb-2" id="v-pills-banking-tab" data-bs-toggle="pill" href="#v-pills-banking" role="tab" aria-controls="v-pills-banking" aria-selected="false">Bank
                                                Account Verification</a>



                                            <a class="nav-link mb-2" id="v-pills-faceview-tab" data-bs-toggle="pill" href="#v-pills-faceview" role="tab" aria-controls="v-pills-faceview" aria-selected="false">Face View</a>

                                            <a class="nav-link mb-2" id="v-pills-docs-tab" data-bs-toggle="pill" href="#v-pills-docs" role="tab" aria-controls="v-pills-docs" aria-selected="false">Documents</a>
                                            <a class="nav-link mb-2" id="v-pills-summary-tab" data-bs-toggle="pill" href="#v-pills-summary" role="tab" aria-controls="v-pills-summary" aria-selected="false">Exceptions Summary</a>

                                            <a class="nav-link mb-2" id="v-pills-actions-tab" data-bs-toggle="pill" href="#v-pills-actions" role="tab" aria-controls="v-pills-actions" aria-selected="false">Actions</a>


                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="d-flex justify-content-between" style="width: 100%;">
                                                <button type="button"
                                                    class="btn waves-effect waves-light"
                                                    style="background-color: #93186c; border-color: #93186c; color:white;"
                                                    data-bs-toggle="modal" data-bs-target="#composemessage">
                                                    Compose Email
                                                </button>
                                                <button type="button" id="newpdf" name="newpdf" onclick="generate()"
                                                    class="btn waves-effect waves-light text-white font-size-14"
                                                    style="background-color: rgb(193, 22, 28); width: 120px; padding: 0;">
                                                    Export to PDF
                                                </button>
                                            </div>
                                        </div>



                                        <br>
                                        <div>
                                            <span> <img style="height:20px;width:20px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt=""> - Verified - external sources.</span> <br><br>
                                            <span><img style="height:20px;width:20px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt=""> - Not verified - external sources.</span><br><br>
                                            <span> <img style="height:20px;width:20px;position:relative; top:-3px;" src="/assets/images/small/tick.png" alt=""> - API execution successful.</span> <br><br>
                                            <span><img style="height:20px;width:20px;position:relative; top:-3px;" src="/assets/images/small/cross.png" alt=""> - API execution unsuccessful.</span><br><br>
                                            <span><img style="height:20px;width:20px;position:relative; top:-3px;" src="/assets/images/question.png" alt=""> - No response from the source.</span><br><br>

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
                                                                            <th class="col-md-6 heading-fica-id" style="color:#ffffff;">Personal Information Captured</th>
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
                                                                                {{$selfbankingdetails?->FirstName}}


                                                                            </td>

                                                                            <td>
                                                                                @if ($namematch == 'Matched')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Second Name
                                                                            </td>
                                                                            <td>
                                                                                {{$selfbankingdetails?->SecondName}}


                                                                            </td>

                                                                            <td>
                                                                                @if ($secnamematch == 'Matched')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Third Name
                                                                            </td>
                                                                            <td>
                                                                                {{$selfbankingdetails?->ThirdName}}


                                                                            </td>

                                                                            <td>
                                                                                @if ($thirdnamematch == 'Matched')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Surname
                                                                            </td>
                                                                            <td>
                                                                                {{$selfbankingdetails?->Surname}}

                                                                            </td>

                                                                            <td>
                                                                                @if ($smatch == 'Matched')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                ID Number
                                                                            </td>
                                                                            <td>
                                                                                {{$selfbankingdetails?->IDNUMBER}}

                                                                            </td>

                                                                            <td>
                                                                                @if ($avs?->IDNUMBERMATCH == 'Yes')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Email
                                                                            </td>
                                                                            <td>
                                                                                {{$selfbankingdetails?->Email}}

                                                                            </td>

                                                                            <td>
                                                                                @if ($emailmatch == 'Matched')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif

                                                                            </td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Cellphone number
                                                                            </td>
                                                                            <td>
                                                                                {{$selfbankingdetails?->PhoneNumber}}

                                                                            </td>

                                                                            <td>
                                                                                @if ($cellmatch == 'Matched')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif
                                                                            </td>
                                                                        </tr>



                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table table-hover mb-0" id="downloadProfile">

                                                                    <thead>
                                                                        <tr>
                                                                            <th class="col-md-5 heading-fica-id" style="color:#ffffff;">SRN</th>
                                                                            <th class="col-md-6 heading-fica-id" style="color:#ffffff;">Companies</th>
                                                                            <th class="col-md-1 heading-fica-id" style="color:#ffffff;padding-left: 0px;">
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse ($SelfBankingCompanySRN as $CompanySRN)
                                                                        <tr>
                                                                            <td style="text-transform: uppercase;">{{ $CompanySRN->SRN }}</td>
                                                                            <td>{{ $CompanySRN?->companies }}</td>

                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="4">No exceptions found.</td>
                                                                        </tr>
                                                                    @endforelse
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
                                                                                Liveliness Detection
                                                                            </td>
                                                                            <td>
                                                                                @if ($dovs?->LivenessDetectionResult == 'Passed')
                                                                                Passed
                                                                                @else
                                                                                Failed
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if ($dovs?->LivenessDetectionResult != null)
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif

                                                                            </td>
                                                                        </tr>
                                                                        @if ($dovs?->ConsumerIDPhotoMatch == 'Matched' || $dovs?->ConsumerIDPhotoMatch == 'Not Matched')
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                ID Photo Match
                                                                            </td>
                                                                            <td>
                                                                                {{$dovs?->ConsumerIDPhotoMatch}}
                                                                            </td>
                                                                            <td>
                                                                                @if ($dovs?->ConsumerIDPhotoMatch =='Matched')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif

                                                                            </td>
                                                                        </tr>
                                                                        @else

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Error Description
                                                                            </td>
                                                                            <td>
                                                                                {{$dovs?->ConsumerIDPhotoMatch}}
                                                                            </td>
                                                                            <td>

                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">


                                                                            </td>
                                                                        </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Deceased Status
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->DeceasedStatus}}

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Birth Date
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->BirthDate}}

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Gender
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->Gender}}

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Title
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->TitleDesc}}

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Marital Status
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->MaritalStatusDesc}}

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Email Address
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->EmailAddress}}

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Home Cellphone No
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->CellularNo}}

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Home Telephone No
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->HomeTelephoneNo}}

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Work Telephone No
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->WorkTelephoneNo}}

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Postal Address
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->PostalAddress}}

                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Residential Address
                                                                            </td>
                                                                            <td>

                                                                                {{ $dovs?->ResidentialAddress}}

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

                                                                            <th style="width:50%;" class="text-center">
                                                                                Home Affairs ID Photo
                                                                            </th>
                                                                            <th style="width:50%;" class="text-center">
                                                                                Client Captured Photo
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:50%;" class="text-center">
                                                                                @if ($dovs?->ConsumerIDPhoto==NULL)
                                                                                <img src="/assets/images/ImageNotFound.png" alt="" style="height:260px;width:200px;" class="auth-logo-light">
                                                                                </img>
                                                                                @else
                                                                                <img src="data:image/png;base64,{{ $dovs?->ConsumerIDPhoto }}" alt="" style="height:260px;width:200px;" class="auth-logo-light">
                                                                                </img>
                                                                                @endif
                                                                            </td>
                                                                            <td style="width:50%;" class="text-center">
                                                                                @if ($dovs?->ConsumerCapturedPhoto==NULL)
                                                                                <img src="/assets/images/ImageNotFound.png" alt="" style="height:260px;width:200px;" class="auth-logo-light">
                                                                                </img>
                                                                                @else
                                                                                <img src="data:image/png;base64,{{ $dovs?->ConsumerCapturedPhoto }}" alt="" style="height:260px;width:200px;" class="auth-logo-light">
                                                                                </img>
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


                                            <div class="tab-pane fade" id="v-pills-summary" role="tabpanel" aria-labelledby="v-pills-summary-tab">

                                                <section>


                                                    <div class="col-md-12">

                                                        <div class="table-responsive">
                                                            <table class="table table-hover mb-0" id="downloadProfile">

                                                                <thead>
                                                                    <tr>
                                                                        <th class="col-md-5 heading-fica-id" style="color:#ffffff;">Status</th>
                                                                        <th class="col-md-6 heading-fica-id" style="color:#ffffff;">Comments</th>
                                                                        <th class="col-md-1 heading-fica-id" style="color:#ffffff;padding-left: 0px;">
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse ($exceptions as $exception)
                                                                    <tr>
                                                                        <td>{{ $exception->Status }}</td>
                                                                        <td>{{ $exception->Comment }}</td>

                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4">No exceptions found.</td>
                                                                    </tr>
                                                                @endforelse
                                                                </tbody>

                                                            </table>
                                                        </div>


                                                    </div>

                                                </section>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-docs" role="tabpanel" aria-labelledby="v-pills-docs-tab">

                                                <section>


                                                    <div class="col-md-12">
                                                        <div class="heading-fica-id">
                                                            <div class="text-center">
                                                                <h5 style="color: #fff; padding-top:8px;padding-bottom: 8px;padding-left: 11px;">
                                                                    Uploaded Documents
                                                                </h5>
                                                            </div>
                                                        </div>

                                                        <div class="row d-flex justify-content-center">


                                                            <div class="col-sm-6">
                                                                <div class="card" id="card" style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                                                                    <div class="card-body">
                                                                        <div class="d-flex align-items-center mb-3">
                                                                            <div class="avatar-xs me-3">
                                                                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary" style="background-color: #52bdee; background-image: linear-gradient(315deg, #52bdee 0%, #52bdee 74%);">
                                                                                    <i class="mdi mdi-account-details font-size-24" style="color: rgb(0, 0, 0);"></i>
                                                                                </span>
                                                                            </div>
                                                                            <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">
                                                                                Identity Document
                                                                            </h3>
                                                                        </div>
                                                                        @if ($iddoc == NULL)
                                                                        <div class="mt-4">
                                                                            <h5 class="text-center font-size-16 mb-0" style="font-size: 18px; color: black">
                                                                                No file was uploaded
                                                                            </h5>
                                                                        </div>
                                                                    @elseif ($iddoc != NULL)
                                                                        <div class="mt-4">
                                                                            <a href="{{ $iddoc }}" class="btn btn-primary w-md" target="_blank" style="background-color: #93186c; border-color: #93186c">
                                                                                View
                                                                            </a>

                                                                        </div>
                                                                    @endif
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="col-sm-6">
                                                                <div class="card" id="card" style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                                                                    <div class="card-body">
                                                                        <div class="d-flex align-items-center mb-3">
                                                                            <div class="avatar-xs me-3">
                                                                                <span class="avatar-title rounded-circle bg-primary bg-soft text-primary" style="background-color: #52bdee; background-image: linear-gradient(315deg, #52bdee 0%, #52bdee 74%);">
                                                                                    <i class="mdi mdi-bank font-size-24" style="color: rgb(0, 0, 0);"></i>
                                                                                </span>
                                                                            </div>
                                                                            <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">
                                                                                Proof of Banking Document
                                                                            </h3>
                                                                        </div>
                                                                        @if ($avs?->Bank_File_Path ==NULL)
                                                                        <div class="mt-4">
                                                                            <h5 class="text-center font-size-16 mb-0" style="font-size: 18px; color: black">
                                                                                No file was uploaded
                                                                            </h5>
                                                                        </div>

                                                                        @elseif ($avs?->Bank_File_Path !=NULL)
                                                                        <div class="mt-4">

                                                                            <a href="{{ $avs?->Bank_File_Path }}" class="btn btn-primary w-md" target="_blank" style="background-color: #93186c; border-color: #93186c">
                                                                                View
                                                                            </a>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>

                                                </section>
                                            </div>

                                            <div class="tab-pane fade" id="v-pills-actions" role="tabpanel" aria-labelledby="v-pills-actions-tab">
                                                <form method="POST" id="form-actions" action="{{ route('sb-results',['id'=>$selfbankingdetails?->SelfBankingDetailsId]) }}">

                                                    @csrf
                                                    <section>


                                                        <div class="col-md-12">
                                                            <div class="heading-fica-id">
                                                                <div class="text-center">
                                                                    <h5 style="color: #fff; padding-top:8px;padding-bottom: 8px;padding-left: 11px;">
                                                                        Actions
                                                                    </h5>
                                                                </div>
                                                            </div>

                                                            <div class="row d-flex justify-content-center">
                                                                <div class="col-sm-12">
                                                                    <div class="mt-2 mb-2 text-center">
                                                                        <h5>Accept or Reject Service banking user info.</h5>
                                                                    </div>


                                                                    <div class="row mt-3">

                                                                        <div class="col-lg-12">
                                                                            <div class="mb-3">
                                                                                <label for="basicpill-firstname-input">Flow Status </label>
                                                                                <select required class="form-select" autocomplete="off" class="form-control" id="avsStatus" name="avsStatus">

                                                                                    <option value="" selected disabled style="font-size: 12px;">
                                                                                        Please select flow status
                                                                                    </option>
                                                                                    <option value="Completed" style="font-size: 12px;">
                                                                                        Completed
                                                                                    </option>
                                                                                    <option value="Rejected" style="font-size: 12px;">
                                                                                        Rejected
                                                                                    </option>


                                                                                </select>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="mb-3">
                                                                                <label for="basicpill-firstname-input">Reason for update (optional)</label>
                                                                                <textarea id="reason" name="reason" class="form-control" id="" cols="30" rows="4" placeholder="Provide a reason for updating"></textarea>

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="mt-3 text-center">

                                                                        <button type="button" class="btn w-md text-white" id="btn-action" style="background-color: #91C60F; border-color: #91C60F;">Submit</button>

                                                                    </div>



                                                                </div>


                                                            </div>
                                                        </div>

                                                    </section>
                                                </form>
                                                <div class="col-md-12 mt-3">

                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0" id="downloadProfile">

                                                            <thead>
                                                                <tr>
                                                                    <th class="col-md-3 heading-fica-id" style="color:#ffffff;">Action From</th>
                                                                    <th class="col-md-3 heading-fica-id" style="color:#ffffff;">Action To</th>
                                                                    <th class="col-md-3 heading-fica-id" style="color:#ffffff;padding-left: 0px;">Comment
                                                                    </th>
                                                                    <th class="col-md-3 heading-fica-id" style="color:#ffffff;padding-left: 0px;">Date
                                                                    </th>
                                                                    <th class="col-md-3 heading-fica-id" style="color:#ffffff;padding-left: 0px;">Admin
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($SbActions as $SbAction)
                                                                <tr>
                                                                    <td>{{ $SbAction->ActionFrom }}</td>
                                                                    <td>{{ $SbAction->ActionTo }}</td>
                                                                    <td>{{ $SbAction->Comment }}</td>
                                                                    <td>{{ $SbAction->CreatedAt }}</td>
                                                                    <td>{{ $SbAction->Admin_User }}</td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="4">No previous actions have been done.</td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>

                                                        </table>
                                                    </div>


                                                </div>
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
                                                                                {{$avs?->Account_name}}
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Bank Name
                                                                            </td>
                                                                            <td>
                                                                                {{$avs?->Bank_name}}
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account Number
                                                                            </td>
                                                                            <td>
                                                                                {{$avs?->Account_no}}
                                                                            </td>
                                                                            <td>

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Branch Code
                                                                            </td>
                                                                            <td>
                                                                                {{$avs?->Branch_code}}
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

                                                                                @if ($avs?->AVS_Status == '1')
                                                                                AVS Completed
                                                                                @elseif($avs?->AVS_Status == '-1')
                                                                                AVS Incomplete
                                                                                @else
                                                                                Not Available
                                                                                @endif

                                                                            </td>
                                                                            <td>
                                                                                @if ($avs?->AVS_Status == '1')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Initials Match
                                                                            </td>
                                                                            <td>
                                                                                {{$avs?->INITIALSMATCH}}
                                                                            </td>
                                                                            <td>
                                                                                @if ($avs?->INITIALSMATCH == 'Yes')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif


                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Surname Match
                                                                            </td>
                                                                            <td>
                                                                                {{$avs?->SURNAMEMATCH}}
                                                                            </td>
                                                                            <td>
                                                                                @if ($avs?->SURNAMEMATCH == 'Yes')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif


                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                ID Number Match
                                                                            </td>
                                                                            <td>
                                                                                {{$avs?->IDNUMBERMATCH}}
                                                                            </td>
                                                                            <td>
                                                                                @if ($avs?->IDNUMBERMATCH == 'Yes')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Email Address Match
                                                                            </td>
                                                                            <td>
                                                                                {{$avs?->EMAILMATCH}}
                                                                            </td>
                                                                            <td>

                                                                                @if ($avs?->EMAILMATCH == 'Yes')
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/greencircle.png" alt="">
                                                                                @else
                                                                                <img style="height:24px;width:24px;position:relative; top:-3px;" src="/assets/images/redcircle.png" alt="">
                                                                                @endif
                                                                            </td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td style="font-weight: bold;">
                                                                                Account Active
                                                                            </td>
                                                                            <td>
                                                                                {{$avs?->ACCOUNT_OPEN}}
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
                                                                                {{$avs?->ACCOUNTDORMANT}}
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
                                                                                {{$avs?->ACCOUNTOPENFORATLEASTTHREEMONTHS}}
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
                                                                                {{$avs?->ACCOUNTACCEPTSDEBITS}}
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
                                                                                {{$avs?->Bank_name}}
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

                                                                                @if ($avs?->BankTypeid != null)
                                                                                Yes
                                                                                @else
                                                                                No
                                                                                @endif

                                                                            </td>
                                                                            <td>

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

                            </div>

                        </div>


                    </div>

                </div>

            </div>
        </div>

    </div>
     <!-- email Modal -->

     <form class="form-horizontal" method="POST" id="form-email"
     action="{{ route('send-email',['id'=>$selfbankingdetails?->SelfBankingDetailsId]) }}">

     @csrf

     <div class="modal fade" id="composemessage" tabindex="-1" role="dialog"
         aria-labelledby="composemessageTitle" aria-hidden="true">

         <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                 <div class="modal-header">

                     <h4 class="card-title mb-2 d-flex justify-content-left"
                         style="font-size: 18px;margin-bottom: 0px;margin-top: 8px;">
                         Send an Email
                     </h4>

                     <button type="button" class="btn-close"
                         data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">

                     <div class="mb-3">
                         <input type="email" id="Email" name="Email"
                             required class="form-control"
                             value="{{ $selfbankingdetails?->Email }}" readonly>
                     </div>

                     <div class="mb-3">
                         <input type="text" id="Subject" name="Subject"
                             class="form-control" placeholder="Subject" >
                     </div>

                     <div class="mb-3">
                         <div>
                             <textarea required placeholder="Message" id="EmailMessage" name="EmailMessage" class="form-control" maxlength="250"
                                 rows="4"></textarea>
                         </div>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary"
                         style="background-color: #93186c; border-color: #93186c; color:white; width:78px"
                         data-bs-dismiss="modal">Close</button>
                     <button type="button" disabled class="btn btn-primary" id="btn-email"
                         style="background-color: #93186c; border-color: #93186c; color:white;">Send
                         <i class="fab fa-telegram-plane ms-1"></i></button>
                 </div>
             </div>
         </div>
     </div>

 </form>
 <!-- end modal -->


</div>


@endsection


@section('script')

<script>
    document.getElementById('btn-action').addEventListener('click', function() {
        // Submit the form actions
        document.getElementById('form-actions').submit();
    });

    document.getElementById('btn-email').addEventListener('click', function() {
        // Submit the emails form
        document.getElementById('form-email').submit();
    });
</script>
<script>
    const subjectInput = document.getElementById('Subject');
    const messageInput = document.getElementById('EmailMessage');
    const sendButton = document.getElementById('btn-email');

    // Disable the button initially
    sendButton.disabled = true;

    // Function to check if both fields are filled
    function checkInputFields() {
        if (subjectInput.value.trim() !== "" && messageInput.value.trim() !== "") {
            sendButton.disabled = false;  // Enable button if both fields are not empty
        } else {
            sendButton.disabled = true;   // Disable button if one or both fields are empty
        }
    }

    // Listen for input changes in both the Subject and Message fields
    subjectInput.addEventListener('input', checkInputFields);
    messageInput.addEventListener('input', checkInputFields);
</script>

<script>
    function generate() {

        var doc = new jsPDF('p', 'pt', 'letter');

        var avsStatus = "<?= $avs?->AVS_Status; ?>";
        var dovsStatus = "<?= $dovs?->DOVS_Status; ?>";

        var avs = '';
        if (avsStatus == '1') {
            avs = 'Passed';
        } else if (avsStatus == '-1') {
            avs = 'Failed';
        }
        else
        {
            avs = 'Not Available'
        }
        var SelfBankingCompanySRN = <?= json_encode($SelfBankingCompanySRN); ?>;
        var AddData = [];
        //console.log(SelfBankingCompanySRN)
        var UserFullName = ("<?= $UserFullName; ?>" != null) ? "<?= $UserFullName; ?>" : '';
        var FirstName = ("<?= $selfbankingdetails?->FirstName ?>" != null) ? "<?= $selfbankingdetails?->FirstName; ?>" : '';
        var SecondName = ("<?= $selfbankingdetails?->SecondName ?>" != null) ? "<?= $selfbankingdetails?->SecondName; ?>" : '';
        var ThirdName = ("<?= $selfbankingdetails?->ThirdName ?>" != null) ? "<?= $selfbankingdetails?->ThirdName; ?>" : '';
        var namematch = ("<?= $namematch ?>" != null) ? "<?= $namematch; ?>" : '';
        var secnamematch = ("<?= $secnamematch ?>" != null) ? "<?= $secnamematch; ?>" : '';
        var thirdnamematch = ("<?= $thirdnamematch ?>" != null) ? "<?= $thirdnamematch; ?>" : '';

        var surname = ("<?= $selfbankingdetails?->Surname; ?>" != null) ? "<?= $selfbankingdetails?->Surname; ?>" : '';
        var phone = ("<?= $selfbankingdetails?->PhoneNumber; ?>" != null) ? "<?= $selfbankingdetails?->PhoneNumber; ?>" : '';
        var idnum = ("<?= $selfbankingdetails?->IDNUMBER; ?>" != null) ? "<?= $selfbankingdetails?->IDNUMBER; ?>" : '';
        var idnummatch = ("<?= $avs?->IDNUMBERMATCH ?>" != null) ? "<?= $avs?->IDNUMBERMATCH; ?>" : '';
        if (idnummatch == 'Yes') {
            idnummatch = "Matched";
        } else {
            idnummatch = "Unmatched";

        }
        var Email = ("<?= $selfbankingdetails?->Email; ?>" != null) ? "<?= $selfbankingdetails?->Email; ?>" : '';
        var Bank_name = ("<?= $avs?->Bank_name; ?>" != null) ? "<?= $avs?->Bank_name; ?>" : '';
        var Branch_code = ("<?= $avs?->Branch_code; ?>" != null) ? "<?= $avs?->Branch_code; ?>" : '';
        var Account_name = ("<?= $avs?->Account_name; ?>" != null) ? "<?= $avs?->Account_name; ?>" : '';
        var Account_no = ("<?= $avs?->Account_no; ?>" != null) ? "<?= $avs?->Account_no; ?>" : '';
        var accopen = ("<?= $avs?->ACCOUNT_OPEN; ?>" != null) ? "<?= $avs?->ACCOUNT_OPEN; ?>" : '';
        var accdormant = ("<?= $avs?->ACCOUNTDORMANT; ?>" != null) ? "<?= $avs?->ACCOUNTDORMANT; ?>" : '';
        var accthreemonths = ("<?= $avs?->ACCOUNTOPENFORATLEASTTHREEMONTHS; ?>" != null) ? "<?= $avs?->ACCOUNTOPENFORATLEASTTHREEMONTHS; ?>" : '';
        var accdebit = ("<?= $avs?->ACCOUNTACCEPTSDEBITS; ?>" != null) ? "<?= $avs?->ACCOUNTACCEPTSDEBITS; ?>" : '';
        var acc = ("<?= $avs?->BankTypeid; ?>" != null) ? 'Passed' : 'Failed';
        var PersonalDetails =  ("<?= $selfbankinglink->PersonalDetails; ?>" != null) ? "<?= $selfbankinglink->PersonalDetails; ?>" : '';
        var BankingDetails = ("<?= $selfbankinglink->BankingDetails; ?>" != null) ? "<?= $selfbankinglink->BankingDetails; ?>" : '';
        var DOVS = ("<?= $selfbankinglink->DOVS; ?>" != null) ? "<?= $selfbankinglink->DOVS; ?>" : '';
        var personaldet = '';
        var bankingdet = '';
        var dovsdet = '';
        if (PersonalDetails =='1')
        {
            personaldet = 'Passed';
        }
        else if (PersonalDetails =='-2')
        {
            personaldet = 'Failed';
        }
        else if (PersonalDetails =='2')
        {
            personaldet = 'Needs Review';
        }
        else
        {
            personaldet = 'In Progress';
        }

        //banking details
        if (BankingDetails =='1')
        {
            bankingdet = 'Passed';
        }
        else if (BankingDetails =='-2')
        {
            bankingdet = 'Failed';
        }
        else if (BankingDetails =='2')
        {
            bankingdet = 'Needs Review';
        }
        else
        {
            bankingdet = 'In Progress';
        }
        //faceview
        if (DOVS =='1')
        {
            dovsdet = 'Passed';
        }
        else if (DOVS =='-2')
        {
            dovsdet  = 'Failed';
        }
        else if (DOVS =='2')
        {
            dovsdet  = 'Needs Review';
        }
        else
        {
            dovsdet  = 'In Progress';
        }
        /*

                                @if ($selfbankinglink->DOVS == "1")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: #028E41 !important;" class="float-end text-black">Passed</span>
                                </div>
                            @elseif ($selfbankinglink->DOVS == "-2")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: red !important;" class="float-end text-black">Failed</span>
                                </div>
                            @elseif ($selfbankinglink->DOVS == "2")
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: rgb(231, 103, 18) !important;" class="float-end text-black">Needs Review</span>
                                </div>
                            @else
                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span style="color: orange !important;" class="float-end text-black">In Progress</span>
                                </div>
                            @endif
*/

        var LivenessDetectionResult = ("<?= $dovs?->LivenessDetectionResult; ?>" != null) ? "<?= $dovs?->LivenessDetectionResult; ?>" : '';
        var ConsumerIDPhotoMatch = ("<?= $dovs?->ConsumerIDPhotoMatch; ?>" != null) ? "<?= $dovs?->ConsumerIDPhotoMatch; ?>" : '';
        var DeceasedStatus = ("<?= $dovs?->DeceasedStatus; ?>" != null) ? "<?= $dovs?->DeceasedStatus; ?>" : '';
        var initialsmatch = ("<?= $avs?->INITIALSMATCH ?>" == 'Yes') ? 'Matched' : 'Unmatched';

        //var initials = ("<?= $avs?->INITIALS; ?>" != null) ? "<?= $avs?->INITIALS; ?>" : '';
        var initials =  ("<?= $sbdetails->AccountHolderInitial; ?>" != null) ? "<?= $sbdetails->AccountHolderInitial; ?>" : '';
        var EMAILMATCHstatus = ("<?= $avs?->EMAILMATCH ?>" == 'Yes') ? 'Matched' : 'Unmatched';
        var surnamematch = ("<?= $avs?->SURNAMEMATCH ?>" == 'Yes') ? 'Matched' : 'Unmatched';

        var AVSStatusmatch = 'Unmatched';
        if (avsStatus == '1') {
            AVSStatusmatch = 'Matched';
        }
        var EnquiryDate = ("<?= $selfbankingdetails?->EnquiryDate; ?>" != null) ? "<?= $selfbankingdetails?->EnquiryDate; ?>" : '';
        var EnquiryInput = ("<?= $selfbankingdetails?->EnquiryInput; ?>" != null) ? "<?= $selfbankingdetails?->EnquiryInput; ?>" : '';

        // Variables End
        var htmlstring = '';
        var tempVarToCheckPageHeight = 0;
        var pageHeight = 0;


        var HomeAffPhoto = 'data:image/png;base64,<?php echo $dovs?->ConsumerIDPhoto; ?>';
        var CapturedPhoto = 'data:image/png;base64,<?php echo $dovs?->ConsumerCapturedPhoto; ?>';

        var tick = 'data:image/png;base64,<?php echo base64_encode(file_get_contents("assets/images/small/tick.png")); ?>';
        var cross = 'data:image/png;base64,<?php echo base64_encode(file_get_contents("assets/images/small/cross.png")); ?>';
        var questionmark = 'data:image/png;base64,<?php echo base64_encode(file_get_contents("assets/images/not-completed.png")); ?>';
        var question = 'data:image/png;base64,<?php echo base64_encode(file_get_contents("assets/images/question.png")); ?>';
        var inspiritlogo = 'data:image/png;base64,' + '<?php echo base64_encode(file_get_contents("assets/images/PoweredBy.png")); ?>';
        var VerificationStaticPhoto = 'data:image/png;base64,' + '<?php echo base64_encode(file_get_contents("images/results/client1.png")); ?>';
        var PaymentPhoto = 'data:image/png;base64,' + '<?php echo base64_encode(file_get_contents("images/results/AVS.png")); ?>';
        var FacialPhoto = 'data:image/png;base64,' + '<?php echo base64_encode(file_get_contents("images/results/facephone4.png")); ?>';
        var bgColour = "#93186c";

        var ConsumerIDPhotoAlt = 'data:image/png;base64,' + '<?php echo base64_encode(file_get_contents("assets/images/ImageNotFound.png")); ?>';
        var logo = 'data:image/png;base64,' + '<?php echo base64_encode(file_get_contents($Logo)); ?>';

        var custID = ("<?= $customer?->CustomerID; ?>" != null) ? "<?= $customer?->CustomerID; ?>" : '';
        const date = new Date();

        var MaritalStatus = ("<?= $dovs?->MaritalStatusDesc; ?>" != null) ? "<?= $dovs?->MaritalStatusDesc; ?>" : '';
        var BirthDate = ("<?= $dovs?->BirthDate; ?>" != null) ? "<?= $dovs?->BirthDate; ?>" : '';
        var Gender = ("<?= $dovs?->Gender; ?>" != null) ? "<?= $dovs?->Gender; ?>" : '';
        var Title = ("<?= $dovs?->TitleDesc; ?>" != null) ? "<?= $dovs?->TitleDesc; ?>" : '';
        var EmailAddress = ("<?= $dovs?->EmailAddress; ?>" != null) ? "<?= $dovs?->EmailAddress; ?>" : '';
        var CellularNo = ("<?= $dovs?->CellularNo; ?>" != null) ? "<?= $dovs?->CellularNo; ?>" : '';
        var HomeTelephoneNo = ("<?= $dovs?->HomeTelephoneNo; ?>" != null) ? "<?= $dovs?->HomeTelephoneNo; ?>" : '';
        var WorkTelephoneNo = ("<?= $dovs?->WorkTelephoneNo; ?>" != null) ? "<?= $dovs?->WorkTelephoneNo; ?>" : '';
        var PostalAddress = ("<?= $dovs?->PostalAddress; ?>" != null) ? "<?= $dovs?->PostalAddress; ?>" : '';
        var ResidentialAddress = ("<?= $dovs?->ResidentialAddress; ?>" != null) ? "<?= $dovs?->ResidentialAddress; ?>" : '';

        var CreatedOnDate = ("<?= $selfbankingdetails->CreatedOnDate; ?>" != null) ? "<?= $selfbankingdetails->CreatedOnDate; ?>" : '';
        var ha_name = ("<?= $ha_name; ?>" != null) ? "<?= $ha_name; ?>" : '';
        var ha_secondname = ("<?= $ha_secondname; ?>" != null) ? "<?= $ha_secondname; ?>" : '';
        var ha_surname = ("<?= $ha_surname; ?>" != null) ? "<?= $ha_surname; ?>" : '';
        var FICAStatus = ("<?= $FICAStatus; ?>" != null) ? "<?= $FICAStatus; ?>" : '';


     // Format date
        const formattedDate = date.toLocaleDateString('en-GB', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

        // Format time
        const formattedTime = date.toLocaleTimeString('en-GB', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false  // 24-hour format, set to true for 12-hour format
        });

        // Combine date and time
        const dateTime = `${formattedDate} ${formattedTime}`;


        if (custID != '47B97C4A-E9F6-4283-BDB5-D500CA8851C1')
            doc.addImage(logo, 'png', 45, 25, 110, 40, undefined, 'FAST');

        doc.addImage(inspiritlogo, 'png', 470, 25, 100, 40, undefined, 'FAST'); //inspirit logo
        doc.setFont("Avenir");
        doc.setFontSize(6);


        doc.autoTable({
            head: [
                ['Self Service Banking Report']
            ]
            , body: []
            , startY: 70
            , styles: {
                fontSize: 14
                , font: 'Avenir'
                , textColor: [0, 0, 0]
            }
            , columnStyles: {
                0: {
                    cellWidth: 100
                , }
                , halign: 'center'
            }
            , headStyles: {
                fillColor: bgColour
                , textColor: [255, 255, 255]
                , halign: 'center'
            }
        , });

        pageHeight = doc.internal.pageSize.height;
        specialElementHandlers = {
            '#bypassme': function(element, renderer) {
                return true;
            }
        };

        margins = {
            top: 100
            , bottom: 60, // Adjust the bottom margin value as needed
            left: 20
            , right: 20
            , width: 700
            , height: 700
        , };

        doc.setFontSize(8);

        doc.autoTable({
            body: [
                ['Extracted By:', `${UserFullName}`, 'Extracted For:', `${FirstName} ${surname}`]
                , ['Date of Report:', `${dateTime}`, 'Identity Number:', `${idnum}`],

            ]
            , startY: 100
            , styles: {
                fontSize: 8
                , font: 'Avenir'
                , textColor: [0, 0, 0]
            }
            , columnStyles: {
                0: {
                    cellWidth: 150
                    , fontStyle: 'bold'
                }
                , 1: {
                    cellWidth: 120
                }
                , 2: {
                    cellWidth: 140
                    , fontStyle: 'bold'
                }
                , 3: {
                    cellWidth: 120
                }
            }
            , headStyles: {
                fillColor: bgColour
                , textColor: [255, 255, 255]
            }
        , });

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

        //if (dovsStatus == '1')
        /*{
            doc.autoTable({
                head: [
                    ['Facial Recognition']
                ]
                , body: []
                , startY: doc.lastAutoTable.finalY + 20
                , styles: {
                    fontSize: 8
                    , font: 'Avenir'
                    , textColor: [0, 0, 0]
                }
                , columnStyles: {
                    0: {
                        cellWidth: 100
                        , fontStyle: 'bold'
                        , halign: 'left'
                    }
                , }
                , headStyles: {
                    fillColor: bgColour
                    , textColor: [255, 255, 255]
                    , halign: 'left'
                }
            , });
        }

       // if (dovsStatus == '1')
        {

            // First Image
            var firstImageX = 250; //95; //250
            var firstImageY = 230; ////215;
            var firstImageWidth = 75;
            var firstImageHeight = 100;


            // Add text centered on top of the first image frame
            doc.setFontSize(10);
            var firstImageTextX = firstImageX + firstImageWidth / 2;
            var firstImageTextY = firstImageY - 10;
            doc.text('DHA Captured Photo', firstImageTextX - 120, firstImageTextY - 20, {
                align: 'center'
            });

            if ('<?php echo $dovs?->ConsumerIDPhoto; ?>' !== "")
            {

                doc.addImage(HomeAffPhoto, 'png', firstImageX - 120, firstImageY - 20, firstImageWidth, firstImageHeight, undefined, 'FAST');
            }
                else
                {
                doc.addImage(ConsumerIDPhotoAlt, 'png', firstImageX - 120, firstImageY - 20, firstImageWidth, firstImageHeight, undefined, 'FAST');
        }


            pageWidth = pageWidth * 3;
            if (ConsumerIDPhotoMatch == "Matched" && LivenessDetectionResult == "Passed") {
                doc.addImage(tick, 'png', firstImageX, firstImageY - 20, firstImageWidth, firstImageHeight - 30, undefined, 'FAST');
            } else {
                doc.addImage(cross, 'png', firstImageX, firstImageY - 20, firstImageWidth, firstImageHeight - 30, undefined, 'FAST');
            }
            doc.text('Consumer Captured Photo', firstImageTextX + 120, firstImageTextY - 20, {
                align: 'center'
            });
            if ('<?php echo $dovs?->ConsumerCapturedPhoto; ?>' !== "")
                doc.addImage(CapturedPhoto, 'png', firstImageX + 120, firstImageY - 20, firstImageWidth, firstImageHeight, undefined, 'FAST');
            else
                doc.addImage(ConsumerIDPhotoAlt, 'png', firstImageX + 120, firstImageY - 20, firstImageWidth, firstImageHeight, undefined, 'FAST');

        } */


               doc.autoTable({
            head: [
                ['Flow Status Summary', '', '']
            ]
            , body: [
                ['Date Started:', `${CreatedOnDate}`, ``]
                , ['Full names :', `${ha_name} ${ha_secondname} ${ha_surname}`, ``]
                , ['Identity:', `${idnum }`, ``]
                , ['Personal Information Captured:', `${personaldet }`, ``]
                , ['Banking Details:', `${bankingdet }`, ``]
                , ['Face view :', `${dovsdet }`, ``]
                , ['Flow Overral Status :', `${FICAStatus }`, ``]
                //['Telephone (C):', `${CellCode}${CellNo}`, 'Date of Birth:', `${BirthDate}`],
                //['ID Date of Issue:', `${ID_DateofIssue}`, 'Country of Birth:', `${ID_CountryResidence}`],
                //['Employment Industry:', `${Industryofoccupation}`,'Employment Status:', `${Employmentstatus}`],
                //['Name Of Employer:', `${Nameofemployer}`],
            ],
            didDrawCell: function (data) {
        // Insert the image into the third column, first row
        if (data.column.index === 2 && data.row.index === 6) {
            // Position the image within the cell
            if (FICAStatus=='Completed')
            doc.addImage(tick, 'PNG', data.cell.x + 2, data.cell.y + 5, 10, 10); // Adjust size and position
        else
        doc.addImage(cross, 'PNG', data.cell.x + 2, data.cell.y + 5, 10, 10); // Adjust size and position
        }
    }
            , startY: doc.lastAutoTable.finalY + 20
            , styles: {
                fontSize: 8
                , font: 'Avenir'
                , textColor: [0, 0, 0]
            }
            , columnStyles: {
                0: {
                    cellWidth: 220
                    , fontStyle: 'bold'
                }
                , 1: {
                    cellWidth: 230
                },
                /* 2: {
                    cellWidth: 110,
                    fontStyle: 'bold'
                }, */
                2: {
                    cellWidth: 80
                }
            }
            , headStyles: {
                fillColor: bgColour
                , textColor: [255, 255, 255]
            }
        , });





        var startofscreening =20;
        doc.autoTable({
            head: [
                ['Screening Indicators']
            ]
            , body: []
            , startY: doc.lastAutoTable.finalY + startofscreening
            , styles: {
                fontSize: 8
                , font: 'Avenir'
                , textColor: [0, 0, 0]
            }
            , columnStyles: {
                0: {
                    cellWidth: 100
                    , fontStyle: 'bold'
                    , halign: 'left'
                }
            }
            , headStyles: {
                fillColor: bgColour
                , textColor: [255, 255, 255]
                , halign: 'left'
            }
        , });

        var tickfromheight = doc.lastAutoTable.finalY + 8;
        var iconfromheight = doc.lastAutoTable.finalY + 30;
        var icontextfromheight = doc.lastAutoTable.finalY + 90;

        var i = 100;

        {
            doc.addImage(tick, 'png', i+85, tickfromheight, 20, 20, undefined, 'FAST');
        }



        doc.addImage(VerificationStaticPhoto, 'png',i+ 70, iconfromheight, 50, 50);
        doc.text('Personal Information Captured', i+94, icontextfromheight, {
            align: 'center'
            , fontSize: 2
        });





       // if (dovsStatus == '1')
        {
            if (idnummatch == 'Matched') {
                doc.addImage(tick, 'png', i + 180, tickfromheight, 20, 20, undefined, 'FAST');
            } else {
                doc.addImage(cross, 'png', i + 180, tickfromheight, 20, 20, undefined, 'FAST');
            }
            doc.addImage(FacialPhoto, 'png', i + 165, iconfromheight, 50, 50, undefined, 'FAST');
            doc.text('Face View', i + 189, icontextfromheight, {
                align: 'center'
                , fontSize: 2
            });
            i = i + 90;
        }


      //  if (avsStatus == '1')
      {
            if (avs == 'Passed') {
                doc.addImage(tick, 'png', i + 180, tickfromheight, 20, 20, undefined, 'FAST');
            } else if (avs == 'Failed') {
                doc.addImage(cross, 'png', i + 180, tickfromheight, 20, 20, undefined, 'FAST');
            } else {
                doc.addImage(question, 'png', i + 180, tickfromheight, 20, 20, undefined, 'FAST');
            }
            doc.addImage(PaymentPhoto, 'png', i + 165, iconfromheight, 50, 50, undefined, 'FAST');
            doc.text('Bank', i + 189, icontextfromheight, {
                align: 'center'
                , fontSize: 2
            });
            i = i + 90;
        }



        // Define the text to be placed in the center
        var text = "Verification checks completed successfully.";
        var text2 = "Verification checks did not complete successfully.";
        var text3 = "No response from verification checks."; //assets/images/question.png

        // Get the width of the text
        var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize();

        // Get the width of the document
        var pageWidth = doc.internal.pageSize.getWidth();

        // Calculate the position to place the text in the center
        var xPos = (pageWidth - textWidth) / 2;
        doc.setFont("helvetica", "normal");
        doc.setFontSize(8);

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
            startY: doc.lastAutoTable.finalY + 110
            , styles: {
                fontSize: 8
                , font: 'Avenir'
                , textColor: [0, 0, 0]
                , cellPadding: 5
            , }
            , columnStyles: {
                0: {
                    cellWidth: 240
                    , fontStyle: 'bold'
                    , halign: 'left'
                }
                , 1: {
                    cellWidth: 290
                    , halign: 'left'
                }
            , }
        , });




        // Personal Details
        doc.autoTable({
            head: [
                ['Personal Information Captured', 'Result', 'Verified']
            ]
            , body: [
                ['First name:', `${FirstName}`, `${namematch}`]
                ,['Second Name:', `${SecondName}`, `${secnamematch}`]
                ,['Third Name:', `${ThirdName}`, `${thirdnamematch}`]
                ,['Surname:', `${surname}`, `${surnamematch}`]
                , ['Email:', `${Email}`, `${EMAILMATCHstatus}`]
                , ['Phone (C):', `${phone }`],

                //['Telephone (C):', `${CellCode}${CellNo}`, 'Date of Birth:', `${BirthDate}`],
                //['ID Date of Issue:', `${ID_DateofIssue}`, 'Country of Birth:', `${ID_CountryResidence}`],
                //['Employment Industry:', `${Industryofoccupation}`,'Employment Status:', `${Employmentstatus}`],
                //['Name Of Employer:', `${Nameofemployer}`],
            ]
            , startY: doc.lastAutoTable.finalY + 20
            , styles: {
                fontSize: 8
                , font: 'Avenir'
                , textColor: [0, 0, 0]
            }
            , columnStyles: {
                0: {
                    cellWidth: 220
                    , fontStyle: 'bold'
                }
                , 1: {
                    cellWidth: 230
                },
                /* 2: {
                    cellWidth: 110,
                    fontStyle: 'bold'
                }, */
                2: {
                    cellWidth: 80
                }
            }
            , headStyles: {
                fillColor: bgColour
                , textColor: [255, 255, 255]
            }
        , });

        SelfBankingCompanySRN.forEach((element, index) => {

            var temp = [
                element.SRN.toUpperCase(),
                element.companies,
            ]
            AddData.push(temp)
            })

            console.log(AddData);

            if (AddData.length > 0) {

            doc.autoTable({

                head: [
                    ['SRN', 'Companies']
                ],
                body: AddData,
                startY: doc.lastAutoTable.finalY + 7,
                styles: {
                    fontSize: 8,
                    font: 'Avenir',
                    textColor: [0, 0, 0]
                },

                headStyles: {
                    fillColor: bgColour,
                    textColor: [255, 255, 255]
                },
            });
            } else {

            doc.autoTable({
                head: [
                    ['SRN', 'Companies']
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

                headStyles: {
                    fillColor: bgColour,
                    textColor: [255, 255, 255],

                },

            });


            }
            doc.addPage();

        doc.autoTable({
    head: [
        ['Facial Recognition']
    ],
    body: [],
    //startY: doc.lastAutoTable ? doc.lastAutoTable.finalY + 7 : 20, // Ensures images are placed after table
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
    }
});

// Get the Y position after the table
var lastY = doc.lastAutoTable.finalY + 10; // Adjust as needed for spacing

// Set the position for the first image
var firstImageX = 280;
var firstImageY = lastY + 20; // Adjust for spacing under table
var firstImageWidth = 75;
var firstImageHeight = 100;

// Add text centered on top of the first image frame
doc.setFontSize(10);
var firstImageTextX = firstImageX + firstImageWidth / 2;
var firstImageTextY = firstImageY - 10;
doc.text('DHA Captured Photo', firstImageTextX - 120, firstImageTextY, {
    align: 'center'
});

if ('<?php echo $dovs?->ConsumerIDPhoto; ?>' !== "") {
    doc.addImage(HomeAffPhoto, 'png', firstImageX - 120, firstImageY, firstImageWidth, firstImageHeight, undefined, 'FAST');
} else {
    doc.addImage(ConsumerIDPhotoAlt, 'png', firstImageX - 120, firstImageY, firstImageWidth, firstImageHeight, undefined, 'FAST');
}

if (ConsumerIDPhotoMatch == "Matched" && LivenessDetectionResult == "Passed") {
                doc.addImage(tick, 'png', firstImageX, firstImageY +10, firstImageWidth, firstImageHeight - 30, undefined, 'FAST');
            } else {
                doc.addImage(cross, 'png', firstImageX, firstImageY +10, firstImageWidth, firstImageHeight - 30, undefined, 'FAST');
            }

// Handle image for second photo
var secondImageX = firstImageX + 100; // Adjust as needed for second image alignment
var secondImageY = firstImageY;

doc.text('Consumer Captured Photo', secondImageX+40, firstImageTextY, {
    align: 'center'
});

if ('<?php echo $dovs?->ConsumerCapturedPhoto; ?>' !== "") {
    doc.addImage(CapturedPhoto, 'png', secondImageX, secondImageY, firstImageWidth, firstImageHeight, undefined, 'FAST');
} else {
    doc.addImage(ConsumerIDPhotoAlt, 'png', secondImageX, secondImageY, firstImageWidth, firstImageHeight, undefined, 'FAST');
}

        //if (dovsStatus == '1')
        {
            // doc.addPage();
            doc.autoTable({
                //head: [['Facial Recognition Biometric: Validated at Department of Home Affairs', '', '']],
                head: [
                    [{
                        content: 'Facial Recognition Biometric: Validated at Department of Home Affairs'
                        , colSpan: 5
                        , styles: {
                            halign: 'left'
                            , fillColor: bgColour
                            , textColor: [255, 255, 255]
                        }
                    , }, ]
                , ]
                , body: [
                    ['Liveliness Detection:', `${LivenessDetectionResult}`, '']
                    , ['ID No. Status:', `${idnummatch}`, '']
                    , ['Deceased Status:', `${DeceasedStatus}`, '']
                    , ['Birth Date:', `${BirthDate}`, '']
                    , ['Gender:', `${Gender}`, '']
                    , ['Title:', `${Title}`, '']
                    , ['Marital Status:', `${MaritalStatus}`, '']
                    , ['Home Cellphone No:', `${CellularNo}`, '']
                    , ['Home Telephone No:', `${HomeTelephoneNo}`, '']
                    , ['Work Telephone No:', `${WorkTelephoneNo}`, '']
                    , ['Postal Address:', `${PostalAddress}`, '']
                    , ['Residential Address:', `${ResidentialAddress}`, '']

                ]
                , startY: doc.lastAutoTable.finalY + 150
                , styles: {
                    fontSize: 8
                    , font: 'Avenir'
                    , textColor: [0, 0, 0]
                }
                , columnStyles: {
                    0: {
                        cellWidth: 220
                        , fontStyle: 'bold'
                    }
                    , 1: {
                        cellWidth: 230
                    }
                    , 2: {
                        cellWidth: 80
                    }
                }
                , headStyles: {
                    fillColor: bgColour
                    , textColor: [255, 255, 255]
                }
            , });
        }

        //if (avsStatus == '1')
        {

// doc.addPage();
doc.autoTable({
    head: [
        ['Bank Account Verification (Realtime)', 'Result', 'Verified']
    ]
    , body: [
        ['AVS Status:', `${avs}`]
        , ['Branch Code:', `${Branch_code}`]
        , ['Account Holder:', `${Account_name}`]
        , ['Account Number:', `${Account_no}`]
        , ['Bank Name:', `${Bank_name}`]
        , ['Account Exists:', `${accopen}`]
        , ['Initials Match:', `${initials}`, `${initialsmatch}`]
        , ['Surname Match:', `${surname}`, `${surnamematch}`]
        , ['ID Number Match:', `${idnum}`, `${idnummatch}`]
        , ['Email Address Match:', `${Email}`, `${EMAILMATCHstatus}`]
        , ['Account Type Match:', `${accopen}`]
        , ['Account Dormant:', `${accdormant}`]
        , ['Account Open Three Months:', `${accthreemonths}`]
        , ['Account Accepts Debits:', `${accdebit}`]
        , ['Account Type Match:', `${acc}`]
    , ]
    , startY: doc.lastAutoTable.finalY + 7
    , styles: {
        fontSize: 8
        , font: 'Avenir'
        , textColor: [0, 0, 0]
    }
    , columnStyles: {
        0: {
            cellWidth: 220
            , fontStyle: 'bold'
        }
        , 1: {
            cellWidth: 230
        , },
        /* 2: {
            cellWidth: 110,
            fontStyle: 'bold'
        }, */
        2: {
            cellWidth: 80
        }
    },

    headStyles: {
        fillColor: bgColour
        , textColor: [255, 255, 255]
    }
, });
}






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

        doc.save(FirstName + ' ' + surname + ` - Self banking Report.pdf`);

    }

</script>



<script src="/assets/libs/jspdf/jspdf.min.js"></script>
<script src="/assets/libs/jspdf/jspdf.plugin.autotable.min.js"></script>


@endsection

