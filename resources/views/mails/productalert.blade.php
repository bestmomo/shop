<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
  <title></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    #outlook a {
      padding: 0;
    }

    body {
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }

    table,
    td {
      border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }

    p {
      display: block;
      margin: 13px 0;
    }

    @media only screen and (min-width:480px) {
      .mj-column-per-100 {
        width: 100% !important;
        max-width: 100%;
      }
    }

    @media only screen and (max-width:480px) {
      table.mj-full-width-mobile {
        width: 100% !important;
      }

      td.mj-full-width-mobile {
        width: auto !important;
      }
    }
  </style>
</head>

<body style="background-color:#FFFFFF;">
  <div style="background-color:#FFFFFF;">
    <div style="margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
        <tbody>
          <tr>
            <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:20px;padding-top:20px;text-align:center;">
              <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                  <tr>
                    <td align="center" style="font-size:0px;padding:10px 25px;padding-top:10px;padding-right:0px;padding-bottom:10px;padding-left:0px;word-break:break-word;">
                      <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
                        <tbody>
                          <tr>
                            <td style="width:300px;">
                              <img alt="" height="auto" src="{{ asset('storage/photos/logo1.png') }}" style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;" width="300" />
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style="background:#356cc7;background-color:#356cc7;margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#356cc7;background-color:#356cc7;width:100%;">
        <tbody>
          <tr>
            <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:5px;padding-top:0;text-align:center;">
              <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                  <tr>
                    <td align="center" style="font-size:0px;padding:10px 25px;padding-top:28px;padding-right:25px;padding-left:25px;word-break:break-word;">
                      <div style="font-family:Helvetica;font-size:20px;line-height:1;text-align:center;color:#FFFFFF;">@lang('Stock alert')</div>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" style="font-size:0px;padding:10px 25px;padding-top:10px;padding-right:25px;padding-bottom:28px;padding-left:25px;word-break:break-word;">
                      <div style="font-family:Helvetica;font-size:20px;line-height:1;text-align:center;color:#FFFFFF;">@langL('Of product') {{ $product->name }}</div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style="background:#356cc7;background-color:#356cc7;margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#356cc7;background-color:#356cc7;width:100%;">
        <tbody>
          <tr>
            <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:5px;padding-top:0;text-align:center;">
              <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                  <tr>
                    <td style="font-size:0px;padding:10px 25px;padding-top:0;padding-right:20px;padding-bottom:0px;padding-left:20px;word-break:break-word;">
                      <p style="border-top:solid 2px #FFFFFF;font-size:1px;margin:0px auto;width:100%;">
                      </p>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" style="font-size:0px;padding:10px 25px;padding-top:28px;padding-right:25px;padding-bottom:20px;padding-left:25px;word-break:break-word;">
                      <div style="font-family:Helvetica;font-size:20px;line-height:1;text-align:center;color:#FFFFFF;">@lang('Remaining quantity') : {{ $product->quantity }}</div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style="background:#FFFFFF;background-color:#FFFFFF;margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="background:#FFFFFF;background-color:#FFFFFF;width:100%;">
        <tbody>
          <tr>
            <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0;text-align:center;">
              <div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
                  <tr>
                    <td align="center" style="font-size:0px;padding:10px 25px;padding-top:20px;padding-right:25px;padding-bottom:20px;padding-left:25px;word-break:break-word;">
                      <div style="font-family:Helvetica;font-size:15px;line-height:1;text-align:center;color:#555555;">{{ $shop->name }}</div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>
