<!-- start page title -->
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .conainer {
        width: 300px;
        margin: 100px auto;
        font-family: 'Arial'
    }

    .circle_percent {
        font-size: 70px;
        width: 1em;
        height: 1em;
        position: relative;
        background: rgb(223, 223, 223);
        border-radius: 100%;
        overflow: hidden;
        display: inline-block;
        margin: 20px;
    }

    .circle_inner {
        position: absolute;
        left: 0;
        top: 0;
        width: 1em;
        height: 1em;
        clip: rect(0 1em 1em .5em);
    }

    .round_per {
        position: absolute;
        left: 0;
        top: 0;
        width: 1em;
        height: 1em;
        background: #6FD103;
        clip: rect(0 1em 1em .5em);
        transform: rotate(180deg);
        transition: 1.05s;
    }

    .percent_more .circle_inner {
        clip: rect(0 .5em 1em 0em);
    }

    .percent_more:after {
        position: absolute;
        left: .5em;
        top: 0em;
        right: 0;
        bottom: 0;
        background: #6FD103;
        content: '';
    }

    .circle_inbox {
        position: absolute;
        top: 7%;
        left: 7%;
        right: 7%;
        bottom: 7%;
        background: #f4f4fc;
        z-index: 3;
        border-radius: 50%;
    }

    .percent_text {
        position: absolute;
        color: black;
        font-weight: bold;
        font-size: 15px;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 3;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between"
            style="margin-left: 6%;margin-right: 3%;padding-top: 0px;padding-bottom: 0px;">

            <div class="row">
                <div class="col-8 d-sm-flex d-sm-flex align-items-center justify-content-between">
                    <h4 style="color:#000; font-weight:bold;margin-bottom: 0px;margin-top: 13%;">{{ $title }}</h4>
                </div>
                <div class="col-4" style="padding-left: 0px;">
                    <div class="circle_percent" data-percent="{{ (Session::get('FICAProgress') / 10) * 100 }}"
                        style="margin-top: 0px;margin-right: 0px;margin-bottom: 0px;">
                        <div class="circle_inner">
                            <div class="round_per"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div>{{ $FicaProcessController->fica() }}</div> --}}

            {{-- <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li style="color:#000; font-weight:bold" class="breadcrumb-item"><a
                            href="javascript: void(0);">{{ $li_1 }}</a></li>
                    @if (isset($title))
                        <li style="color:#000; font-weight:bold" class="breadcrumb-item"><a
                                href="javascript: void(0);">{{ $title }}</a></li>
                        <li style="color:#000; font-weight:bold" class="breadcrumb-item active">{{ $title }}</li>
                    @endif
                </ol>
            </div> --}}

        </div>
    </div>
</div>

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

<!-- end page title -->
