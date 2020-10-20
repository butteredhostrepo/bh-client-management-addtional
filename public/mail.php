<?php

function h4h_mail($to, $from, $subject, $msg, $type)
{
    $msg = '<html xmlns="https://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
                <!--[if gte mso 9]><xml>
                <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
                </o:OfficeDocumentSettings>
                </xml><![endif]-->
               
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
                <meta name="format-detection" content="telephone=no">
                <!--[if !mso]><!-->
                <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
                <!--<![endif]-->
                <style type="text/css">
                body {
                    margin: 0 !important;
                    padding: 0 !important;
                    -webkit-text-size-adjust: 100% !important;
                    -ms-text-size-adjust: 100% !important;
                    -webkit-font-smoothing: antialiased !important;
                }
                img {
                    border: 0 !important;
                    outline: none !important;
                }
                p {
                    Margin: 0px !important;
                    Padding: 0px !important;
                }
                table {
                    border-collapse: collapse;
                    mso-table-lspace: 0px;
                    mso-table-rspace: 0px;
                }
                td, a, span {
                    border-collapse: collapse;
                    mso-line-height-rule: exactly;
                }
                .ExternalClass * {
                    line-height: 100%;
                }
                .em_defaultlink a {
                    color: inherit !important;
                    text-decoration: none !important;
                }
                span.MsoHyperlink {
                    mso-style-priority: 99;
                    color: inherit;
                }
                span.MsoHyperlinkFollowed {
                    mso-style-priority: 99;
                    color: inherit;
                }
                 @media only screen and (min-width:481px) and (max-width:699px) {
                .em_main_table {
                    width: 100% !important;
                }
                .em_wrapper {
                    width: 100% !important;
                }
                .em_hide {
                    display: none !important;
                }
                .em_img {
                    width: 100% !important;
                    height: auto !important;
                }
                .em_h20 {
                    height: 20px !important;
                }
                .em_padd {
                    padding: 20px 10px !important;
                }
                }
                @media screen and (max-width: 480px) {
                .em_main_table {
                    width: 100% !important;
                }
                .em_wrapper {
                    width: 100% !important;
                }
                .em_hide {
                    display: none !important;
                }
                .em_img {
                    width: 100% !important;
                    height: auto !important;
                }
                .em_h20 {
                    height: 20px !important;
                }
                .em_padd {
                    padding: 20px 10px !important;
                }
                .em_text1 {
                    font-size: 16px !important;
                    line-height: 24px !important;
                }
                u + .em_body .em_full_wrap {
                    width: 100% !important;
                    width: 100vw !important;
                }
                }
                </style>
                </head>
                 
                <body class="em_body" style="margin:0px; padding:0px;" bgcolor="#efefef">
                <table class="em_full_wrap" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#efefef" align="center">
                  <tbody><tr>
                    <td valign="top" align="center"><table class="em_main_table" style="width:700px;" width="700" cellspacing="0" cellpadding="0" border="0" align="center">                      
                        <!--Banner section-->
                        <tr style="background: #FFF; padding:35px;">
                          <td valign="top" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                              <tbody><tr>
                                <td valign="top" align="center" style="padding:35px;"><img width="300px" alt="healing for the heart" src="https://admin.healingfortheheart.co.uk/wp-content/uploads/2020/05/H4HWORDLOGO-300x30-1.png" width="700" border="0"></td>
                              </tr>
                            </tbody></table></td>
                        </tr>
                        <!--//Banner section--> 
                        <tr>
                          <td style="padding:5PX;" class="" valign="top" bgcolor="#670001" align="center">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                              <tbody><tr>
                                <td style="font-family:"Open Sans", Arial, sans-serif; font-size:16px; line-height:30px; color:#ffffff;" valign="top" align="center">
                                <h2 style="color: #FFF;">' . $type . '</h2>
                                </td>
                              </tr>                              
                            </tbody></table></td>
                        </tr>
                        <!--Content Text Section-->
                        <tr>
                          <td style="padding:35px 70px 30px;" class="em_padd" valign="top" bgcolor="#FFF" align="left"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                              <tbody><tr>
                                <td style="font-family:"Open Sans", Arial, sans-serif; font-size:16px; line-height:30px; color:#ffffff;" valign="top" align="left">
                                ' . $msg . '
                                </td>
                              </tr>                              
                            </tbody></table></td>
                        </tr>
                 
                        <!--//Content Text Section--> 
                        <!--Footer Section-->
                        <tr >
                          <td style="padding:25px" class="em_padd" valign="top" bgcolor="#670001" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                              <tbody>
                              <tr>
                                <td style="font-family:"Open Sans", Arial, sans-serif; font-size:11px; line-height:18px; color:#FFF;" valign="top" align="center">
                                  <span style="color:#FFF;">Healing for the heart</span>
                                </td>
                              </tr>
                            </tbody></table></td>
                        </tr>
                        <tr>
                          <td class="em_hide" style="line-height:1px;min-width:700px;background-color:#ffffff;"><img alt="" src="images/spacer.gif" style="max-height:1px; min-height:1px; display:block; width:700px; min-width:700px;" width="700" border="0" height="1"></td>
                        </tr>
                      </tbody></table></td>
                  </tr>
                </tbody></table>
                <div class="em_hide" style="white-space: nowrap; display: none; font-size:0px; line-height:0px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
                </body></html>';

    $headers = "";
    // $headers = array("From: Healing for the Heart <$from>",);
    // wp_mail('winnard@butteredhost.com', 'Account', 'Test', $headers);
    wp_mail($to, $subject, $msg, $headers);
}
