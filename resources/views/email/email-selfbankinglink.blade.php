<div align="center" id="email" style="width:600px;margin: auto;background:white;">
    <!-- Header -->
    <table role="presentation" bgcolor="#93186c" border="0" width="75%" cellspacing="0">
        <tr>
            <td bgcolor="#93186c" align="left" style="color: white; padding: 20px 20px 60px 20px;">
                <!-- top right bottom left -->
                <img alt="LOADING" src="{{ URL::asset('/assets/images/computershareemaillogo.png') }}" width="20%">
            </td>
        </tr>
        <tr>
            <td bgcolor="#93186c" align="left" style="color: white; padding: 20px 20px 20px 20px;">
                <h1 style="font-size: 20px;font-family:Arial,sans-serif;">Self Service Banking Link</h1>
            </td>
        </tr>
    </table>

    <!-- Body -->
    <table role="presentation" border="0" width="75%" cellspacing="0">
        <tr>
            <td style="padding: 30px 30px 30px 30px;color:#696969;">
                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">Below is your
                    link for self service banking,<br/><br/>
                    <a href="{{ $linkGenerated }}" target="_blank">Click Here For Self Banking</a> 
                    <br/><br/>
                    Please note the link will be valid for the next 24 hours to complete the banking service.</p>
                <br>
                
                <br>
                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">If it wasn’t
                    you whom the message is intended for, please delete this email, ignore or contact our Call Centre:
                    0861 100 933.</p>
                <p></p>
                <p>Yours faithfully,</p>
                <p>{{ $TradingName }}</p>
                <p></p>
                <p></p>
                <p style="font-size:14px">
                    Copyright © {{ $YearNow }} {{ $TradingName }} South Africa. All rights reserved.
                </p>
                <p style="font-size:14px">
                    {{ $TradingName }} respects your privacy. For more information,
                    view our privacy policy. The information contained herein is subject to change without notice.
                    {{ $TradingName }} shall not be liable for technical or editorial errors or omissions contained
                    herein.
                </p>
            </td>
        </tr>
    </table>
</div>

<?php exit; ?>
