<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 0; background-color: #455eb0; }
        a[x-apple-data-detectors] { color: inherit !important; text-decoration: inherit !important; }
        #MessageViewBody a { color: inherit; text-decoration: none; }
        p { line-height: inherit; }
        .desktop_hide, .desktop_hide table { display: none; max-height: 0; overflow: hidden; }
        .image_block img+div { display: none; }
        sup, sub { font-size: 75%; line-height: 0; }
        .list_block ul, .list_block ol { padding-left: 20px; }
        @media (max-width:700px) {
            .desktop_hide table.icons-inner, .social_block.desktop_hide .social-table { display: inline-block !important; }
            .icons-inner { text-align: center; }
            .icons-inner td { margin: 0 auto; }
            .image_block div.fullWidth { max-width: 100% !important; }
            .mobile_hide { display: none; }
            .row-content { width: 100% !important; }
            .stack .column { width: 100%; display: block; }
            .mobile_hide { min-height: 0; max-height: 0; max-width: 0; overflow: hidden; font-size: 0; }
            .desktop_hide, .desktop_hide table { display: table !important; max-height: none !important; }
        }
    </style>
</head>
<body class="body" style="margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
    <table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="background-color: #455eb0;" width="100%">
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="background-color: #455eb0;" width="100%">
                    <tr>
                        <td>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="color: #000000; width: 680px; margin: 0 auto;" width="680">
                                <tr>
                                    <td class="column column-1" style="font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top;" width="100%">
                                        <div class="spacer_block block-1" style="height:40px;line-height:40px;font-size:1px;"> </div>
                                        <div class="spacer_block block-2" style="height:40px;line-height:40px;font-size:1px;"> </div>
                                        <table border="0" cellpadding="0" cellspacing="0" class="image_block block-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                            <tr>
                                                <td class="pad" style="width:100%;padding-right:0px;padding-left:0px;">
                                                    <div align="center" class="alignment" style="line-height:10px">
                                                        <div class="fullWidth" style="max-width: 578px;"><a href="www.example.com" style="outline:none" tabindex="-1" target="_blank"><img alt="Lady Baking" height="auto" src="{{ asset('storage/photos/logo1.png') }}" style="display: block; height: auto; border: 0; width: 100%; padding:0 15px 0 15px;" title="Lady Baking" width="578"/></a></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="spacer_block block-4" style="height:20px;line-height:20px;font-size:1px;"> </div>
                                        <table border="0" cellpadding="10" cellspacing="0" class="paragraph_block block-5" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad">
                                                    <div style="color:#ffffff;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:30px;line-height:150%;text-align:center;">
                                                        <p style="margin: 0;"><strong>@lang('Hello') {{ auth()->user()->name }} {{ auth()->user()->firstname }}</strong></p>
                                                        <p style="margin: 0;"><strong>@lang('Thank you for creating an account')</strong></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="10" cellspacing="0" class="paragraph_block block-6" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad">
                                                    <div style="color:#ffffff;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:18px;line-height:180%;text-align:center;">
                                                        <p style="margin: 0;">@lang('Your access code is') {{ auth()->user()->email }}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="10" cellspacing="0" class="divider_block block-7" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                            <tr>
                                                <td class="pad">
                                                    <div align="center" class="alignment">
                                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                            <tr>
                                                                <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #D6D3D3;"><span> </span></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-8" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:35px;padding-top:10px;">
                                                    <div style="color:#f8f8f8;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:21px;line-height:120%;text-align:center;">
                                                        <p style="margin: 0;">@lang('Safety tips')</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="20" cellspacing="0" class="list_block block-9" role="presentation" style="word-break: break-word; color: #f8f8f8; font-family: Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif; font-size: 16px; font-weight: 400; line-height: 120%; text-align: left;" width="100%">
                                            <tr>
                                                <td class="pad">
                                                    <div style="margin-left:-20px">
                                                        <ul style="margin-top: 0; margin-bottom: 0; list-style-type: revert;">
                                                            <li>@lang('Your account information must remain confidential.')</li>
                                                            <li>@lang('Never give them to anyone.')</li>
                                                            <li>@lang('Change your password regularly.')</li>
                                                            <li>@lang('If you believe that someone is using your account illegally, please notify us immediately.')</li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="10" cellspacing="0" class="divider_block block-10" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                            <tr>
                                                <td class="pad">
                                                    <div align="center" class="alignment">
                                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                            <tr>
                                                                <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #dddddd;"><span> </span></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-11" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:20px;padding-left:35px;padding-right:35px;padding-top:10px;">
                                                    <div style="color:#f8f8f8;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:18px;line-height:120%;text-align:center;">
                                                        <p style="margin: 0;">@lang('You can now order on') <a href="{{ route('home') }}" rel="noopener" style="text-decoration: underline; color: #ffffff;" target="_blank">@lang('our shop')</a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                    <tr>
                        <td>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="background-color: #455eb0; color: #000000; width: 680px; margin: 0 auto;" width="680">
                                <tr>
                                    <td class="column column-1" style="font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top;" width="100%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-1" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-left:35px;padding-right:10px;padding-top:10px;">
                                                    <div style="color:#ffffff;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:16px;line-height:150%;text-align:left;">
                                                        <p style="margin: 0;">@lang('Questions?')<br/></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-2" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:35px;padding-top:10px;">
                                                    <div style="color:#f8f8f8;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:14px;line-height:120%;text-align:left;">
                                                        <p style="margin: 0;">@lang('You can') <a href="mailto:{{ $shop->email }}" rel="noopener" style="text-decoration: underline; color: #ebe9f0;" target="_blank">@lang('send us a message')</a>.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                    <tr>
                        <td>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="background-color: #455eb0; color: #000000; width: 680px; margin: 0 auto;" width="680">
                                <tr>
                                    <td class="column column-1" style="font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top;" width="50%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-1" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:35px;padding-top:10px;">
                                                    <div style="color:#f8f8f8;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:14px;line-height:120%;text-align:left;">
                                                        <p style="margin: 0;"><a href="{{ route('pages', ['page' => 'livraisons']) }}" rel="noopener" style="text-decoration: underline; color: #ffffff;" target="_blank">@lang('Shipping')</a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-2" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:35px;padding-top:10px;">
                                                    <div style="color:#f8f8f8;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:14px;line-height:120%;text-align:left;">
                                                        <p style="margin: 0;"><a href="{{ route('pages', ['page' => 'mentions-legales']) }}" rel="noopener" style="text-decoration: underline; color: #ffffff;" target="_blank">@lang('Legal informations')</a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="column column-2" style="font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top;" width="50%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-1" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:35px;padding-top:10px;">
                                                    <div style="color:#f8f8f8;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:14px;line-height:120%;text-align:left;">
                                                        <p style="margin: 0;"><a href="{{ route('pages', ['page' => 'conditions-generales-de-vente']) }}" rel="noopener" style="text-decoration: underline; color: #ffffff;" target="_blank">@lang('Terms and conditions of sale')</a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-2" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:10px;padding-left:35px;padding-right:35px;padding-top:10px;">
                                                    <div style="color:#f8f8f8;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:14px;line-height:120%;text-align:left;">
                                                        <p style="margin: 0;"><a href="{{ route('pages', ['page' => 'respect-environnement']) }}" rel="noopener" style="text-decoration: underline; color: #ffffff;" target="_blank">@lang('Environmental protection')</a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                    <tr>
                        <td>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="background-color: #455eb0; color: #000000; width: 680px; margin: 0 auto;" width="680">
                                <tr>
                                    <td class="column column-1" style="font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top;" width="100%">
                                        <table border="0" cellpadding="10" cellspacing="0" class="divider_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                            <tr>
                                                <td class="pad">
                                                    <div align="center" class="alignment">
                                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                            <tr>
                                                                <td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 1px solid #FFFFFF;"><span> </span></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                    <tr>
                        <td>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="background-color: #455eb0; color: #000000; width: 680px; margin: 0 auto;" width="680">
                                <tr>
                                    <td class="column column-1" style="font-weight: 400; text-align: left; vertical-align: top;" width="50%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-1" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:10px;padding-left:25px;padding-right:10px;padding-top:10px;">
                                                    <div style="color:#ffffff;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:18px;line-height:120%;text-align:left;">
                                                        <p style="margin: 0;"><strong>@lang('Social medias')</strong></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" class="social_block block-2" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:15px;padding-left:20px;text-align:left;padding-right:0px;">
                                                    <div align="left" class="alignment">
                                                        <table border="0" cellpadding="0" cellspacing="0" class="social-table" role="presentation" style="display: inline-block;" width="47px">
                                                            <tr>
                                                                <td style="padding:0 15px 0 0;"><a href="{{ $shop->facebook }}" target="_blank"><img alt="Facebook" height="auto" src="{{ asset('storage/photos/facebook2x.png') }}" style="display: block; height: auto; border: 0;" title="Facebook" width="32"/></a></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="column column-2" style="font-weight: 400; text-align: left; vertical-align: top;" width="50%">
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-1" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:10px;padding-left:25px;padding-right:10px;padding-top:10px;">
                                                    <div style="color:#ffffff;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:18px;line-height:120%;text-align:left;">
                                                        <p style="margin: 0;"><strong>@lang('Call us')<br/></strong></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-2" role="presentation" style="word-break: break-word;" width="100%">
                                            <tr>
                                                <td class="pad" style="padding-bottom:20px;padding-left:25px;padding-right:10px;padding-top:10px;">
                                                    <div style="color:#C0C0C0;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:19px;line-height:180%;text-align:left;">
                                                        <p style="margin: 0;">{{ $shop->phone }}<br/></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
             </td>
        </tr>
    </table>
</body>
</html>
