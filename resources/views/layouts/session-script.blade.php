<body>
    <!-- Static Backdrop modal Button -->
<button id="modalbtn" type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop" hidden>
    Static backdrop modal
</button>

<!-- Static Backdrop Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Your Session is About to Expire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <br/>
                <span style="color: #696969">Your Session will expire in 2 mins, please click on the logout button to
                    logout or on stay connected to continue.</span>
                <br/>
            </div>
            <div class="modal-footer">
                <button id="logoutbtn" type="button" onclick="clearSession();" class="btn btn-light" data-bs-dismiss="modal">Clear Session</button>
                <button id="staybtn" type="button" class="btn btn-primary" data-bs-dismiss="modal">Stay
                    Connected</button><!-- onclick="stayconnected()" -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function clearSession()
    {
        sessionStorage.removeItem('sbid');
        window.location="/";
    }

    $(document).ready(function() {
        var idleState = false;
        var idleTimer = null;
        var idleTimer2 = null;
        const timeout = <?php echo config("app.SYSTEM_IDLE_TIME");?>;//300000; // 300000 ms = 5 minutes
        const modaltime = <?php echo config("app.POPUPDISPLAY_AFTER_IDLE_TIME");?>;

        $('*').bind(
            'mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick'
            , function() {
                clearTimeout(idleTimer);
                idleState = false;
                idleTimer = setTimeout(function() {
                    document.getElementById('modalbtn').click();

                    idleTimer2 = setTimeout(function() {alert('inmodel');
                        sessionStorage.removeItem('sbid');
                        window.location="/";
                        idleState = true;
                    }, timeout);
                }, modaltime);

            });
        $("body").trigger("mousemove");
        
    });

    </script>

</body>