@extends('layouts.master-dashboard')

@section('title')
{{-- @lang('translation.User_List') --}}
@endsection

@section('css')
    <!-- Plugins css -->
    <link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div>
                    <form action="#" class="dropzone">
                        <div class="fallback">
                            <input name="file" type="file" multiple="multiple">
                        </div>
                        <div class="dz-message needsclick">
                            <div class="mb-3">
                                <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                            </div>

                            <h4>Drop files here or click to upload.</h4>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <button type="button" class="btn btn-primary waves-effect waves-light">Send Files</button>
                </div>

                <div class="mb-3 mt-3 row justify-content-center">
                    <div class="col-md-6">
                        <select class="form-select">
                            <option>Select</option>
                            <option>Append the table</option>
                            <option>Truncate the table</option>
                        </select>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <!-- Static Backdrop modal Button -->
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Hide Model Button
                    </button>
                </div>

                <!-- Static Backdrop Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>I will not close if you click outside me. Don't even try to press escape key.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Understood</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@endsection

@section('script')
    <!-- Plugins js -->
    <script src="{{ URL::asset('/assets/libs/dropzone/dropzone.min.js') }}"></script>
@endsection
