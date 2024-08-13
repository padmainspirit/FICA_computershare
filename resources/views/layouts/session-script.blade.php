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
                <span style="color: #696969"><p id="countdown">Time remaining: 00:00</p> to expire your session, please click on the Clear Session button to
                    clear your session or on stay connected to continue.</span>
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

    /*function clearSession()
    {
        sessionStorage.removeItem('sbid');
        window.location="/";
    }

    $(document).ready(function() {
        var idleState = false;
        var idleTimer = null;
        var idleTimer2 = null;
        const countdownElement = document.getElementById('countdown');
        const timeout = 180000; <?php //echo config("app.SYSTEM_IDLE_TIME");?>;//300000; // 300000 ms = 5 minutes
        const modaltime = <?php echo config("app.POPUPDISPLAY_AFTER_IDLE_TIME");?>;
        let timeRemaining = (modaltime/1000);
        let countdownInterval;
            
        function updateCountdown()
        {
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            countdownElement.textContent = `Time remaining: ${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            timeRemaining--;

            if (timeRemaining < 0) {
                clearInterval(countdownInterval);
            }
        }

        $('*').bind(
            'mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick'
            , function() {
                clearTimeout(idleTimer);
                
                idleState = false;
                idleTimer = setTimeout(function() {
                    document.getElementById('modalbtn').click();

                    countdownInterval = setInterval(updateCountdown, 1000);

                    idleTimer2 = setTimeout(function() {
                        sessionStorage.removeItem('sbid');
                        window.location="/";
                        idleState = true;
                    }, modaltime);
                }, timeout);

            });
        $("body").trigger("mousemove");
        
    });
*/
    </script>

</body>