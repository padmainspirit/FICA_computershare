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

        {{-- <span class="logo-lg">
            <img src="{{ URL::asset($Logo) }}" alt="" height="30">
            <img src="{{ asset($Logo) }}" alt="" height="30">
        </span> --}}

        <div class="logo-lg">
            <img src="{{ URL::asset($Logo) }}" alt="" width="150" style="margin-left: 20%;">
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/user.png" alt="Image Not Found" style="width: 25px;height: 25px;">
                    <span style="color: black" class="d-none d-xl-inline-block ms-1">
                        {{ $LogUserName }} {{ $LogUserSurname }}
                    </span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    {{-- <a class="dropdown-item" href="{{ url('/admin-screening-first') }}"><i
                            class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span>
                    </a> --}}

                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                            key="t-logout">Logout</span></a>
                    <form id="logout-form" action="{{ route('logout', ['customer' => $customerName]) }}"
                        method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>

</header>
