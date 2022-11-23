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
              <h1 style="font-size: 20px;font-family:Arial,sans-serif;">Newly Registered User</h1>
          </td>
      </tr>
  </table>

  <!-- Body -->
  <table role="presentation" border="0" width="75%" cellspacing="0">
      <tr>
          <td style="padding: 30px 30px 30px 30px;color:#696969;">
            <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Reset your password</h1>
            <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">Please click the link below to redirect you to our page, from there you will be able to safely reset your password.</p>
            <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">
                <a href="{{ url('auth/reset-password', $token) }}" style="font-size: 14px; font-weight: bold; color: #1e7ce9;">
                  Click here to reset your password.
                </a>
            </p>
            {{-- <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">For any queries, you can read our FAQs online by clicking here {Link to be added}.</p> --}}
            <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">If it wasn’t you whom the message is intended for, please delete this email, ignore or contact our Call Centre: 0861 100 933.</p>
            <p></p>
            <p>Yours faithfully,</p>
            <p style="font-size:14px">{{$TradingName}} </p>
            <p></p>
            <p style="font-size:14px">
              © {{$YearNow}}
              {{$TradingName}}. {{$TradingName}} respects your privacy. For more information, view our privacy policy <http://www.computershare.com/za/Pages/privacy-policy.aspx>.
              The information contained herein is subject to change without notice. {{$TradingName}} shall not be liable for technical or editorial errors or omissions contained herein.
            </p>
          </td>
      </tr>
  </table>