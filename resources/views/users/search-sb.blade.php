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
                <th class="align-middle">Flow Status</th>
                <th class="align-middle">Created Date</th>
                <th class="align-middle">Last Updated</th>
            </tr>
        </thead>

        <tbody id="tablebody">
            <form method="POST" action=""
                id="returnid">

                        @forelse ($results as $key => $value)
                        <tr>
                            <td>
                                @if($value->FICAStatus!="Completed")
                                {{ $value->IDNUMBER }}
                                    @else
                                    <a style="background: none!important;border: none;padding: 0!important;font-family: arial, sans-serif;color: #0000FF;font-weight: 600;text-decoration: underline;cursor: pointer;" href="{{ url('/sb-results') }}/{{ $value->SelfBankingDetailsId }}">{{ $value->IDNUMBER }}</a>
                                @endif
                                </td>
                            <td>{{ $value->FirstName }}</td>
                            <td>{{ $value->Surname }}</td>
                            <td>{{ $value->FICAStatus }}</td>

                            <td>{{ date("d-m-Y H:i",strtotime($value->CreatedOnDate)) }}</td>
                            <td>{{ date("d-m-Y H:i",strtotime($value->LastUpdatedDate)) }}</td>


                        </tr>
                    @empty
                        <tr><td colspan="6"><center>No Records Found</center></td></tr>
                    @endforelse

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
