@extends('layouts.master-inbox')

{{-- @section('title')
@lang('translation.Form_Wizard')
@endsection --}}


@section('css')
    <style>
        table {
            overflow-y: scroll;
            height: 250px;
            width: 500px;
            display: block;
        }

        .heading-fica-id {
            height: 10%;
            background-image: linear-gradient(#93186c, #93186c);
        }
    </style>
@endsection


@section('content')

    <div class="main-content" style="margin-left: 0px;">

        <div class="page-content" style="padding-right: 0px;padding-left: 0px;padding-bottom: 0px;padding-top: 0px;">

            <div class="row d-flex justify-content-center">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <a class="nav-link mb-2 active" id="v-pills-home-tab" data-bs-toggle="pill"
                                            href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                                            aria-selected="true">Email</a>
                                        <a class="nav-link mb-2" id="v-pills-profile-tab" data-bs-toggle="pill"
                                            href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                            aria-selected="false">Actions</a>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
    
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                            aria-labelledby="v-pills-home-tab">
    
                                            <!-- Left sidebar -->
    
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="mb-2" style="margin-left: 14px;">
    
                                                        <button type="button" class="btn btn-block waves-effect waves-light"
                                                            style="background-color: #93186c; border-color: #93186c; color:white;"
                                                            data-bs-toggle="modal" data-bs-target="#composemessage">
                                                            Compose
                                                        </button>
    
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3">
    
                                                    <ol class="breadcrumb">
                                                        <li class="breadcrumb-item"><a type="button"
                                                                onclick="window.history.back()">Client Information</a></li>
                                                        <li class="breadcrumb-item text-decoration-underline"
                                                            style="font-weight: 500"><a href="javascript: void(0);">Actions</a>
                                                        </li>
                                                    </ol>
    
                                                </div>
                                            </div>
    
                                            <div class="mail-list mt-4" id="mailsentselect" style="display: none;">
    
                                                <a href="javascript: void(0);" id="showinbox">
                                                    <i class="mdi mdi-email-outline me-2 text-size-16"></i> Inbox <span
                                                        class="ms-1 float-end"></span></a>
    
                                                <a href="javascript: void(0);" style="color: #006faf;">
                                                    <i class="mdi mdi-email-check-outline me-2 text-size-16"></i>Sent
                                                    Mail</a>
    
                                            </div>
    
                                            <!-- End Left sidebar -->
    
                                            <!-- Right Sidebar 2 -->
    
                                            <div class="table-responsive" style="margin-left: 14px;">
                                                <table class="table table-sm mb-0 w-auto h-auto" style="height: 480px;">
    
                                                    <thead style="background-color: #93186c;border-bottom-color: #93186c">
                                                        <tr hei>
                                                            <th class="col-md-3 font-size-12" style="color:#ffffff;">From Email</th>
                                                            <th class="col-md-3 font-size-12" style="color:#ffffff;">To Email</th>
                                                            <th class="col-md-4 font-size-12" style="color:#ffffff;">Message</th>
                                                            <th class="col-md-1 font-size-12" style="color:#ffffff;">Sent At</th>
                                                        </tr>
                                                    </thead>
    
                                                    <tbody style="border: 0.3rem; border-block-color: #d3d3d3">
                                                        @foreach ($sentemails as $item)
                                                            <tr>
                                                                <td class="font-size-12">
                                                                    {{ $item->Send }}</td>
                                                                <td class="font-size-12">
                                                                    {{ $item->Receive }}</td>
                                                                <td class="font-size-12">
                                                                    {{ $item->EmailMessage }}</td>
                                                                <td class="font-size-12">
                                                                    {{ substr($item->EmailDate, 0, 10) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
    
                                                </table>
                                            </div>
    
                                            <!-- end Col-9 -->
    
                                            <!-- Modal -->
    
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('admin-inbox-message') }}">
    
                                                @csrf
    
                                                <div class="modal fade" id="composemessage" tabindex="-1" role="dialog"
                                                    aria-labelledby="composemessageTitle" aria-hidden="true">
    
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
    
                                                                <h4 class="card-title mb-2 d-flex justify-content-left"
                                                                    style="font-size: 18px;margin-bottom: 0px;margin-top: 8px;">
                                                                    Send a Message
                                                                </h4>
    
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
    
                                                                <div class="mb-3">
                                                                    <input type="email" id="Email" name="Email"
                                                                        required class="form-control"
                                                                        value="{{ $Email }}" readonly>
                                                                </div>
    
                                                                <div class="mb-3">
                                                                    <input type="text" id="Subject" name="Subject"
                                                                        class="form-control" placeholder="Subject">
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
                                                                <button type="submit" class="btn btn-primary"
                                                                    style="background-color: #93186c; border-color: #93186c; color:white;">Send
                                                                    <i class="fab fa-telegram-plane ms-1"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    
                                            </form>
                                            <!-- end modal -->
    
                                        </div>
    
                                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                            aria-labelledby="v-pills-profile-tab">
    
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-body"
                                                            style="padding-top: 0px;padding-left: 0px;padding-right: 0px;">
                                                            <div class="heading-fica-id mb-3">
                                                                <div class="text-center">
                                                                    <h4 style="color: #fff; padding-top:8px;padding-bottom: 8px;">
                                                                        Admin Actions
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                            <form action="{{ route('admin-actions') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="col-lg-12 mt-2">
                                                                    <div class="row">
    
                                                                        <div class="col-md-2" style="margin-left: 50px;">
                                                                            <div class="mb-3">
                                                                                <label for="basicpill-vatno-input"
                                                                                    class="font-weight-bold"
                                                                                    style="font-size: 12px; color: rgb(0, 0, 0)">Risk
                                                                                    Rating:</label>
                                                                            </div>
                                                                        </div>
    
                                                                        <div class="col-md-4">
                                                                            <div class="mb-3">
                                                                                <div class="input-group"
                                                                                    style="height: 27px; width: 225px;">
    
                                                                                    <select class="form-select"
                                                                                        autocomplete="off"
                                                                                        style="height: 27px; padding-left: 21px;padding-top: 2px;padding-bottom: 2px;
                                                                                    text-transform: uppercase; font-size: 12px;"
                                                                                        id="RiskStatus" name="RiskStatus"
                                                                                        aria-placeholder="Select">
                                                                                        <option selected disabled>Select
                                                                                        </option>
                                                                                        <option value="HIGH"
                                                                                            {{-- {{ isset($Gender) && $Gender == 'HIGH' ? 'selected' : '' }} --}}>
                                                                                            HIGH
                                                                                        </option>
    
                                                                                        <option value="MEDIUM"
                                                                                            {{-- {{ isset($Gender) && $Gender == 'MEDIUM' ? 'selected' : '' }} --}}>
                                                                                            MEDIUM
                                                                                        </option>
    
                                                                                        <option value="LOW"
                                                                                            {{-- {{ isset($Gender) && $Gender == 'LOW' ? 'selected' : '' }} --}}>
                                                                                            LOW
                                                                                        </option>
    
                                                                                    </select>
    
                                                                                </div>
                                                                            </div>
                                                                        </div>
    
                                                                        <div class="col-md-2">
                                                                            <div class="mb-3">
                                                                                <label for="basicpill-vatno-input"
                                                                                    class="font-weight-bold"
                                                                                    style="font-size: 12px; color: rgb(0, 0, 0)">FICA
                                                                                    Status:</label>
                                                                            </div>
                                                                        </div>
    
                                                                        <div class="col-md-2">
                                                                            <div class="mb-3">
                                                                                <div class="input-group"
                                                                                    style="height: 27px; width: 225px;">
    
                                                                                    <select class="form-select"
                                                                                        autocomplete="off"
                                                                                        style="height: 27px; padding-left: 21px;padding-top: 2px;padding-bottom: 2px;
                                                                                    text-transform: uppercase; font-size: 12px;"
                                                                                        id="FICAStatus" name="FICAStatus"
                                                                                        aria-placeholder="Select">
                                                                                        <option selected disabled>Select
                                                                                        </option>
                                                                                        <option value="Completed">
                                                                                            Completed
                                                                                        </option>
                                                                                        <option value="Rejected">
                                                                                            Rejected
                                                                                        </option>
    
                                                                                        <option value="Correction">
                                                                                            Correction
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
    
                                                                        <div class="col-lg-12 mt-2">
                                                                            <div class="row">
                                                                                <div class="col-md-2"
                                                                                    style="margin-left: 50px;">
                                                                                    <div class="mb-3">
                                                                                        <div class="form-check">
                                                                                            <label class="form-check-label"
                                                                                                for="salary-checkbox"
                                                                                                style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0);">
                                                                                                ID Status
                                                                                            </label>
                                                                                            <input
                                                                                                class="form-check-input big-checkbox"
                                                                                                type="checkbox" value=2
                                                                                                disabled id="idas-api-status"
                                                                                                name="idas-api-status"
                                                                                                style="width: 20px; height:20px;">
                                                                                        </div>
    
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <div class="mb-3">
                                                                                        <div class="form-check">
                                                                                            <label class="form-check-label"
                                                                                                for="salary-checkbox"
                                                                                                style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0);">
                                                                                                KYC Status
                                                                                            </label>
                                                                                            <input
                                                                                                class="form-check-input big-checkbox"
                                                                                                type="checkbox" value=2
                                                                                                disabled id="kyc-api-status"
                                                                                                name="kyc-api-status"
                                                                                                style="width: 20px; height:20px;">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <div class="mb-3">
    
                                                                                        <div class="form-check">
                                                                                            <label class="form-check-label"
                                                                                                for="salary-checkbox"
                                                                                                style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0);">
                                                                                                AVS Status
                                                                                            </label>
                                                                                            <input
                                                                                                class="form-check-input big-checkbox"
                                                                                                type="checkbox" value=2
                                                                                                disabled id="avs-api-status"
                                                                                                name="avs-api-status"
                                                                                                style="width: 20px; height:20px;">
                                                                                        </div>
    
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <div class="mb-3">
    
                                                                                        <div class="form-check">
                                                                                            <label class="form-check-label"
                                                                                                for="salary-checkbox"
                                                                                                style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0);">
                                                                                                DOVS Status
                                                                                            </label>
                                                                                            <input
                                                                                                class="form-check-input big-checkbox"
                                                                                                type="checkbox" value=2
                                                                                                disabled id="dovs-api-status"
                                                                                                name="dovs-api-status"
                                                                                                style="width: 20px; height:20px;">
                                                                                        </div>
    
                                                                                    </div>
                                                                                </div>
    
                                                                                <div class="col-md-3">
                                                                                    <div class="mb-3">
    
                                                                                        <div class="form-check">
                                                                                            <label class="form-check-label"
                                                                                                for="salary-checkbox"
                                                                                                style="padding-left:15px;padding-right:15px;padding-top:5px;font-size: 12px; color: rgb(0, 0, 0);">
                                                                                                Compliance Status
                                                                                            </label>
                                                                                            <input
                                                                                                class="form-check-input big-checkbox"
                                                                                                type="checkbox" value=2
                                                                                                disabled
                                                                                                id="compliance-api-status"
                                                                                                name="compliance-api-status"
                                                                                                style="width: 20px; height:20px;">
                                                                                        </div>
    
                                                                                    </div>
                                                                                </div>
    
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 mt-5">
                                                                            <div class="row d-flex justify-content-center">
                                                                                <div class="col-lg-1">
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary w-md"
                                                                                        style="background-color: #93186c; border-color: #93186c">Save</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
    
                                                        </div>
                                                    </div>
    
                                                    <div class="table-responsive">
                                                        <table class="table table-sm mb-0 w-auto h-auto" style="height: 480px;">
    
                                                            <thead style="background-color: #93186c;border-bottom-color: #93186c">
                                                                <tr>
                                                                    <th class="col-md-2 font-size-13" style="color:#ffffff;">Admin</th>
                                                                    <th class="col-md-2 font-size-13" style="color:#ffffff;">Consumer
                                                                    </th>
                                                                    <th class="col-md-2 font-size-13" style="color:#ffffff;">Action
                                                                        Date</th>
                                                                    <th class="col-md-2 font-size-13" style="color:#ffffff;">Action
                                                                        Type</th>
                                                                    <th class="col-md-2 font-size-13" style="color:#ffffff;">Action
                                                                    </th>
                                                                    <th class="col-md-2 font-size-13" style="color:#ffffff;">Is Admin
                                                                    </th>
                                                                </tr>
                                                            </thead>
    
                                                            <tbody style="border: 0.3rem; border-block-color: #d3d3d3">
                                                                @foreach ($SetActions as $item)
                                                                    <tr>
                                                                        <td class="font-size-12">
                                                                            {{ $LogUserName }} {{ $LogUserSurname }}
                                                                        </td>
                                                                        <td class="font-size-12">
                                                                            {{ $FirstName }} {{ $SURNAME }}
                                                                        </td>
                                                                        <td class="font-size-12">
                                                                            {{ substr($item->ActionDate, 0, 10) }}</td>
                                                                        <td class="font-size-12">
                                                                            {{ $item->ActionType }}</td>
                                                                        <td class="font-size-12">
                                                                            {{ $item->Action_Comment }}</td>
                                                                        <td class="font-size-12">
                                                                            {{ $item->Admin_User }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
    
                                                        </table>
                                                    </div>
    
                                                </div>
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
    
                            </div>

                            @extends('layouts.footer')

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#FICAStatus").change(function() {
                var value = this.value;
                if (value == 'Completed' || value == 'Rejected' || value == 'Correction') {
                    $('#idas-api-status').prop('disabled', false);
                    $('#kyc-api-status').prop('disabled', false);
                    $('#avs-api-status').prop('disabled', false);
                    $('#dovs-api-status').prop('disabled', false);
                    $('#compliance-api-status').prop('disabled', false);
                }

            });

        });
    </script>
@endsection
