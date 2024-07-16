@extends('layouts.admin-app')

{{-- @section('title')
    @lang('translation.User_List')
@endsection --}}

@section('css')
@endsection

@section('content')

        <div class="heading-fica-id mb-4">
            <div class="text-center">
                <h4 class="font-size-18"
                    style="color: #fff; padding-top:10px;margin-top: 12px;padding-bottom: 5px;">
                    Edit Company
                </h4>
            </div>
        </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::model($company, ['method' => 'PATCH', 'route' => ['companies.update', $company->Id],'enctype' => 'multipart/form-data']) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Company Name:</strong>
                {!! Form::text('Company_Name', null, ['placeholder' => 'Company Name', 'class' => 'form-control']) !!}
            </div>
        </div>
        
        <!-- <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Font Code:</strong>
                {!! Form::text('Client_Font_Code', null, ['placeholder' => 'Font Code', 'class' => 'form-control']) !!}
            </div>
        </div> -->        
        
        <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="padding-top:20px">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</body>
@endsection
@section('script')
@endsection
