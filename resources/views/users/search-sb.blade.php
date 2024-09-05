@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
        <thead>
            <tr>
                <th class="align-middle">ID Number</th>
                <th class="align-middle">First Name</th>
                <th class="align-middle">Last Name</th>
                <!-- <th class="align-middle">Email</th> -->
                <th class="align-middle">AVS Status</th>
                <th class="align-middle">Created Date</th>
                <th class="align-middle">Last Updated</th>
            </tr>
        </thead>

        <tbody id="tablebody">
            <form method="POST" action=""
                id="returnid">

                        @foreach ($users as $key => $user)
                        <?php $idNumber='idNumber_'.$key; ?>
                            <tr>
                                <td><a style="background: none!important;border: none;padding: 0!important;font-family: arial, sans-serif;color: #0000FF;" href="{{ route('sb-results') }}">960416518289</a></td>
                                <td>Fortune</td>
                                <td>Ngwenya</td>

                                <td>Passed</td>
                                <td>12 July 2024 13:32</td>
                                <td>12 July 2024 13:56</td>
                            </tr>
                        @endforeach
            </form>
        </tbody>
    </table>
<br/>


<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            /* "bPaginate": false,
            "bFilter": false,
            "bInfo": false */
            buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
         ]
        });
    } );
</script>
