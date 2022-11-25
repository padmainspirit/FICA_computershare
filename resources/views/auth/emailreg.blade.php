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
                <h1 style="font-size: 20px;font-family:Arial,sans-serif;">Your registration details</h1>
            </td>
        </tr>
    </table>

    <!-- Body -->
    <table role="presentation" border="0" width="75%" cellspacing="0">
        <tr>
            <td style="padding: 30px 30px 30px 30px;color:#696969;">
                <p class="font-weight-bold"
                    style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">Dear
                    <span style="color: #93186c">{{ $FirstName }} {{ $LastName }}</span>
                </p>
                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">Thank you for visiting Computershare’s website to 
                    complete our electronic FICA verification process.</p>
                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">Your
                    temporary login details are:</p>
                <ul>
                    <li style="font-size:16px;">
                        Username: <span style="color: #93186c">{{ $Email }}</span>
                    </li>
                    <li style="font-size:16px;">
                        Password: <span style="color: #93186c">{{ $Password }}</span>
                    </li>
                </ul>
                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">These will be
                    valid for the next 24 hours, using the button below to login to your account.</p>

                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">CLICK HERE TO
                    LOGIN: <span style="color: #93186c">(https://www.computershare.com/ZA)</span></p>

                {{-- <a href="https://www.computershare.com/ZA"> --}}
                    {{-- <button class="btn" style="margin:0 0 12px 0;border: 2px solid;background-color: white;border-color: #93186c;
                    color: black;padding: 8px 16px;font-size: 16px;cursor: pointer;">CLICK HERE TO LOGIN</button> --}}
                {{-- </a> --}}

                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">If it wasn’t
                    you whom the message is intended for, please delete this email, ignore or contact our Call Centre:
                    0861 100 933.</p>
                <p></p>
                <p style="font-size:14px">Yours faithfully,</p>
                <p style="font-size:14px">{{ $TradingName }}</p>
                <p></p>
                <p></p>
                <p style="font-size:14px">
                    Copyright © {{ $YearNow }} {{ $TradingName }} South Africa. All rights reserved.
                    {{ $TradingName }} respects your privacy. For more information, 
                    view our privacy policy. The information contained herein is subject to change without notice. 
                    {{ $TradingName }} shall not be liable for technical or editorial errors or omissions contained herein.
                </p>
            </td>
        </tr>
    </table>
