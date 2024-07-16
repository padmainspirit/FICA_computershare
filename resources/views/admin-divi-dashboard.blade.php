@extends('layouts.master-dashboard')

@section('title')
{{-- @lang('translation.User_List') --}}
@endsection

@section('css')

@endsection

@section('content')
<div class="account-pages my-2 pt-sm-2">
    <div class="container">
        <div class="row justify-content-center">

            <div class="row d-flex justify-content-center">

                <div class="col-sm-6">
                    <div class="card" id="card"
                        style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px; border-color: #93186c">
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
                                PLACEHOLDER FOR DATA FROM CONTROLLER
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card" id="card"
                    style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px; border-color: #93186c">
                    <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18"
                                    style="background-color: #c56ce0; background-image: linear-gradient(315deg, #c56ce0 0%, #c56ce0 74%);">
                                        <i class="bx bxs-user-check me-3 font-size-24"
                                            style="margin-left: 16px; color: rgb(0, 0, 0);"></i>
                                    </span>
                                </div>
                                <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Clients not actioned</h3>
                            </div>
                            <div class="text-muted mt-4">
                                PLACEHOLDER FOR DATA FROM CONTROLLER
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row d-flex justify-content-center">

                <div class="col-sm-6">
                    <div class="card" id="card"
                    style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px; border-color: #93186c">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18"
                                    style="background-color: #c56ce0; background-image: linear-gradient(315deg, #c56ce0 0%, #c56ce0 74%);">
                                        <i class="bx bxs-user-check me-3 font-size-24"
                                            style="margin-left: 16px; color: rgb(0, 0, 0);"></i>
                                    </span>
                                </div>
                                <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Clients actioned</h3>
                            </div>
                            <div class="text-muted mt-4">
                                PLACEHOLDER FOR DATA FROM CONTROLLER
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card" id="card"
                    style="border-top-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-right-width: 1px; border-color: #93186c">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18"
                                    style="background-color: #c56ce0; background-image: linear-gradient(315deg, #c56ce0 0%, #c56ce0 74%);">
                                        <i class="bx bxs-user-check me-3 font-size-24"
                                            style="margin-left: 16px; color: rgb(0, 0, 0);"></i>
                                    </span>
                                </div>
                                <h3 class="font-size-16 mb-0" style="font-size: 18px; color: black">Clients rescheduled</h3>
                            </div>
                            <div class="text-muted mt-4">
                                PLACEHOLDER FOR DATA FROM CONTROLLER
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-xl-12">

                    <h3 class="card-title mb-3 mt-3" style="text-align: center; color: rgb(0, 0, 0); font-size: 18px;">
                        Outstanding Company Actions
                    </h3>

                    <div class="card" id="card" style="border: 1px solid;border-block-radius: 6px; overflow-y: scroll; max-height: 80vh;border-color: #93186c;">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="py-2">
                                        <h5 class="font-size-14">COMPANY:<span class="float-end">PERCENTAGE%</span></h5>
                                        <h5 class="font-size-14">DATAFROMTABLE</h5>
                                        <div class="progress animated-progess progress-sm">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70"></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="py-2">
                                        <h5 class="font-size-14">COMPANY:<span class="float-end">PERCENTAGE%</span></h5>
                                        <h5 class="font-size-14">DATAFROMTABLE</h5>
                                        <div class="progress animated-progess progress-sm">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70"></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="py-2">
                                        <h5 class="font-size-14">COMPANY:<span class="float-end">PERCENTAGE%</span></h5>
                                        <h5 class="font-size-14">DATAFROMTABLE</h5>
                                        <div class="progress animated-progess progress-sm">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70"></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="py-2">
                                        <h5 class="font-size-14">COMPANY:<span class="float-end">PERCENTAGE%</span></h5>
                                        <h5 class="font-size-14">DATAFROMTABLE</h5>
                                        <div class="progress animated-progess progress-sm">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70"></div>
                                        </div>
                                    </div>
                                </li>
                                
                            </ul>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@section('script')



@endsection
