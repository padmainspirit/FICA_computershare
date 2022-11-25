<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | FICA - V1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="icon" href="{{ URL::asset($Icon) }}">
    @include('layouts.head-css')
</head>

@section('body')

    {{-- <body data-sidebar="dark"> --}}
@show
<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.topbar')
    {{-- @include('layouts.sidebar') --}}
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content" style="margin-left: 0px;">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
{{-- @include('layouts.right-sidebar') --}}
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')
</body>


<script type="text/javascript">
    $(document).ready(function() {
        /* Circular Progress Bar  */
        $(".circle_percent").each(function() {
            var $this = $(this),
                $dataV = $this.data("percent"),
                $dataDeg = $dataV * 3.6,
                $round = $this.find(".round_per");
            $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
            $this.append('<div class="circle_inbox"><span class="percent_text"></span></div>');
            $this.prop('Counter', 0).animate({
                Counter: $dataV
            }, {
                duration: 2000,
                easing: 'swing',
                step: function(now) {
                    $this.find(".percent_text").text(Math.ceil(now) + "%");
                }
            });
            if ($dataV >= 51) {
                $round.css("transform", "rotate(" + 360 + "deg)");
                setTimeout(function() {
                    $this.addClass("percent_more");
                }, 1000);
                setTimeout(function() {
                    $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
                }, 1000);
            }
        });
        /*End Circular Progress Bar  */

    });
</script>

</html>
