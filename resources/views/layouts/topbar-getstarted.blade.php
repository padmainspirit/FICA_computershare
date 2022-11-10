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
            <img src="{{ URL::asset($Logo) }}" alt="" width="150" style="margin-left: 20%;">
        </div>

        <div class="d-flex flex-wrap">

            <a href="{{ url('/FAQ') }}">
                <button type="button" class="btn btn-md px-7 font-size-6 header-item waves-effect">
                    <i class="bx bx-info-circle" style="font-size: 22px;"></i>
                </button>
            </a>

            <button type="button" class="btn header-item noti-icon waves-effect"
                id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-bell bx-tada"></i>
                {{-- <span class="badge bg-danger rounded-pill">3</span> --}}
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
                {{-- <div data-simplebar style="max-height: 230px;">
                    @foreach ($NotificationLink as $item)
                        <button id="{{ $item->EmailID }} " type="button" value="{{ $item->EmailMessage }}"
                            onClick="reply_click(this.value, this.id)" class="text-reset notification-item"
                            style="width: 100%" data-bs-toggle="modal" data-bs-target="#composemodal">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle font-size-16"
                                        style="background-color: #1a4f6e;">
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
                </div> --}}

            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/user.png" alt="Image Not Found" style="width: 25px;height: 25px;">
                    <span style="color: black" class="d-none d-xl-inline-block ms-1"
                        key="t-henry">{{ Session::get('UserFullName') }}</span>

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
                    <form id="logout-form" action="{{ route('logout', ['customer' => $customerName]) }}" method="POST" style="display: none;">
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
                            style="background-color: #1a4f6e; border-color: #1a4f6e; color:white;">Mark As Read
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

</body>
