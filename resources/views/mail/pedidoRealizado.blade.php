@php
    $total = 0;
    $i = 0;
@endphp

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office"
    style="font-family: arial, 'helvetica neue', helvetica, sans-serif">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="telephone=no" name="format-detection" />
    <title>Pedido de El Casino</title>
    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        .my-5 {
            margin-top: 3rem !important;
            margin-bottom: 3rem !important;
        }

        .my-1 {
            margin-top: 0.25rem !important;
            margin-bottom: 0.25rem !important;
        }

        .mx-2 {
            margin-right: 0.5rem !important;
            margin-left: 0.5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .alert-warning {
            color: #664d03;
            background-color: #fff3cd;
            border-color: #ffecb5;
        }

        .alert {
            position: relative;
            padding: 1rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }

        .paddingBody {
            padding-left: 3rem;
            padding-right: 3rem;
        }

        .d-flex {
            display: flex;
        }

        .facturacion {
            padding: 20px;
            height: min-content;
        }

        .m-2 {
            margin: 0.5rem !important;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .text-center {
            text-align: center !important;
        }

        .card-title {
            margin-bottom: 0.5rem;
        }

        .w-50 {
            width: 50% !important;
        }

        .text-secondary {
            color: gray;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1rem 1rem;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .text-success {
            color: rgba(var(--bs-success-rgb), var(--bs-text-opacity)) !important;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        .px-3 {
            padding-right: 1rem !important;
            padding-left: 1rem !important;
        }

        .btn-success {
            color: #fff;
            background-color: #198754;
            border-color: #198754;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -moz-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            font-size: 1rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
                border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .precio-totalidad {
            margin-bottom: 15px;
            border-bottom: 1px solid #c4c4c4;
        }

        .subtotal-caja {
            margin-top: 10px;
            display: flex;
        }

        .subtotal {
            font-size: 15px;
            width: 50%;
        }

        .subtotal-valor {
            font-size: 15px;
            width: 50%;
            text-align: right;
            color: #06bf19;
        }

        .envio-caja {
            margin-top: 10px;
            display: flex;
            margin-bottom: 10px;
        }

        .totalidad-caja {
            display: flex;
        }

        .es-button {
            mso-style-priority: 100 !important;
            text-decoration: none !important;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .es-desk-hidden {
            display: none;
            float: left;
            overflow: hidden;
            width: 0;
            max-height: 0;
            line-height: 0;
            mso-hide: all;
        }

        [data-ogsb] .es-button {
            border-width: 0 !important;
            padding: 10px 30px 10px 30px !important;
        }

        @media only screen and (max-width: 600px) {

            p,
            ul li,
            ol li,
            a {
                line-height: 150% !important;
            }

            h1,
            h2,
            h3,
            h1 a,
            h2 a,
            h3 a {
                line-height: 120%;
            }

            h1 {
                font-size: 36px !important;
                text-align: center;
            }

            h2 {
                font-size: 26px !important;
                text-align: center;
            }

            h3 {
                font-size: 20px !important;
                text-align: center;
            }

            .es-header-body h1 a,
            .es-content-body h1 a,
            .es-footer-body h1 a {
                font-size: 36px !important;
            }

            .es-header-body h2 a,
            .es-content-body h2 a,
            .es-footer-body h2 a {
                font-size: 26px !important;
            }

            .es-header-body h3 a,
            .es-content-body h3 a,
            .es-footer-body h3 a {
                font-size: 20px !important;
            }

            .es-menu td a {
                font-size: 14px !important;
            }

            .es-header-body p,
            .es-header-body ul li,
            .es-header-body ol li,
            .es-header-body a {
                font-size: 14px !important;
            }

            .es-content-body p,
            .es-content-body ul li,
            .es-content-body ol li,
            .es-content-body a {
                font-size: 16px !important;
            }

            .es-footer-body p,
            .es-footer-body ul li,
            .es-footer-body ol li,
            .es-footer-body a {
                font-size: 14px !important;
            }

            .es-infoblock p,
            .es-infoblock ul li,
            .es-infoblock ol li,
            .es-infoblock a {
                font-size: 12px !important;
            }

            *[class="gmail-fix"] {
                display: none !important;
            }

            .es-m-txt-c,
            .es-m-txt-c h1,
            .es-m-txt-c h2,
            .es-m-txt-c h3 {
                text-align: center !important;
            }

            .es-m-txt-r,
            .es-m-txt-r h1,
            .es-m-txt-r h2,
            .es-m-txt-r h3 {
                text-align: right !important;
            }

            .es-m-txt-l,
            .es-m-txt-l h1,
            .es-m-txt-l h2,
            .es-m-txt-l h3 {
                text-align: left !important;
            }

            .es-m-txt-r img,
            .es-m-txt-c img,
            .es-m-txt-l img {
                display: inline !important;
            }

            .es-button-border {
                display: block !important;
            }

            a.es-button,
            button.es-button {
                font-size: 20px !important;
                display: block !important;
                border-left-width: 0px !important;
                border-right-width: 0px !important;
            }

            .es-adaptive table,
            .es-left,
            .es-right {
                width: 100% !important;
            }

            .es-content table,
            .es-header table,
            .es-footer table,
            .es-content,
            .es-footer,
            .es-header {
                width: 100% !important;
                max-width: 600px !important;
            }

            .es-adapt-td {
                display: block !important;
                width: 100% !important;
            }

            .adapt-img {
                width: 100% !important;
                height: auto !important;
            }

            .es-m-p0 {
                padding: 0 !important;
            }

            .es-m-p0r {
                padding-right: 0 !important;
            }

            .es-m-p0l {
                padding-left: 0 !important;
            }

            .es-m-p0t {
                padding-top: 0 !important;
            }

            .es-m-p0b {
                padding-bottom: 0 !important;
            }

            .es-m-p20b {
                padding-bottom: 20px !important;
            }

            .es-mobile-hidden,
            .es-hidden {
                display: none !important;
            }

            tr.es-desk-hidden,
            td.es-desk-hidden,
            table.es-desk-hidden {
                width: auto !important;
                overflow: visible !important;
                float: none !important;
                max-height: inherit !important;
                line-height: inherit !important;
            }

            tr.es-desk-hidden {
                display: table-row !important;
            }

            table.es-desk-hidden {
                display: table !important;
            }

            td.es-desk-menu-hidden {
                display: table-cell !important;
            }

            .es-menu td {
                width: 1% !important;
            }

            table.es-table-not-adapt,
            .esd-block-html table {
                width: auto !important;
            }

            table.es-social {
                display: inline-block !important;
            }

            table.es-social td {
                display: inline-block !important;
            }

            .es-m-p5 {
                padding: 5px !important;
            }

            .es-m-p5t {
                padding-top: 5px !important;
            }

            .es-m-p5b {
                padding-bottom: 5px !important;
            }

            .es-m-p5r {
                padding-right: 5px !important;
            }

            .es-m-p5l {
                padding-left: 5px !important;
            }

            .es-m-p10 {
                padding: 10px !important;
            }

            .es-m-p10t {
                padding-top: 10px !important;
            }

            .es-m-p10b {
                padding-bottom: 10px !important;
            }

            .es-m-p10r {
                padding-right: 10px !important;
            }

            .es-m-p10l {
                padding-left: 10px !important;
            }

            .es-m-p15 {
                padding: 15px !important;
            }

            .es-m-p15t {
                padding-top: 15px !important;
            }

            .es-m-p15b {
                padding-bottom: 15px !important;
            }

            .es-m-p15r {
                padding-right: 15px !important;
            }

            .es-m-p15l {
                padding-left: 15px !important;
            }

            .es-m-p20 {
                padding: 20px !important;
            }

            .es-m-p20t {
                padding-top: 20px !important;
            }

            .es-m-p20r {
                padding-right: 20px !important;
            }

            .es-m-p20l {
                padding-left: 20px !important;
            }

            .es-m-p25 {
                padding: 25px !important;
            }

            .es-m-p25t {
                padding-top: 25px !important;
            }

            .es-m-p25b {
                padding-bottom: 25px !important;
            }

            .es-m-p25r {
                padding-right: 25px !important;
            }

            .es-m-p25l {
                padding-left: 25px !important;
            }

            .es-m-p30 {
                padding: 30px !important;
            }

            .es-m-p30t {
                padding-top: 30px !important;
            }

            .es-m-p30b {
                padding-bottom: 30px !important;
            }

            .es-m-p30r {
                padding-right: 30px !important;
            }

            .es-m-p30l {
                padding-left: 30px !important;
            }

            .es-m-p35 {
                padding: 35px !important;
            }

            .es-m-p35t {
                padding-top: 35px !important;
            }

            .es-m-p35b {
                padding-bottom: 35px !important;
            }

            .es-m-p35r {
                padding-right: 35px !important;
            }

            .es-m-p35l {
                padding-left: 35px !important;
            }

            .es-m-p40 {
                padding: 40px !important;
            }

            .es-m-p40t {
                padding-top: 40px !important;
            }

            .es-m-p40b {
                padding-bottom: 40px !important;
            }

            .es-m-p40r {
                padding-right: 40px !important;
            }

            .es-m-p40l {
                padding-left: 40px !important;
            }
        }
    </style>
</head>

<body
    style="
      width: 100%;
      font-family: arial, 'helvetica neue', helvetica, sans-serif;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
      padding: 0;
      margin: 0;
    ">
    <div class="es-wrapper-color" style="background-color: #fafafa">
        <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"
            style="
          mso-table-lspace: 0pt;
          mso-table-rspace: 0pt;
          border-collapse: collapse;
          border-spacing: 0px;
          padding: 0;
          margin: 0;
          width: 100%;
          height: 100%;
          background-repeat: repeat;
          background-position: center top;
          background-color: #fafafa;
        ">
            <tr>
                <td valign="top" style="padding: 0; margin: 0">
                    <table cellpadding="0" cellspacing="0" class="es-content" align="center"
                        style="
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
                border-collapse: collapse;
                border-spacing: 0px;
                table-layout: fixed !important;
                width: 100%;
              ">
                        <tr>
                            <td align="center" style="padding: 0; margin: 0">
                                <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0"
                                    cellspacing="0"
                                    style="
                      mso-table-lspace: 0pt;
                      mso-table-rspace: 0pt;
                      border-collapse: collapse;
                      border-spacing: 0px;
                      background-color: #ffffff;
                      width: 600px;
                    ">
                                    <tr>
                                        <td align="left"
                                            style="
                          margin: 0;
                          padding-left: 20px;
                          padding-right: 20px;
                          padding-top: 30px;
                        ">
                                            <table cellpadding="0" cellspacing="0" width="100%"
                                                style="
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            border-collapse: collapse;
                            border-spacing: 0px;
                          ">
                                                <tr>
                                                    <td align="center" valign="top"
                                                        style="padding: 0; margin: 0; width: 560px">
                                                        <table cellpadding="0" cellspacing="0" width="100%"
                                                            role="presentation"
                                                            style="
                                  mso-table-lspace: 0pt;
                                  mso-table-rspace: 0pt;
                                  border-collapse: collapse;
                                  border-spacing: 0px;
                                ">
                                                            <tr>
                                                                <td align="center"
                                                                    style="
                                      padding: 0;
                                      margin: 0;
                                      font-size: 0px;
                                    ">
                                                                    <img class="adapt-img"
                                                                        src="https://smashurban.com/images/logo_mail.jpg"
                                                                        alt
                                                                        style="
                                        display: block;
                                        border: 0;
                                        outline: none;
                                        text-decoration: none;
                                        -ms-interpolation-mode: bicubic;
                                      "
                                                                        width="560" height="130" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center">
                                                                    <h2>Tu pedido {{ $order->order }}</h2>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        <table class="table"
                                                            style="
                                  width: 100%;
                                  max-width: 100%;
                                  border-spacing: 0;
                                  border-collapse: collapse;
                                  font-size: 12.96px;
                                ">
                                                            <thead>
                                                                <tr
                                                                    style="
                                      border-bottom: 1px solid
                                        rgb(223, 223, 223);
                                    ">
                                                                    <th
                                                                        style="
                                        padding: 8px;
                                        line-height: 1.42857143;
                                        border-top: 0;
                                        border-bottom: 0;
                                        vertical-align: bottom;
                                        text-align: left;
                                      ">
                                                                        Plato
                                                                    </th>
                                                                    <th align="center" class="table_center">
                                                                        Cantidad
                                                                    </th>
                                                                    <th align="center" class="table_center">
                                                                        Precio
                                                                    </th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($cesta as $k => $elemento)
                                                                    <tr
                                                                        style="
                                      border-bottom: 1px solid
                                        rgb(223, 223, 223);
                                      padding: 10px 0 10px 0;
                                    ">
                                                                        <td style="word-break: break-all"
                                                                            id="pro_name_img">
                                                                            <table>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div id="pro_img"
                                                                                            style="
                                                width: 40px;
                                                display: block;
                                              ">
                                                                                            <img style="
                                                  height: 40px;
                                                  width: 100%;
                                                  object-fit: cover;
                                                  max-width: 100%;
                                                  vertical-align: middle;
                                                "
                                                                                                src="{{ asset('images/' . $elemento['img1']) }}"
                                                                                                alt="pro_img" />
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            style="
                                                display: block;
                                                padding-left: 5px;
                                                flex: 0 1 80%;
                                                box-sizing: border-box;
                                              ">
                                                                                            {{ $elemento['plato'] }}
                                                                                            <table>
                                                                                                @foreach ($elemento['elementos'] as $ele)
                                                                                                    <tr>
                                                                                                        <td><small>{{ $ele }}</small>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                @endforeach

                                                                                            </table>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>

                                                                        <td align="center" width="20%"
                                                                            class="table_center"
                                                                            style="vertical-align: middle">
                                                                            <a href="#">
                                                                                <i class="fa fa-minus menos2"
                                                                                    data-plato-id="64429ba1772f0"></i>
                                                                            </a>
                                                                            <b
                                                                                style="
                                          padding-left: 3px;
                                          padding-right: 3px;
                                        ">{{ $elemento['unidades'] }}</b>
                                                                            <a href="#">
                                                                                <i class="fa fa-plus mas2"
                                                                                    data-plato-id="64429ba1772f0"></i>
                                                                            </a>
                                                                        </td>

                                                                        <td align="center" width="20%"
                                                                            class="table_center"
                                                                            style="vertical-align: middle">
                                                                            {{ $elemento['precio'] }} &euro;
                                                                        </td>
                                                                        <td width="5%" class="cart_remove"
                                                                            style="vertical-align: middle">
                                                                            <a href="#">
                                                                                <i class="fa fa-times fa-lg borrar"
                                                                                    data-plato-id="64429ba1772f0"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    @php
                                                                        $total += $elemento['precio'];
                                                                        $i += $elemento['unidades'];
                                                                    @endphp
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr style="height: 30px">
                                                                    <th style="
                                        padding: 8px;
                                        line-height: 1.42857143;
                                        border-top: 0;
                                        border-bottom: 0;
                                        vertical-align: bottom;
                                        text-align: left;
                                      "
                                                                        align="left" colspan="2">
                                                                        Total
                                                                    </th>
                                                                    <th colspan="2" style="text-align: right">
                                                                        {{ $total }} &euro;
                                                                    </th>
                                                                </tr>
                                                            </tfoot>
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

                    <table cellpadding="0" cellspacing="0" class="es-content" align="center"
                        style="
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
                border-collapse: collapse;
                border-spacing: 0px;
                table-layout: fixed !important;
                width: 100%;
              ">
                        <tr>
                            <td align="center" style="padding: 0; margin: 0">
                                <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0"
                                    cellspacing="0"
                                    style="
                      mso-table-lspace: 0pt;
                      mso-table-rspace: 0pt;
                      border-collapse: collapse;
                      border-spacing: 0px;
                      background-color: #ffffff;
                      width: 600px;
                    ">
                                    <tr>
                                        <td align="left"
                                            style="
                          margin: 0;
                          padding-left: 40px;
                          padding-right: 40px;
                          padding-bottom: 10px;
                        ">
                                            <table cellpadding="0" cellspacing="0" width="100%"
                                                style="
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            border-collapse: collapse;
                            border-spacing: 0px;
                          ">
                                                <tr>
                                                    <td align="center" valign="top"
                                                        style="padding: 0; margin: 0; width: 520px">
                                                        <table cellpadding="0" cellspacing="0" width="100%"
                                                            role="presentation"
                                                            style="
                                  mso-table-lspace: 0pt;
                                  mso-table-rspace: 0pt;
                                  border-collapse: collapse;
                                  border-spacing: 0px;
                                ">
                                                            <tr>
                                                                <td align="left" style="padding: 5px; margin: 0">
                                                                    <div
                                                                        style="
                                        margin-top: 0;
                                        margin: 0;
                                        -webkit-text-size-adjust: none;
                                        -ms-text-size-adjust: none;
                                        mso-line-height-rule: exactly;
                                        font-family: arial, 'helvetica neue',
                                          helvetica, sans-serif;

                                        color: #161514;
                                        font-size: 13px;
                                      ">
                                                                        <strong>
                                                                            <h3
                                                                                style="
                                            font-size: 1.275rem;
                                            font-family: 'Quicksand', sans-serif;
                                            font-weight: 700;
                                          ">
                                                                                Información para tu recogida
                                                                            </h3>
                                                                        </strong>
                                                                        <!--<p style="font-size: 16px">
                                                                            Hola, {{ $customer->name }}
                                                                        </p>-->
                                                                        <div class="col-md-12 res"
                                                                            style="
                                          font-weight: bolder;
                                          margin-bottom: 15px;
                                        ">
                                                                            <p style="font-size: 16px">
                                                                                @if ($order->time_ready)
                                                                                    Recoge tu pedido en Calle Vidal
                                                                                    Abarca, 3 bajo,
                                                                                    sobre las {{ $order->time_ready }}
                                                                                @else
                                                                                    Recoge tu pedido en Calle Vidal
                                                                                    Abarca, 3 bajo
                                                                                @endif
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-sm-6 form-group">
                                                                            <table>
                                                                                <tr>
                                                                                    <td>
                                                                                        <label for="tijd"
                                                                                            class="control-label"
                                                                                            style="margin-top: 8px; margin-bottom: 8px; font-weight: bolder">Número
                                                                                            de pedido:
                                                                                        </label>
                                                                                    </td>
                                                                                    <td>{{ $order->id }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <label for="tijd"
                                                                                            class="control-label"
                                                                                            style="margin-top: 8px; margin-bottom: 8px; font-weight: bolder">Nombre
                                                                                            completo:
                                                                                        </label>
                                                                                    </td>
                                                                                    <td>{{ $customer->name }}
                                                                                        {{ $customer->lastname }}</td>
                                                                                </tr>

                                                                                @if ($order->time_ready)
                                                                                    <tr>
                                                                                        <td>
                                                                                            <label for="tijd"
                                                                                                class="control-label"
                                                                                                style="margin-top: 8px; margin-bottom: 8px; font-weight: bolder">Hora
                                                                                                de recogida:
                                                                                            </label>
                                                                                        </td>
                                                                                        <td>{{ date('d-m-Y') }}
                                                                                            {{ $order->time_ready }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @else
                                                                                    <tr>
                                                                                        <td>
                                                                                            <label for="tijd"
                                                                                                class="control-label"
                                                                                                style="margin-top: 8px; margin-bottom: 8px; font-weight: bolder">Hora
                                                                                                de recogida:
                                                                                            </label>
                                                                                        </td>
                                                                                        <td>{{ $hora_recogida }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif


                                                                                <tr>
                                                                                    <td>
                                                                                        <label for="tijd"
                                                                                            class="control-label"
                                                                                            style="margin-top: 8px; margin-bottom: 8px; font-weight: bolder">Teléfono:
                                                                                        </label>
                                                                                    </td>
                                                                                    <td>{{ $customer->phone }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <label for="tijd"
                                                                                            class="control-label"
                                                                                            style="margin-top: 8px; margin-bottom: 8px; font-weight: bolder">Forma
                                                                                            de pago:
                                                                                        </label>
                                                                                    </td>
                                                                                    <td>Tarjeta</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <label for="tijd"
                                                                                            class="control-label"
                                                                                            style="margin-top: 8px; margin-bottom: 8px; font-weight: bolder">Correo
                                                                                            electrónico:
                                                                                        </label>
                                                                                    </td>
                                                                                    <td>{{ $customer->email }}</td>
                                                                                </tr>
                                                                            </table>

                                                                            <br /><br /><br />
                                                                            <table
                                                                                style="width: 100%; text-align: right">
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Equipo The Urban
                                                                                                Burgers
                                                                                                🍔👨🏻‍🍳</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>

                                                                            <!--  <div class="sel sel-black-panther">    -->
                                                                        </div>
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

                    <table cellpadding="0" cellspacing="0" class="es-footer" align="center"
                        style="
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
                border-collapse: collapse;
                border-spacing: 0px;
                table-layout: fixed !important;
                width: 100%;
                background-color: transparent;
                background-repeat: repeat;
                background-position: center top;
              ">
                        <tr>
                            <td align="center" style="padding: 0; margin: 0">
                                <table class="es-footer-body" align="center" cellpadding="0" cellspacing="0"
                                    style="
                      mso-table-lspace: 0pt;
                      mso-table-rspace: 0pt;
                      border-collapse: collapse;
                      border-spacing: 0px;
                      background-color: transparent;
                      width: 640px;
                    ">
                                    <tr>
                                        <td align="left"
                                            style="
                          margin: 0;
                          padding-top: 20px;
                          padding-bottom: 20px;
                          padding-left: 20px;
                          padding-right: 20px;
                        ">
                                            <table cellpadding="0" cellspacing="0" width="100%"
                                                style="
                            mso-table-lspace: 0pt;
                            mso-table-rspace: 0pt;
                            border-collapse: collapse;
                            border-spacing: 0px;
                          ">
                                                <tr>
                                                    <td align="left" style="padding: 0; margin: 0; width: 560px">
                                                        <table cellpadding="0" cellspacing="0" width="100%"
                                                            role="presentation"
                                                            style="
                                  mso-table-lspace: 0pt;
                                  mso-table-rspace: 0pt;
                                  border-collapse: collapse;
                                  border-spacing: 0px;
                                ">
                                                            <tr>
                                                                <td align="center"
                                                                    style="
                                      padding: 0;
                                      margin: 0;
                                      padding-top: 15px;
                                      padding-bottom: 15px;
                                      font-size: 0;
                                    ">
                                                                    <table cellpadding="0" cellspacing="0"
                                                                        class="es-table-not-adapt es-social"
                                                                        role="presentation"
                                                                        style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        border-collapse: collapse;
                                        border-spacing: 0px;
                                      ">
                                                                        <tr>
                                                                            <td align="center" valign="top"
                                                                                style="
                                            padding: 0;
                                            margin: 0;
                                            padding-right: 40px;
                                          ">
                                                                            </td>
                                                                            <td align="center" valign="top"
                                                                                style="
                                            padding: 0;
                                            margin: 0;
                                            padding-right: 40px;
                                          ">
                                                                                <a target="_blank"
                                                                                    href="https://www.instagram.com/theurbanburgers/?hl=es"
                                                                                    style="
                                              -webkit-text-size-adjust: none;
                                              -ms-text-size-adjust: none;
                                              mso-line-height-rule: exactly;
                                              text-decoration: underline;
                                              color: #333333;
                                              font-size: 12px;
                                            "><img
                                                                                        title="Instagram"
                                                                                        src="https://pyognt.stripocdn.email/content/assets/img/social-icons/logo-black/instagram-logo-black.png"
                                                                                        alt="Inst" width="32"
                                                                                        height="32"
                                                                                        style="
                                                display: block;
                                                border: 0;
                                                outline: none;
                                                text-decoration: none;
                                                -ms-interpolation-mode: bicubic;
                                              " /></a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center"
                                                                    style="
                                      padding: 0;
                                      margin: 0;
                                      padding-bottom: 35px;
                                    ">
                                                                    <p
                                                                        style="
                                        margin-top: 0;
                                        margin-bottom: 1rem;
                                        margin: 0;
                                        -webkit-text-size-adjust: none;
                                        -ms-text-size-adjust: none;
                                        mso-line-height-rule: exactly;
                                        font-family: arial, 'helvetica neue',
                                          helvetica, sans-serif;
                                        line-height: 18px;
                                        color: #333333;
                                        font-size: 12px;
                                      ">
                                                                        <strong>Datos de contacto para ejercer sus
                                                                            derechos:</strong><br />The Urban Burger
                                                                        C/ Vidal Abarca, 3 bajo
                                                                        <br />30840 Alhama de Murcia<br />Murcia
                                                                        | España. E-mail:
                                                                        info@smashurban.com&nbsp;
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 0; margin: 0">
                                                                    <table cellpadding="0" cellspacing="0"
                                                                        width="100%" class="es-menu"
                                                                        role="presentation"
                                                                        style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        border-collapse: collapse;
                                        border-spacing: 0px;
                                      ">
                                                                        <tr class="links">
                                                                            <td align="center" valign="top"
                                                                                width="33.33%"
                                                                                style="
                                            margin: 0;
                                            padding-left: 5px;
                                            padding-right: 5px;
                                            padding-top: 5px;
                                            padding-bottom: 5px;
                                            border: 0;
                                          ">
                                                                                <a target="_blank" href=""
                                                                                    style="
                                              -webkit-text-size-adjust: none;
                                              -ms-text-size-adjust: none;
                                              mso-line-height-rule: exactly;
                                              text-decoration: none;
                                              display: block;
                                              font-family: arial,
                                                'helvetica neue', helvetica,
                                                sans-serif;
                                              color: #999999;
                                              font-size: 12px;
                                            ">Visitanos</a>
                                                                            </td>
                                                                            <td align="center" valign="top"
                                                                                width="33.33%"
                                                                                style="
                                            margin: 0;
                                            padding-left: 5px;
                                            padding-right: 5px;
                                            padding-top: 5px;
                                            padding-bottom: 5px;
                                            border: 0;
                                            border-left: 1px solid #cccccc;
                                          ">
                                                                                <a target="_blank" href=""
                                                                                    style="
                                              -webkit-text-size-adjust: none;
                                              -ms-text-size-adjust: none;
                                              mso-line-height-rule: exactly;
                                              text-decoration: none;
                                              display: block;
                                              font-family: arial,
                                                'helvetica neue', helvetica,
                                                sans-serif;
                                              color: #999999;
                                              font-size: 12px;
                                            ">Politicas
                                                                                    de privacidad</a>
                                                                            </td>
                                                                            <td align="center" valign="top"
                                                                                width="33.33%"
                                                                                style="
                                            margin: 0;
                                            padding-left: 5px;
                                            padding-right: 5px;
                                            padding-top: 5px;
                                            padding-bottom: 5px;
                                            border: 0;
                                            border-left: 1px solid #cccccc;
                                          ">
                                                                                <a target="_blank" href=""
                                                                                    style="
                                              -webkit-text-size-adjust: none;
                                              -ms-text-size-adjust: none;
                                              mso-line-height-rule: exactly;
                                              text-decoration: none;
                                              display: block;
                                              font-family: arial,
                                                'helvetica neue', helvetica,
                                                sans-serif;
                                              color: #999999;
                                              font-size: 12px;
                                            ">Condiciones
                                                                                    de uso</a>
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
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
