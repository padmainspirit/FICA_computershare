<div align="center" id="email" style="width:600px;margin: auto;background:white;">
    <!-- Header -->
    <img src="{{ URL::asset($Logo) }}" alt="LOADING" width="20%">

    <!-- Body -->

    <br>
    <table role="presentation" bgcolor="#fff" border="0" width="75%" cellspacing="0" style="border: 1.5px solid #1a4f6e;border-collapse: separate;border-radius: 6px;">
        <tr>
            <td style="padding: 30px 30px 30px 30px;color:#000000;">
                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">Dear {{$ClientFullName}},

                    </p>
                <br>
                <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">
                    {{$messagetyped}}
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

