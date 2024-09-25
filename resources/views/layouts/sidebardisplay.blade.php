<div class="vertical-menu" style="background-color: white;">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->

        <div class="row">
            <div class="col-sm-11">
                <div class="card" style="margin-left: 15px;">

                    <a href="{{ url('/roles') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3"
                            style="background-color: #93186c; border-color: #93186c;  width: 100%">
                            <i class="bx text-white bx-desktop label-icon"></i>
                            Edit Roles
                        </button>
                    </a>

                    <a href="{{ url('/admin-display') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3"
                            style="background-color: #93186c; border-color: #93186c;  width: 100%">
                            <i class="bx text-white bx-desktop label-icon"></i>
                            View Customers
                        </button>
                    </a>

                    <a href="{{ route('admin-customer') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3"
                            style="background-color: #93186c; border-color: #93186c;  width: 100%">
                            <i class="bx text-white bx-user-plus label-icon"></i>
                            Add New Customer
                        </button>
                    </a>

                    <a href="{{ route('users.create') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3"
                            style="background-color: #93186c; border-color: #93186c;  width: 100%">
                            <i class="bx text-white bx-user-plus label-icon"></i>
                            Add New Customer Users
                        </button>
                    </a>
                    

                    <!-- <a href="{{ route('send-selfservicelink') }}">
                        <button type="button" class="btn text-white waves-effect btn-label waves-light mt-3"
                            style="background-color: #93186c; border-color: #93186c;  width: 100%">
                            <i class="bx text-white bx-user-plus label-icon"></i>
                            Banking Self Service Link
                        </button>
                    </a> -->

                </div>
            </div>
        </div>

    </div>

    {{-- @endsection('admin-nav') --}}

</div>

<!-- Sidebar -->
</div>
