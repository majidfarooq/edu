<html><head></head><body style="
     text-align: center;
     display: inline-block;
     position: relative;
     margin: 0 auto;
     width: 100%;
"><table border="0" cellpadding="0" cellspacing="0" class="marginFix" width="100%" style="
    text-align: center !important;
    width: 100%;
    margin: 0 auto;
    position: relative;
    display: inline;
">
    <!-- GRAY BACKGROUND -->
    <tbody>
    <tr>
        <td align="center" bgcolor="#ffffff" class="mobContent" width="660">
            <!-- inner container / place all modules below -->
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <!-- BEGIN MAIN CONTENT -->
                <tbody>
                <tr>
                    <td align="center" valign="top" width="600">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                            <tr class="no_mobile_phone">
                                <td bgcolor="#f2f2f2" style="padding-top:10px;"></td>
                            </tr>
                            <tr>
                                <td bgcolor="#f2f2f2" style="padding-top:10px;"></td>
                            </tr>
                            <tr>
                                <td align="center" bgcolor="#ffffff" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" contenteditable="false" style="padding-top: 15px !important;margin-bottom: 0;width: 100%;text-align: center;">
                                        <tbody>
                                        <tr valign="bottom">
                                            <td align="center" valign="top" width="20">&nbsp;</td>
                                            <td align="" height="64">
                                                <img alt="GTS" border="0" height="46" src="https://mygts.gatewaytaxservice.com/public/assets/frontend/images/logo.png" style="width: auto;">
                                            </td>
                                            <td align="center" valign="top" width="40">&nbsp;</td>
                                            <td align="right">
                                            <span style="padding-top:15px; padding-bottom:10px; font:italic 12px; Calibri, Trebuchet, Arial, sans serif; color: #757575;line-height:15px;">
                                            </span>
                                            </td>
                                            <td align="center" valign="top" width="20">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- logo - start -->
                                    <!-- body - start -->
                                    <table border="0" cellpadding="0" cellspacing="0" contenteditable="false" style="padding-bottom:10px; padding-top:10px;margin-bottom: 20px;" width="100%">
                                        <tbody>
                                        <tr valign="bottom">
                                            <td align="center" valign="top" width="20">&nbsp;</td>
                                            <td class="ppsans" style="font-family:Calibri, Trebuchet, Arial, sans serif; font-size:15px; line-height:22px; color:#333333;" valign="top">
                                                <div style="margin-top: 10px;color:#333 !important;font-family: arial,helvetica,sans-serif;font-size:12px;">
                                                    @if(isset($data['extension']) && $data['extension']=='png')
                                                        <h3 style="color:#333333 !important;font-weight:bold;font-family: arial,helvetica,sans-serif;text-align: center;width: 100%;display: inline-block;">Png File Upload Triggered</h3>
                                                    @else
                                                        <h3 style="color:#333333 !important;font-weight:bold;font-family: arial,helvetica,sans-serif;text-align: center;width: 100%;display: inline-block;">Larger Image Upload Triggered..</h3>
                                                    @endif
                                                    <div class="mpi_image" style="margin:auto;clear:both;"></div>

                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" contenteditable="false" style="border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;color:#333 !important;font-family: arial,helvetica,sans-serif;font-size:12px;margin-bottom:10px;" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <table border="0" cellpadding="0" cellspacing="0" contenteditable="false" style="width:100%; color:#333 !important;font-family: arial,helvetica,sans-serif;font-size:12px;margin-top: 10px;">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="width:100%;text-align: left;display: inline-block;padding: 5px; font-size: 16px">(1): Name: @if(isset($data['first_name'])) {{$data['first_name'].' '.$data['first_name']}} @endif</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:100%;text-align: left;display: inline-block;padding: 5px; font-size: 16px">(2): Email: @if(isset($data['user_email'])) {{$data['user_email']}} @endif</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:100%;text-align: left;display: inline-block;padding: 5px; font-size: 16px">(3): Location: @if(isset($data['location'])) {{$data['location']}} @endif</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:100%;text-align: left;display: inline-block;padding: 5px; font-size: 16px">(4): File Type: @if(isset($data['file_type'])) {{$data['file_type']}} @endif</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:100%;text-align: left;display: inline-block;padding: 5px; font-size: 16px">(5): Trigger Type: @if(isset($data['Trigger_type'])) {{$data['Trigger_type']}} @endif</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:100%;text-align: left;display: inline-block;padding: 5px; font-size: 16px">(6): File: <a @if(isset($data['file'])) href="{{ asset("public".\Illuminate\Support\Facades\Storage::url($data['file'])) }}" @endif download>View File</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="width:100%;text-align:right; padding:0 10px 10px 0;"></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <span style="font-size:11px;color:#333;text-align: center;margin: 0 auto !important;width: 100%;display: block;">Questions? Call 1-877-513-1040</span>
                                                    <br>
                                                    <span style="font-size:11px;color:#333;text-align: center;margin: 0 auto !important;width: 100%;display: block;">This account email has been sent to you as part of your Gateway Tax Service myGTS secure account</span>
                                                    <br>
                                                    {{--                                                    <span style="font-size:11px;color:#333;text-align: center;margin: 0 auto !important;width: 100%;display: block;">To change your email preferences at any time, please contact us. Please do not reply to this email, as we are unable to respond from this email address. If you need help or would like to contact us, please visit our Help Center Here </span>--}}
                                                    {{--                                                    <br>--}}
                                                    <span style="font-size:11px;color:#333;text-align: center;margin: 0 auto !important;width: 100%;display: block;">This message was mailed to @if(isset($data['email'])){{ $data['email'] }} @endif by Gateway Tax Service</span>
                                                    <br>
                                                    <span style="font-size:11px;color:#333;text-align: center;margin: 0 auto !important;width: 100%;display: block;">We Get you Paid Fast!<br>
                                                        12 Convenient locations to serve you<br>
                                                        Los Angeles | Compton | Long Beach | Moreno Valley | Lancaster | Victorville<br>
                                                        1.877.513.1040
                                                        info@gatewaytaxservice.com
                                                    </span>
                                                </div>
                                                <p></p>
                                                <span style="font-weight:bold; color:#444;">
</span>
                                                <span></span>
                                            </td>
                                            <td align="center" valign="top" width="20">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <td align="center" valign="top" width="600">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                            <tr>
                                <td bgcolor="#f2f2f2" style="padding-top:20px;"></td>
                            </tr>
                            <tr>
                                <td align="center" bgcolor="#f2f2f2" valign="top">
                                    <!-- PLACE ALL MODS BELOW -->
                                    <table border="0" cellpadding="0" cellspacing="0" contenteditable="false" width="100%">
                                        <tbody>
                                        <tr valign="bottom">
                                            <td>
                                                <!--  footer links -->
                                                <table align="left" border="0" cellpadding="0" cellspacing="0" class="mobile_table_width_utility_nav">
                                                    <tbody>
                                                    <tr>
                                                        <td class="ultility_nav_padding" style="font-family:Calibri, Trebuchet, Arial, sans serif; -webkit-font-smoothing: antialiased; font-size:13px; color:#666; font-weight:bold;">
<span id="bottomLinks">
</span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td align="center" valign="top" width="20">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table border="0" cellpadding="0" cellspacing="0" contenteditable="false" width="100%">
                                        <tbody>
                                        <tr valign="bottom">
                                            <td align="center" valign="top" width="20">&nbsp;</td>
                                            <td>
<span style="font-family:Calibri, Trebuchet, Arial, sans serif; font-size:13px; !important color:#8c8c8c;">
<table border="0" cellpadding="0" cellspacing="0" id="emailFooter" style="padding-top:20px;font:12px Arial, Verdana, Helvetica, sans-serif;color:#292929;" width="100%">
<tbody>
<tr>
<td>
</td>
</tr>
</tbody>
</table>
</span>
                                            </td>
                                            <td align="center" valign="top" width="20">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- PLACE ALL MODS ABOVE -->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <!-- END MAIN CONTENT -->
                </tr>
                </tbody>
            </table>
        </td>
        <td bgcolor="#f2f2f2" class="mobMargin" style="font-size:0px;">&nbsp;</td>
    </tr>
    <!-- END GRAY BACKGROUND -->
    </tbody>
</table>
</body></html>
