<div align="center" id="email" style="width:600px;margin: auto;background:white;">
    <!-- Header -->
    <img src="{{ URL::asset($Logo) }}" alt="LOADING" width="20%">

    <!-- Body -->
    <h1 style="color:#91C60F;font-size: 20px;font-family:Arial,sans-serif;margin-bottom: 0px;">Banking details update status</h1>
    <br>
    <table role="presentation" bgcolor="#fff" border="0" width="75%" cellspacing="0" style="border: 1.5px solid #1a4f6e;border-collapse: separate;border-radius: 6px;">
        <tr>
            <td style="padding: 30px 30px 30px 30px;color:#000000;">
                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">Dear {{$FirstName}} {{$Surname}},

                    </p>
                <br>
                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">
                    Your details have been verified and your account will be updated within 24 hours, followed by communication confirming that your account has been updated.
                </p>

                <br>
                {{-- <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">For any queries, you can read our FAQs online by clicking here {Link to be added}.</p> --}}

                <p></p>
                <p>Yours sincerely,</p>
                <p>{{ $TradingName }}</p>

                <p style="font-size:14px">
                    Copyright © {{ $YearNow }} {{ $TradingName }}. All rights reserved.
                </p>

            </td>
        </tr>
    </table>
</div>

