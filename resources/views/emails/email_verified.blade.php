@extends('emails.index')

@section('content')
<table class="gmail-app-fix">
    <tbody>
        <tr>
            <td>
                <table width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                        <tr>
                            <td cellpadding="0" cellspacing="0" border="0" style="line-height: 1px; min-width: 200px;" height="1"><img src="https://www.wisework.in/emailer/29/images/spacer.gif" style="display: block; max-height: 1px; min-height: 1px; min-width: 200px; width: 200px;" width="200" height="1"></td>
                            <td cellpadding="0" cellspacing="0" border="0" style="line-height: 1px; min-width: 200px;" height="1"><img src="https://www.wisework.in/emailer/29/images/spacer.gif" style="display: block; max-height: 1px; min-height: 1px; min-width: 200px; width: 200px;" width="200" height="1"></td>
                            <td cellpadding="0" cellspacing="0" border="0" style="line-height: 1px; min-width: 200px;" height="1"><img src="https://www.wisework.in/emailer/29/images/spacer.gif" style="display: block; max-height: 1px; min-height: 1px; min-width: 200px; width: 200px;" width="200" height="1"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<table width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
    <tbody>
        <tr>
            <td style="color:#ffffff; font-size:1px; font-family:Arial, Helvetica, sans-serif;" valign="middle" align="center"></td>
        </tr>
        <tr>
            <td valign="top" align="center">
                <table style="font-size:0" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                        <tr>
                            <td valign="top" bgcolor="#9A9A9A" align="left" style="line-height:1px"><img style="display:block" src="https://www.wisework.in/emailer/29/images/spacer.gif" width="1" height="1"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="left">
                                <table width="600" cellspacing="0" cellpadding="0" border="0">
                                    <tbody>

                                        <tr valign="top" align="center" style="">
                                            <td width="1" bgcolor="#9A9A9A"><img style="display:block" src="https://www.wisework.in/emailer/29/images/spacer.gif" width="1" height="1"></td>
                                            <td width="598" align="center">
                                                <table width="598" cellspacing="0" cellpadding="0" border="0" align="center">
                                                    <tr>
                                                        <td align="center" valign="top" bgcolor="#ffffff" style="">
                                                        <?php $logo = str_replace(" ","%20","Rummy Boss Logo.png");?>
                                                            <img src='{{asset("assets/img/{$logo}")}}' class="logo" height="150" style="">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td width="598" align="left" valign="top" style="color:#f00;text-align: center;font-size: 16px;font-family: Arial;">
                                                            <h4>Email Verified Successfully</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="598" align="left" valign="top" style="color:#000;text-align: center;font-size: 16px;font-family: Arial;">
                                                            <p>Dear {{$username}},</p>
                                                            <p>Thank you for verifying your email.</p>
                                                        </td>
                                                    </tr>

                                                    


                                                    <!--  <tr><td align="center" valign="top">Earn <b>Rs. 3 Extra on<br> Redeem</b> for every <br>Unique Referal!s</td></tr> -->

                                                </table>
                                            </td>
                                            <td width="1" bgcolor="#9A9A9A"><img style="display:block" src="https://www.wisework.in/emailer/29/images/spacer.gif" width="1" height="1"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" bgcolor="#9A9A9A" align="left" style="line-height:1px"><img style="display:block" src="https://www.wisework.in/emailer/29/images/spacer.gif" width="1" height="1"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@endsection