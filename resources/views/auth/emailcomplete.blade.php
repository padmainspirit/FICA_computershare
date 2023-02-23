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
              <h1 style="font-size: 20px;font-family:Arial,sans-serif;">Your electronic FICA status update</h1>
          </td>
      </tr>
  </table>

  <!-- Body -->
  <table role="presentation" border="0" width="75%" cellspacing="0">
      <tr>
          <td style="padding: 30px 30px 30px 30px;color:#696969;">
            <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">Dear {{$FirstName}}</p>

            <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">Thank you for your time in completing the electronic FICA verification process. 
                We’re now in the process of creating your account. Once this has been set up, 
                we’ll send you your account information so you can start growing your investor portfolio.
            </p>
            <p></p>
            <p></p>
            <p style="margin:0 0 12px 0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;">You will also have the benefit of using our <a href="https://content-videos.computershare.com/eh96rkuu9740/cb3e884fd9d64ed6ad2d1c26c15303ab/2edc2b0c75f95fbd2171ba94852bee24/ICR-Site-Tour-ZA.mp4" style="color: #93186c">Investor Centre Platform</a> 
                to securely and conveniently manage your shareholdings online, access shareholder documents such as dividend confirmations, 
                and be kept up to date on important corporate events relating to the companies you plan to invest in.
            </p>
            <p style="font-size:12px;background-color: #292929;color: #fff">
            Copyright © {{$YearNow}} <a href="https://www.computershare.com/za" style="color: #fff">Computershare South Africa.</a> All rights reserved.
            </p>
          </td>
      </tr>
  </table>