<!-- JAVASCRIPT -->
<script src="{{ URL::asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/metismenu/metismenu.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js') }}"></script>

<!-- App js -->
<script src="{{ URL::asset('assets/js/app.min.js') }}"></script>

<!-- pace js -->
<script src="{{ URL::asset('assets/libs/pace-js/pace-js.min.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Buttons examples -->
<script src="{{ URL::asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>


<!-- Responsive examples -->
<script src="{{ URL::asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>

@yield('script')

@yield('script-bottom')