<header id="page-topbar" style="background-color: rgb(255, 255, 255);">

    <div class="navbar-header">

        <div class="logo-lg">
            <img src="{{ URL::asset($Logo) }}" alt="" width="150" style="margin-left: 20%;">
        </div>

        <div class="d-flex flex-wrap">

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
