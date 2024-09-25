@extends('layouts.master-dashboard')

@section('title')
    @lang('translation.User_List')
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="main-content" style="margin-left: 0px;">
    <div class="page-content" style="padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
        <div class="row" id="card1" style="margin-left: 0px;margin-right: 0px;">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body" style="padding-bottom: 0px;padding-top: 0px;">

                        {{-- <h4 class="card-title mb-2 d-flex justify-content-left" style="font-size: 18px">
                            Client Search
                        </h4>

                        <hr style="color: #93186c ;border-top-style: solid;border-top-width: 2.5px;border-bottom-width: 2.5px;border: 1px solid #93186c; background-color: #93186c; opacity: 100%;"> --}}

                        <div class="heading-fica-id mt-2 mb-4">
                            <div style="background-image: linear-gradient(#93186c, #93186c);" class="text-center">
                                <h4 style="color: #fff; padding-top:8px;padding-bottom: 8px;padding-left: 11px;">
                                    Self service banking
                                </h4>
                            </div>
                        </div>

                        <form method="POST" action="" id="searchclient">

                            <input type="hidden" class="form-control input-sm" style="height: 27px; width: 10px; padding-left: 24px; width: 225px; text-transform: uppercase;" id="getRoleName" name="getRoleName" value="">



                            @csrf

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-firstname-input">ID Number</label>
                                            <input type="text" class="form-control" style="border-radius: 15px;" id="IDNumber" name="IDNumber" placeholder="Enter ID Number" value="" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-lastname-input">First Name</span></label>
                                            <input style="text-transform: uppercase;border-radius: 15px;" type="text" class="form-control" id="FirstName" name="FirstName" placeholder="Enter First Name" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-firstname-input">Last Name </label>
                                            <input type="text" style="text-transform: uppercase;border-radius: 15px;" class="form-control" id="LastName" name="LastName" placeholder="Enter Last Name" value="" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-firstname-input">Phone Number </label>
                                            <input type="text" style="border-radius: 15px;" class="form-control" id="phone" name="phone" placeholder="Enter Cellphone number" value="" >
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="basicpill-firstname-input">Flow Status </label>
                                            <select class="form-select" autocomplete="off"
                                            class="form-control" id="avsStatus" name="avsStatus" style="border-radius: 15px;">
                                            <option selected style="font-size: 12px;" disabled>
                                                Select
                                            </option>

                                            <option value="Completed" style="font-size: 12px;">
                                                Completed
                                            </option>
                                            <option value="Partially Completed" style="font-size: 12px;">
                                                Partially Completed
                                            </option>

                                            <option value="Failed" style="font-size: 12px;">
                                                Failed
                                            </option>

                                            <option value="In Progress" style="font-size: 12px;">
                                                In Progress
                                            </option>
                                            <option value="Rejected" style="font-size: 12px;">
                                                Rejected
                                            </option>
                                            <option value="Expired" style="font-size: 12px;">
                                                Expired
                                            </option>


                                        </select>
                                        </div>
                                    </div>

                                </div>
                            </div>




                            <span class="text-danger" id="error_msg" styel="display:none"></span><br />
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <button type="submit" id="submit" style="background-color: #91C60F; border-color: #91C60F;" class="btn w-md text-white">Search</button>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <button type="button" id="clearall" name="clearall" style="background-color: #91C60F; border-color: #91C60F;" class="btn w-md text-white">Clear</button>
                                    </div>
                                </div>

                            </div>

                        </form>



                        <br /><br />

                        <div id="search-container"></div>
                        <div id="pagination-links"></div>


                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

        </div>


    </div>

</div>

    <br /><br />

    <div id="search-container"></div>
    <div id="pagination-links"></div>



@endsection


@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    <script>
        function clearAll() {
            $('#search-container').html('');
            document.getElementById("error_msg").style.display = 'none';
            document.getElementById("IDNumber").value = '';
            document.getElementById("FirstName").value = '';
            document.getElementById("LastName").value = '';
            document.getElementById("avsStatus").value = '';
            document.getElementById("phone").value = '';

        }

        var btn = document.getElementById("clearall");
        btn.addEventListener("click", clearAll);
    </script>

<script>
    $(document).ready(function() {
        $("#submit").attr("disabled", false);
        //loadEmployees(1);
        // var IDNUMBER = sessionStorage.getItem("idNumber");
        // console.log(IDNumber);
        // if(IDNUMBER != null || IDNUMBER != ''){
        //     document.getElementById("IDNumber").value = IDNUMBER;
        //     validateForm();
        // }

        $(document).on('submit', '#searchclient', function(e) {
            e.preventDefault();
            validateForm();
            //loadEmployees(1);
        });

        function validateForm() {
            $('#search-container').empty();
            document.getElementById("error_msg").style.display = 'none';
            var idVal = document.getElementById("IDNumber").value;
            var fname = document.getElementById("FirstName").value;
            var lname = document.getElementById("LastName").value;
            var phone = document.getElementById("phone").value;
            var status = document.getElementById("avsStatus").value;


            if ((idVal === null || idVal === '') && (fname === null || fname === '') && (lname === null || lname === '') && (phone === null || phone === '')&& (status === null || status=== '')) {
                document.getElementById("error_msg").innerHTML = 'Please enter any of the search criteria';
                document.getElementById("error_msg").style.display = 'block';
                return false;
            } else {
                document.getElementById("error_msg").style.display = 'none';
                loadEmployees(1);
                return true;
            }
            return false;

        }


        function loadEmployees(page) {
            var form = $('#searchclient');
            var formData = form.serialize();
            $('#search-container').html('');
            $.ajax({
                url: "{{ route('search-sb') }}",
                method: 'POST',
                data: formData + '&page=' + page,
                success: function(response) {
                    $('#datatable').DataTable({
                        "destroy": true,
                    });

                    $('#search-container').html(response);

                    $('button.idnumber').on('click', function(val) {
                        //sessionStorage.setItem("idNumber", document.getElementById("IDNumber").value);
                        console.log(val);
                        var readIdNumber = this.id;
                        console.log('val' + readIdNumber);
                        //var IdButton = $('#' + readIdNumber).text();

                        // console.log(IdButton)
                        $("#complianceLiteId").val(readIdNumber)
                        $("#testresult-btn").click();
                    });
                }
            });


        }

        // $(document).on('click', '.pagination a', function(e) {
        //     e.preventDefault();
        //     var page = $(this).attr('href').split('page=')[1];
        //     loadEmployees(page);
        // });

    });
</script>
@endsection