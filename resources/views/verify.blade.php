@extends('layouts.master')

@section('title')
    @lang('translation.Starter_Page')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Utility
        @endslot
        @slot('title')
            AWS Textract testing..!
        @endslot
    @endcomponent
@endsection
