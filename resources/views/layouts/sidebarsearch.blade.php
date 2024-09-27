<head>
    <style>
        .card:hover {
            border-top-color: #5F0A87;
            border-bottom-color: #5F0A87;
            border-left-color: #5F0A87;
            border-right-color: #5F0A87;
        }

        h5 {
            font-style: normal;
        }
    </style>
</head>

<div class="vertical-menu" style="background-color: white;">

    <div class="h-100">

        <!--- Sidemenu -->

        <div class="col-sm-12">
            <div class="card-body"
                style="background-color: white; padding-top: 5px;padding-right: 5px;padding-bottom: 5px;padding-left: 5px;">

                {{-- <div class="card" style="width: 218px; background-color: rgb(235, 235, 235);margin-left: 10px;"> --}}

                <div class="mb-3" style="margin-left: 30%;">

                    <img class="rounded me-2" alt="Image Unavailable"
                        src="data:image/png;base64,{{ $ConsumerCapturedPhoto }}" data-holder-rendered="true"
                        width="55%">

                    {{-- <img src="data:image/png;base64,{{ $ConsumerCapturedPhoto }}" class="avatar-sm rounded-circle img-thumbnail"
                                style="padding-left: 0px; height: 130px; width: 100px;padding-top: 0px;margin-right: 0px;margin-left: 58px;margin-top: 20px;border: 0.5rem"> --}}
                </div>
                {{-- </div> --}}

                <div class="d-flex">
                    <div class="flex-grow-1">

                        <h5 style="padding-left: 13px;" class="mb-2 text-left text-black">{{ $FirstName }} {{ $SURNAME }}</h5>

                        <hr style="margin-bottom: 8px;margin-top: 8px;">

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">

                            <div class="row d-flex justify-content-evenly">

                                <div class="col-sm-6" style="padding-left: 9%;">
                                    <h5 class="font-size-14 text-left">Identity :</h5>
                                </div>

                                <div class="col-sm-6" style="padding-right: 10%;">
                                    <span class="float-end text-black">{{ $IDNUMBER }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="row d-flex justify-content-evenly">

                        <div class="col-sm-6" style="padding-left: 10%;">
                            <h5 class="font-size-14">Risk Rating:</h5>
                        </div>

                        <div class="col-sm-6">
                            @if ($RiskStatusbyFICA == 'HIGH')
                            <span class="justify-content-md-center"
                                style="color: rgb(240, 50, 40 );">HIGH</span>
                            @elseif ($RiskStatusbyFICA == 'MEDIUM')
                                <span class="justify-content-md-center"
                                    style="color: #f0c200;">MEDIUM</span>
                            @elseif($RiskStatusbyFICA == 'LOW')
                                <span class="justify-content-md-center" style="color: #74ac04;">LOW</span>
                                @elseif($RiskStatusbyFICA == null)
                                    <span class="justify-content-md-center" style="color: #000000;">N/A</span>
                            @endif
                        </div>

                    </div>

                    <div class="row d-flex justify-content-evenly">

                        <div class="col-sm-6" style="padding-left: 10%;">
                            <h5 class="font-size-14">Completion :</h5>
                        </div>

                        <div class="col-sm-6">
                            <span class="justify-content-md-center"style="color: rgb(10 , 40, 60);">{{ $ProgressbyFICA }}%</span>
                        </div>

                    </div>

                    <div class="row d-flex justify-content-evenly">

                        <div class="col-sm-6" style="padding-left: 10%;">
                            <h5 class="font-size-14">FICA Status :</h5>
                        </div>

                        <div class="col-sm-6">

                            @if ($FICAStatusbyFICA == 'Completed')
                            <span class="justify-content-md-center" style="color: #93186c;">{{ $FICAStatusbyFICA }}</span>
                            @elseif ($FICAStatusbyFICA == 'In progress')
                                <span class="justify-content-md-center" style="color: #a98600">In Progress</span>
                            @elseif($FICAStatusbyFICA == 'Correction')
                                <span class="justify-content-md-center" style="color: #f8631d">{{ $FICAStatusbyFICA }}</span>
                            @elseif($FICAStatusbyFICA == 'Failed')
                                <span class="justify-content-md-center" style="color: #f53a59">{{ $FICAStatusbyFICA }}</span>
                            @endif


                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="margin-left: 15px;">

                    <a href="{{ url('/admin-dashboard') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3"
                            style="background-color: #93186c; border-color: #93186c; width: 90%">
                            <i class="bx text-white bx-task label-icon"></i>
                            Dashboard
                        </button>
                    </a>

                    <a href="{{ url('/admin-findusers') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3"
                            style="background-color: #93186c; border-color: #93186c; width: 90%">
                            <i class="bx text-white bx-desktop label-icon"></i>
                            Customer Onboarding
                        </button>
                    </a>

                    <a href="{{ url('/admin-inbox') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3"
                            style="background-color: #93186c; border-color: #93186c; width: 90%">
                            <i class="bx text-white bx-notepad label-icon"></i>
                            Actions
                        </button>
                    </a>

                    {{-- <div class="card rounded-pill text-black-25 center-block mb-2 mt-2"
                            style="width: 200px; height: 35px; background-color: #93186c;margin-left: 16px;">
                            <a href="{{ url('/admin-dashboard') }}">
                                <div class="card-body"
                                    style="padding-bottom: 5px;padding-right: 0px;padding-left: 16px;padding-top: 7px;">
                                    <h5 class="mb-4 text-white"
                                        style="font-size: 14px;margin-bottom: 0px;margin-top: 0px; font-style: normal;">
                                        <i class="bx bx-task" style="margin-right: 12px; font-size: 16px;"></i>
                                        Dashboard
                                    </h5>
                                </div>
                            </a>
                        </div>

                        <div class="card rounded-pill text-black-25 center-block mb-2 mt-2"
                            style="width: 200px; height: 35px; background-color: #93186c;margin-left: 16px;">
                            <a href="{{ url('/admin-findusers') }}">
                                <div class="card-body"
                                    style="padding-bottom: 5px;padding-right: 0px;padding-left: 16px;padding-top: 7px;">
                                    <h5 class="mb-4 text-white"
                                        style="font-size: 14px;margin-bottom: 0px;margin-top: 3px;">
                                        <i class="fas fa-desktop" style="margin-right: 12px;"></i>
                                        Search Clients
                                    </h5>
                                </div>
                            </a>
                        </div>

                        <div class="card rounded-pill text-black-25 center-block mb-2 mt-2"
                            style="width: 200px; height: 35px; background-color: #93186c;margin-left: 16px;">
                            <a href="{{ url('/admin-inbox') }}">
                                <div class="card-body" style="padding-bottom: 5px;padding-right: 0px;padding-left: 16px;padding-top: 7px;">
                                    <h5 class="mb-4 text-white"
                                        style="font-size: 14px;">
                                        <i class="bx bx-notepad font-size-16" style="margin-right: 12px;"></i>
                                        Actions
                                    </h5>
                                </div>
                            </a>
                        </div> --}}

                    {{-- <div class="card rounded-pill text-black-25 center-block mb-2 mt-2"
                            style="width: 200px; height: 35px; background-color: #93186c;margin-left: 16px;">
                            <a href="{{ url('/admin-comments') }}">
                                <div class="card-body"
                                    style="padding-bottom: 5px;padding-right: 0px;padding-left: 16px;padding-top: 7px;">
                                    <h5 class="mb-4 text-white"
                                        style="font-size: 14px;margin-bottom: 0px;margin-top: 3px;">
                                        <i class="bx bx-chat font-size-16" style="margin-right: 12px;"></i>
                                        Client Query
                                    </h5>
                                </div>
                            </a>
                        </div> --}}

                </div>
            </div>
        </div>

    </div>

    {{-- @endsection('admin-nav') --}}

</div>

<!-- Sidebar -->
</div>
