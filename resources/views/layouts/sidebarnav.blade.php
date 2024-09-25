<div class="vertical-menu" style="background-color: white;">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->

        <div class="row">
            <div class="col-sm-11">
                <div class="card" style="margin-left: 15px;">

                  {{--  <a href="{{ url('/admin-dashboard') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3" style="background-color: #93186c; border-color: #93186c;  width: 100%">
                            <i class="bx text-white bx-task label-icon"></i>
                            Dashboard
                        </button>
                    </a> --}}
                    <a href="{{ url('/sb-dashboard') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3" style="background-color: #93186c; border-color: #93186c;  width: 100%">
                            <i class="bx text-white bx-task label-icon"></i>
                            Dashboard
                        </button>
                    </a>

                    <a href="{{ url('/admin-findusers') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3" style="background-color: #93186c; border-color: #93186c;  width: 100%">
                            <i class="bx text-white bx-desktop label-icon"></i>
                            Search Clients
                        </button>
                    </a>

                    <a href="{{ url('selfsb') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3"
                        style="background-color: #93186c; border-color: #93186c;  width: 100%">
                        <i class="bx text-white bxs-bank label-icon"></i>
                        Self Service Banking
                    </button>
                    </a>

                </div>
            </div>
        </div>

    </div>

    {{-- @endsection('admin-nav') --}}

</div>

<!-- Sidebar -->
</div>
