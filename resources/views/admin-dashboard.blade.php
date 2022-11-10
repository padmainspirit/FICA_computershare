@extends('layouts.master-dashboard')

{{-- @section('title')
@lang('translation.Form_Wizard')
@endsection --}}


@section('css')
    <style>
        .card:hover {
            border-top-color: #5F0A87;
            border-bottom-color: #5F0A87;
            border-left-color: #5F0A87;
            border-right-color: #5F0A87;
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

        <div class="page-content" style="padding-right: 0px;padding-left: 0px;padding-bottom: 0px;padding-top: 0px;">

            <h3 class="card-title mb-3 mt-3" style="text-align: center; color: rgb(0, 0, 0); font-size: 18px;">Application Status</h3>

            <div class="row d-flex justify-content-center">

                <div class="col-sm-3">
                    <div class="card" id="card"
                        style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18"
                                    style="background-color: #c56ce0; background-image: linear-gradient(315deg, #c56ce0 0%, #c56ce0 74%);">
                                        <i class="bx bxs-user-check me-3 font-size-24"
                                            style="margin-left: 16px; color: rgb(0, 0, 0);"></i>
                                    </span>
                                </div>
                                <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Total Number of Clients</h3>
                            </div>
                            <div class="text-muted mt-4">
                                <h5 style="text-align:right;">{{ $NumClients }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card" id="card"
                        style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18"
                                    style="background-color: #52bdee; background-image: linear-gradient(315deg, #52bdee 0%, #52bdee 74%);">
                                        <i class="mdi mdi-bullseye-arrow me-3 font-size-24"
                                            style="margin-left: 16px; color: rgb(0, 0, 0);"></i>
                                    </span>
                                </div>
                                <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Applications in
                                    Progress</h3>
                            </div>
                            <div class="text-muted mt-4">
                                <h5 style="text-align:right;">{{ $InProgress }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-3">
                    <div class="card" id="card"
                        style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18"
                                        style="background-image: linear-gradient(315deg, #a7ef29 0%, #a7ef29 74%);">
                                        <i class="mdi mdi-check-all me-3 font-size-24"
                                            style="margin-left: 16px; color: rgb(0, 0, 0);"></i>
                                    </span>
                                </div>
                                <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Applications
                                    Completed</h3>
                            </div>
                            <div class="text-muted mt-4">
                                <h5 style="text-align:right;">{{ $Completed }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row d-flex justify-content-center">

                <div class="col-sm-3">
                    <div class="card" id="card"
                        style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18"
                                    style="background-color: #f53a59; background-image: linear-gradient(147deg, #f53a59 0%, #f53a59 74%);">
                                        <i class="far fa-times-circle me-3 font-size-24"
                                            style="margin-left: 16px; color: rgb(0, 0, 0);"></i>
                                    </span>
                                </div>
                                <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Applications
                                    Failed</h3>
                            </div>
                            <div class="text-muted mt-4">
                                <h5 style="text-align:right;">{{ $Failed }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card" id="card"
                        style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18"
                                    style="background-image: linear-gradient( 109.6deg, #f28500 , #f28500 );">
                                        <i class="bx bx-calendar-x me-3 font-size-24"
                                            style="margin-left: 16px; color: rgb(0, 0, 0);"></i>
                                    </span>
                                </div>
                                <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Applications
                                    Rejected</h3>
                            </div>
                            <div class="text-muted mt-4">
                                <h5 style="text-align:right;">{{ $Rejected }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="card" id="card"
                        style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18"
                                    style="background-color: #f9fc50; background-image: linear-gradient(315deg, #f9fc50 0%, #f9fc50 74%);">
                                        <i class="bx bxs-pencil me-3 font-size-24"
                                            style="margin-left: 16px; color: rgb(0, 0, 0);"></i>
                                    </span>
                                </div>
                                <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Applications in Correction</h3>
                            </div>
                            <div class="text-muted mt-4">
                                <h5 style="text-align:right;">{{ $Correction }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-xl-6">

                    <h3 class="card-title mb-3 mt-3" style="text-align: center; color: rgb(0, 0, 0); font-size: 18px;">Risk
                        Status
                    </h3>

                    <div class="card" id="card"
                        style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                        <div class="card-body">

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="py-2">
                                        <h5 class="font-size-14">High Risk:<span class="float-end">{{ substr($HighPerc, 0, 5) }}%</span></h5>
                                        <h5 class="font-size-14">{{ $HighRisk }}</h5>
                                        <div class="progress animated-progess progress-sm">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $HighPerc }}%" aria-valuenow="{{ $HighRisk }}" aria-valuemin="0" aria-valuemax="{{ $NumClients }}"></div>
                                        </div>
                                    </div>
                                </li>    
                                <li class="list-group-item">
                                    <div class="py-2">
                                        <h5 class="font-size-14">Medium Risk:<span class="float-end">{{ substr($MediumPerc, 0, 5) }}%</span></h5>
                                        <h5 class="font-size-14">{{ $MediumRisk }}</h5>
                                        <div class="progress animated-progess progress-sm">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $MediumPerc }}%" aria-valuenow="{{ $MediumRisk }}" aria-valuemin="0" aria-valuemax="{{ $NumClients }}"></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="py-2">
                                        <h5 class="font-size-14">Low Risk:<span class="float-end">{{ substr($LowPerc, 0, 5)}}%</span></h5>
                                        <h5 class="font-size-14">{{ $LowRisk }}</h5>
                                        <div class="progress animated-progess progress-sm">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $LowPerc }}%" aria-valuenow="{{ $LowRisk }}" aria-valuemin="0" aria-valuemax="{{ $NumClients }}"></div>
                                        </div>
                                    </div>
                                </li>   
                                
                            </ul>

                        </div>
                    </div>

                </div>

                {{--  <div class="col-xl-4">

                    <h3 class="card-title mb-3 mt-3" style="text-align: center; color: rgb(0, 0, 0); font-size: 18px;">FICA
                        Status
                    </h3>

                    <div class="card" id="card"
                        style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                        <div class="card-body" style="padding-bottom: 0px;">

                            <div class="text-center">
                                <div class="mb-1">
                                    <i class="bx bx-user-check display-4" style="color: #09203F;"></i>
                                </div>
                            </div>

                            <div class="table-responsive mt-4">
                                <table class="table align-middle table-nowrap">
                                    <tbody>

                                        <tr>
                                            <td style="width: 50%">
                                                <p class="font-size-14 mb-0">Total Number of Clients:</p>
                                            </td>
                                            <td style="width: 50%">
                                                <h5 class="mb-0">{{ $NumClients }}</h5>
                                            </td>
                                            <td>
                                                <div class="progress bg-transparent progress-sm">
                                                    <div class="progress-bar bg-primary rounded" role="progressbar"
                                                        style="width: 50%; background-image: linear-gradient(315deg, #7f53ac 0%, #647dee 74%);"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  --}}

                <div class="col-xl-6">

                    <h3 class="card-title mb-3 mt-3" style="text-align: center; color: rgb(0, 0, 0); font-size: 18px;">
                        Application Progress Timeline
                    </h3>

                    <div class="card" id="card"
                        style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px">
                        <div class="card-body">

                            <ul class="verti-timeline list-unstyled text-center">

                                <li class="event-list" style="padding-bottom: 10px;">
                                    <div class="event-timeline-dot" style="margin-top: 2px;">
                                        <img src="/images/clock2.png" class="font-size-24"
                                            style="color: rgb(0, 0, 0);width: 24px; height: 24px;">
                                    </div>

                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3" style="margin-left: 16px;margin-top: 4px;">
                                            <h5 class="font-size-15">1-5 Days:<i style="padding-left: 105px;"
                                                    class="bx bx-right-arrow-alt font-size-24 text-primary align-middle ms-2"></i>
                                            </h5>
                                        </div>
                                        <div style="margin-top: 5px;" class="flex-grow-1 font-size-16">
                                            <div>
                                                {{ $Oneto5Count }}
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <hr>

                                <li class="event-list" style="padding-bottom: 10px;">
                                    <div class="event-timeline-dot" style="margin-top: 2px;">
                                        <img src="/images/clock4.png" class="font-size-24"
                                            style="color: rgb(0, 0, 0);width: 24px; height: 24px;">
                                    </div>

                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3" style="margin-left: 16px;margin-top: 4px;">
                                            <h5 class="font-size-15">5-10 Days:<i style="padding-left: 95px;"
                                                    class="bx bx-right-arrow-alt font-size-24 text-primary align-middle ms-2"></i>
                                            </h5>
                                        </div>
                                        <div style="margin-top: 5px;" class="flex-grow-1 font-size-16">
                                            <div>
                                                {{ $Fiveto10Count }}
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <hr>

                                <li class="event-list" style="padding-bottom: 10px;">
                                    <div class="event-timeline-dot" style="margin-top: 2px;">
                                        <img src="/images/clock6.png" class="font-size-24"
                                            style="color: rgb(0, 0, 0);width: 24px; height: 24px;">
                                    </div>

                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3" style="margin-left: 16px;margin-top: 4px;">
                                            <h5 class="font-size-15">10-15 Days:<i style="padding-left: 90px;"
                                                    class="bx bx-right-arrow-alt font-size-24 text-primary align-middle ms-2"></i>
                                            </h5>
                                        </div>
                                        <div style="margin-top: 5px;" class="flex-grow-1 font-size-16">
                                            <div>
                                                {{ $Tento15count }}
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <hr>

                                <li class="event-list" style="padding-bottom: 6px;">
                                    <div class="event-timeline-dot" style="margin-top: 2px;">
                                        <img src="/images/clock9.png" class="font-size-24"
                                            style="color: rgb(0, 0, 0);width: 24px; height: 24px;">
                                    </div>

                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3" style="margin-left: 16px;margin-top: 4px;">
                                            <h5 class="font-size-15">15-30 Days:<i style="padding-left: 88px;"
                                                    class="bx bx-right-arrow-alt font-size-24 text-primary align-middle ms-2"></i>
                                            </h5>
                                        </div>
                                        <div style="margin-top: 5px;" class="flex-grow-1 font-size-16">
                                            <div>
                                                {{ $Fifteenpluscount }}
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div><!-- end row -->
    </div>
    <!-- end main content-->
@endsection

@section('script')
@endsection
