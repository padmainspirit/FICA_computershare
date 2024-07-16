@extends('layouts.master-display')



@section('css')
    <!-- Plugins css -->
    <link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />

  
@endsection

@section('content')




    <div class="heading-fica-id mb-4">
            <div class="text-center">
                <h4 class="font-size-18"
                    style="color: #fff; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                    Manage CS Companies
                </h4>
            </div>
        </div>
                  
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('companies.create') }}"> Create New CS Company</a>
      </div>
  <br />


  @if ($message = Session::get('success'))
  <div class="alert alert-success">
    <p>{{ $message }}</p>
  </div>
  @endif

  {{-- <!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" /> --}}

  <table class="table table-bordered border-dark mb-0">
    <tr>
      <th>No</th>
      <th>Company Name</th>
      <th width="280px">Action</th>
    </tr>
    @foreach ($data as $key => $company)
    <tr>
      <td>{{ ++$i }}</td>

      <td>{{ $company->Company_Name }}</td>
      <td>
        <!-- <?php //$url = 'URL for checking the dividends for this company is, \r\n '.route('dividend-check',$customer->Id); 
              ?>
        <a class="btn btn-info" onclick="alert('<?php //echo $url ;
                                                ?>')">View Url</a> -->
        <a class="btn btn-primary" href="{{ route('companies.edit',$company->Id) }}">Edit</a>
        {!! Form::open(['method' => 'DELETE','route' => ['companies.destroy', $company->Id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
      </td>
    </tr>

    @endforeach
  </table>


  {!! $data->render() !!}


@endsection

@section('script')
@endsection