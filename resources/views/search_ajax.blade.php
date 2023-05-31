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
            <th class="align-middle">FICA Status</th>
            <th class="align-middle">Created Date</th>
            <th class="align-middle">Last Updated</th>
        </tr>
    </thead>

    <tbody id="tablebody">
        <form method="POST" action="{{ route('display-admin-findusers') }}" id="returnid">

            @foreach ($users as $key => $user)
            <?php $idNumber='idNumber_'.$key; ?>
            <tr>
                <td>
                    <button class="idnumber" id=<?= $idNumber; ?> style="background: none!important;border: none;padding: 0!important;font-family: arial, sans-serif;color: #0000FF;font-weight: 600;text-decoration: underline;cursor: pointer;">
                        {{ $user->IDNUMBER }}
                    </button>
                </td>
                <td>{{ $user->FirstName }}</td>
                <td>{{ $user->Surname }}</td>
                <!-- <td>{{ $user->Email }}</td> -->
                <td>{{ $user->FICAStatus }}</td>
                <td><?php echo date("D, d M Y H:i A", strtotime($user->CreatedOnDate)); ?></td>
                <td><?php echo date("D, d M Y H:i A", strtotime($user->LastUpdatedDate)); ?></td>
            </tr>
            @endforeach

        </form>
    </tbody>
</table>
<br />


<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            /* "bPaginate": false,
            "bFilter": false,
            "bInfo": false */
        });
    });
</script>
