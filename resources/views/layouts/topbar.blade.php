<header id="page-topbar" style="background-color: rgb(255, 255, 255);">

    <style>
        button {
            background: none;
            color: inherit;
            border: none;
            padding: 0;
            font: inherit;
            cursor: pointer;
            outline: inherit;
        }

        textarea {
            border: none;
            overflow: auto;
            outline: none;

            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
        }
    </style>

    <div class="navbar-header">

        <div class="logo-lg">
            <img src="{{ URL::asset("assets\images\logo\computershare.png") }}" alt="" width="150" style="margin-left: 20%;">
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block">

                <a href="{{ url('/FAQ') }}">
                    <button type="button" class="btn btn-md font-size-6 header-item waves-effect">
                        <i class="bx dripicons-information" style="font-size: 16px;"></i>
                    </button>
                </a>

                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                    {{-- Check if it client --}}
                    <span class="badge bg-danger rounded-pill"><?php echo count($NotificationLink); ?></span>
                </button>

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">

                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0" key="t-notifications">Notifications: </h6>
                            </div>
                            {{-- <div class="col-auto">
                                <a href="#!" class="small" key="t-view-all">View All:</a>
                            </div> --}}
                        </div>
                    </div>

                    @csrf

                    {{-- Check if it client --}}
                    <div data-simplebar style="max-height: 230px;">
                        @foreach ($NotificationLink as $item)
                            <button id="{{ $item->EmailID }} " type="button" value="{{ $item->EmailMessage }}"
                                onClick="reply_click(this.value, this.id)" class="text-reset notification-item"
                                style="width: 100%" data-bs-toggle="modal" data-bs-target="#composemodal">
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title rounded-circle font-size-16"
                                            style="background-color: #93186c;">
                                            <i class="bx text-white bx-user"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1" style="padding-top: 8px;">
                                            {{ $item->Subject }}
                                        </h6>
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>

                </div>

            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/user.png"
                        alt="Image Not Found" style="width: 25px;height: 25px;">
                    {{-- <img class="rounded-circle header-profile-user"
                        src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/images/users/avatar-3.jpg') }}"
                        alt="Header Avatar"> --}}
                    <span style="color: black"
                        class="d-none d-xl-inline-block ms-1">{{ Session::get('UserFullName') }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    {{-- <a class="dropdown-item" href="{{ url('/admin-screening-first') }}"><i
                            class="bx bx-user font-size-16 align-middle me-1"></i> <span
                            key="t-profile">@lang('translation.Profile')</span>
                    </a> --}}

                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                            key="t-logout">@lang('translation.Logout')</span></a>
                    <form id="logout-form" action="{{ route('logout', ['customer' => $customer->RegistrationName]) }}"
                        method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>

</header>

<body>

    <!-- Modal -->

    <form class="form-horizontal" method="POST" action="{{ route('admin-dashboard-notification') }}">

        @csrf

        <input type="text" id="emailid" name="emailid" value="" style="display: none;">

        <div class="modal fade" id="composemodal" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="card-title mb-2 d-flex justify-content-left"
                            style="font-size: 18px;margin-bottom: 0px;margin-top: 8px;">
                            Message:
                        </h4>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2" style="margin-left: 10px;">

                            <div class="row">
                                <td class="font-size-14">
                                    <textarea height="25%" width="25%" id="displayresults" value=""></textarea>
                                </td>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"
                            style="background-color: #93186c; border-color: #93186c; color:white;">Mark As Read
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <!-- end modal -->

    <!--tinymce js-->
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

    <!-- email editor init -->
    <script src="{{ URL::asset('assets/js/pages/email-editor.init.js') }}"></script>

    <script type="text/javascript">
        function reply_click(clicked_value, clicked_id) {
            document.getElementById("displayresults").value = clicked_value
            var emailid = document.getElementById("emailid").value = clicked_id

            {{-- alert(emailid); --}}

            {{-- alert(clicked_id);
            alert(clicked_value); --}}
        }
    </script>

    {{-- <script type="text/javascript">
        function myFunc(variable){
            var s = document.getElementById(variable);
            s.value = "new value";
        }   
        myFunc("id1");
    </script>

    <script type="text/javascript">
        function reply_click(clicked_id){
            var s = document.getElementById(clicked_id);
            s.value = clicked_id;
        }   
        myFunc("displayresults");
    </script> --}}

</body>

<!--  Change-Password example -->
<div class="modal fade change-password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="change-password">
                    @csrf
                    {{-- <input type="hidden" value="{{ Auth::user()->id }}" id="data_id"> --}}
                    <div class="mb-3">
                        <label for="current_password">Current Password</label>
                        <input id="current-password" type="password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            name="current_password" autocomplete="current_password"
                            placeholder="Enter Current Password" value="{{ old('current_password') }}">
                        <div class="text-danger" id="current_passwordError" data-ajax-feedback="current_password">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="newpassword">New Password</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            autocomplete="new_password" placeholder="Enter New Password">
                        <div class="text-danger" id="passwordError" data-ajax-feedback="password"></div>
                    </div>

                    <div class="mb-3">
                        <label for="userpassword">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" autocomplete="new_password"
                            placeholder="Enter New Confirm password">
                        <div class="text-danger" id="password_confirmError" data-ajax-feedback="password-confirm">
                        </div>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light UpdatePassword"
                            data-id="{{ '1' }}" type="submit">Update Password</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
