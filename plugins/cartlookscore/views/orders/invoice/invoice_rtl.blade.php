<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ======= MAIN STYLES ======= -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/web-assets/backend/fonts/roboto/roboto.css') }}">
    <!-- ======= END MAIN STYLES ======= -->
    <style>
        html {
            margin: 0px;
            background: white;
        }

        @font-face {
            font-family: "Arabic";
            src: url("https://tlcommerce.themelooks.us/public/cdn/font/arabic.ttf") format('truetype');
        }

        @font-face {
            font-family: "Bangla";
            src: url("https://tlcommerce.themelooks.us/public/cdn/font/Nikosh.ttf") format('truetype');
        }

        @font-face {
            font-family: "Hibrew";
            src: url("https://tlcommerce.themelooks.us/public/cdn/font/Hebrew.ttf") format('truetype');
        }

        @font-face {
            font-family: "Arial Unicode MS";
            src: url("https://tlcommerce.themelooks.us/public/cdn/font/arial-unicode-ms.ttf") format('truetype');
        }

        body {
            font-family: '{{ $font_family }}', sans-serif;
        }

        .qr-code {
            max-height: 120px;
        }

        .invoice-top {
            background: #EBEBEB;
        }

        .invoice-p {
            margin-bottom: 0px;
            font-size: 12px;
            color: black;
            padding-block: 5px !important;
        }

        .currency {
            font-family: '{{ $currency_font }}', sans-serif;
        }

        .payment-image {
            max-height: 150px;
        }

        .invoice-product-table {
            width: calc(100% - 40px);
            margin-inline: 20px;
        }

        .p5 {
            padding: 5px;
        }

        .invoice-product-table .thead-light th {
            color: black;
        }

        .invoice-title {
            font-size: 32px
        }

        tr {
            text-align: right !important
        }
    </style>
</head>

<body>
    <table class="table table-borderless invoice-top">
        <tbody>
            <tr class="">
                <td class="text-right">
                    <div class="row">
                        <div class="col-6">
                            <p class="invoice-title">{{ translate('INVOICE', getLocale()) }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    @if ($order_info['system_properties']['logo'] != null)
                        <img src="{{ asset('/') }}{{ $order_info['system_properties']['logo'] }}"
                            alt={{ $order_info['system_properties']['title'] }}>
                    @else
                        <h2>{{ $order_info['system_properties']['title'] }}</h2>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-right">
                    <div class="row">
                        <div class="col-6">
                            <p class="invoice-p">
                                {{ $order_info['order_code'] }}:{{ translate('Order ID', getLocale()) }}</p>
                            <p class="invoice-p">{{ $order_info['date'] }}:{{ translate('Order date', getLocale()) }}
                            </p>
                            <p class="invoice-p">
                                {{ $order_info['payment_method'] }}:{{ translate('Payment method', getLocale()) }}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="invoice-p">{{ $order_info['system_properties']['title'] }}</p>
                    @if ($order_info['system_properties']['address'] != null)
                        <p class="invoice-p">{{ $order_info['system_properties']['address'] }}</p>
                    @endif
                    @if ($order_info['system_properties']['email'] != null)
                        <p class="invoice-p">
                            {{ $order_info['system_properties']['email'] }}:{{ translate('Email', getLocale()) }}</p>
                    @endif
                    @if ($order_info['system_properties']['phone'] != null)
                        <p class="invoice-p">
                            {{ $order_info['system_properties']['phone'] }}:{{ translate('Phone', getLocale()) }}</p>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-borderless">
        <tbody>
            <tr>
                <td class="text-right ">
                    <div class="row">
                        <div class="col-6 offset-4">
                            <img src="data:image/png;base64, {!! $qr_code !!}" class="qr-code">
                        </div>
                    </div>
                </td>
                <td>
                    <p class="invoice-p">:{{ translate('Bill to', getLocale()) }}</p>
                    <p class="invoice-p">{{ $order_info['billing_info']['name'] }}</p>
                    <p class="invoice-p">
                        @if ($order_info['billing_info']['address'] != null)
                            <span>
                                {{ $order_info['billing_info']['address'] }},
                            </span>
                        @endif
                        @if ($order_info['billing_info']['city'] != null)
                            <span>
                                {{ $order_info['billing_info']['city'] }},
                            </span>
                        @endif
                        @if ($order_info['billing_info']['state'] != null)
                            <span>
                                {{ $order_info['billing_info']['state'] }},
                            </span>
                        @endif
                        @if ($order_info['billing_info']['country'] != null)
                            <span>
                                {{ $order_info['billing_info']['country'] }}.
                            </span>
                        @endif
                    </p>
                    @if ($order_info['billing_info']['postal_code'] != null)
                        <p class="invoice-p">
                            {{ $order_info['billing_info']['postal_code'] }}:{{ translate('Postal Code', getLocale()) }}
                        </p>
                    @endif
                    <p class="invoice-p">
                        {{ $order_info['billing_info']['email'] }}:{{ translate('Email', getLocale()) }}</p>
                    @if ($order_info['billing_info']['phone'] != null)
                        <p class="invoice-p">
                            {{ $order_info['billing_info']['phone'] }}:{{ translate('Phone', getLocale()) }}</p>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @php
        $total_amount = 0;
        $sub_total = 0;
        $total_tax = 0;
        $total_discount = 0;
        $total_shipping_cost = 0;
        $total_paid = 0;
    @endphp
    <table class="table invoice-product-table p5">
        <thead class="thead-light">
            <tr>
                <td scope="col" class="text-right invoice-p">{{ translate('Total', getLocale()) }}</td>
                <td scope="col" class="invoice-p">{{ translate('Tax', getLocale()) }}</td>
                <td scope="col" class="invoice-p">{{ translate('Unit Price', getLocale()) }}</td>
                <td scope="col" class="invoice-p">{{ translate('Quantity', getLocale()) }}</td>
                <td scope="col" class="invoice-p">{{ translate('Name', getLocale()) }}</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($order_info['products'] as $item)
                @php
                    $sub_total += $item->unit_price * $item->quantity;
                    $total_tax += $item->tax;
                    $total_shipping_cost += $item->delivery_cost;
                    $total_discount += $item->couponDiscountedAmount();
                    $total_amount += $item->unit_price * $item->quantity + $item->tax + $item->delivery_cost;
                    $total_paid += $item->total_paid;
                    
                @endphp
                <tr>
                    <td class="text-right invoice-p currency">
                        {{ currencyExchange($item->unit_price * $item->quantity, true, null, false) }}
                    </td>
                    <td class="invoice-p currency">
                        {{ currencyExchange($item->tax, true, null, false) }}
                    </td>
                    <td class="invoice-p currency">{{ currencyExchange($item->unit_price, true, null, false) }}</td>
                    <td class="invoice-p">{{ $item->quantity }}</td>
                    <td class="invoice-p">
                        <p class="invoice-p">{{ $item->product_details->name }}</p>
                        @if ($item->variant != null)
                            <p class="invoice-p">{{ $item->variant }}</p>
                        @endif
                    </td>
                </tr>
            @endforeach


            <tr>
                <td colspan="2" class="pr-0">
                    <table class="table table-borderless w-100 invoice-summary-table">
                        <tr>
                            <td class="border-top-0 text-right invoice-p p-0 col-6 currency">
                                {{ currencyExchange($sub_total, true, null, false) }}
                            </td>
                            <td class="border-top-0 invoice-p p-0 col-6 col-6">{{ translate('Subtotal', getLocale()) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-top-0 text-right invoice-p p-0 col-6 currency">
                                {{ currencyExchange($total_tax, true, null, false) }}
                            </td>
                            <td class="border-top-0 invoice-p p-0 col-6">{{ translate('Tax', getLocale()) }}</td>
                        </tr>
                        <tr>
                            <td class="border-top-0 text-right invoice-p p-0 col-6 currency">
                                {{ currencyExchange($total_shipping_cost, true, null, false) }}
                            </td>
                            <td class="border-top-0 invoice-p p-0 col-6">{{ translate('Shipping', getLocale()) }}</td>
                        </tr>
                        <tr>
                            <td class="border-top-0 invoice-p text-right p-0 col-6 currency">
                                {{ currencyExchange($total_discount, true, null, false) }}
                            </td>
                            <td class="border-top-0 invoice-p p-0 col-6">{{ translate('Discount', getLocale()) }}</td>
                        </tr>
                        <tr>
                            <td class="border-top-0 invoice-p text-right p-0 col-6 currency">
                                {{ currencyExchange($total_amount - $total_discount, true, null, false) }}
                            </td>
                            <td class="border-top-0 invoice-p p-0 col-6">{{ translate('Grand Total', getLocale()) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-top-0 invoice-p text-right p-0 col-6 currency">
                                {{ currencyExchange($total_paid, true, null, false) }}
                            </td>
                            <td class="border-top-0 invoice-p p-0 col-6">{{ translate('Paid', getLocale()) }}</td>
                        </tr>
                        <tr>
                            <td class="border-top-0 invoice-p text-right p-0 col-6 currency">
                                {{ currencyExchange($total_amount - $total_discount - $total_paid, true, null, false) }}
                            </td>
                            <td class="border-top-0 invoice-p p-0 col-6">{{ translate('Total Due', getLocale()) }}</td>
                        </tr>
                    </table>
                </td>
                <td colspan="3">
                    <div class="payment-image-container mt-4">
                        @php
                            $total_payable = $total_amount - $total_discount;
                        @endphp
                        @if ($total_payable == $total_paid)
                            @if ($order_info['system_properties']['paid_image'] != null)
                                <img src="{{ asset('/') }}{{ $order_info['system_properties']['paid_image'] }}"
                                    alt="Paid">
                            @endif
                        @else
                            @if ($order_info['system_properties']['unpaid_image'] != null)
                                <img src="{{ asset('/') }}{{ $order_info['system_properties']['unpaid_image'] }}"
                                    alt="Unpaid">
                            @endif
                        @endif
                    </div>
                </td>
            <tr>
        </tbody>
    </table>
</body>

</html>
