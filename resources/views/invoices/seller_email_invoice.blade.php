<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <meta http-equiv="Content-Type" content="text/html;" />
    <meta charset="UTF-8">
    <style media="all">
        @font-face {
            font-family: 'Roboto';
            src: url("{{ asset('fonts/Roboto-Regular.ttf') }}") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: 'Roboto';
            color: #333542;
        }

        body {
            font-size: .875rem;
        }

        .gry-color *,
        .gry-color {
            color: #878f9c;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: .5rem .7rem;
        }

        table.padding td {
            padding: .7rem;
        }

        table.sm-padding td {
            padding: .2rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .small {
            font-size: .85rem;
        }

        .currency {}
    </style>
</head>

<body>
    <div style="margin-left:auto;margin-right:auto;">

        @php
            $generalsetting = \App\GeneralSetting::first();

        @endphp
        <?php

        if ($sellerdetail != null && !empty($sellerdetail)) {
            $id = $sellerdetail['id'];
            $shop_name = $sellerdetail['shop_name'];
            $phone = $sellerdetail['phone'];
            $address = $sellerdetail['address'];
            $email = $sellerdetail['email'];
            $logo = $sellerdetail['logo'];
        } else {
            $id = '';
            $shop_name = '';
            $phone = '';
            $address = '';
            $email = '';
            $logo = '';
        }

        ?>
        <div style="background: #eceff4;padding: 1.5rem;">
            <table>
                <tr>
                    <td>
                        @if (Auth::user()->user_type == 'seller')
                            @if (Auth::user()->shop->logo != null)
                                <img loading="lazy" src="{{ asset(Auth::user()->shop->logo) }}" height="40"
                                    style="display:inline-block;">
                            @else
                                <img loading="lazy" src="{{ asset('frontend/images/logo/logo.png') }}" height="40"
                                    style="display:inline-block;">
                            @endif
                        @endif
                        @if ($logo != null && $sellerdetail != null)
                            <img loading="lazy" src="{{ asset($logo) }}" height="40" style="display:inline-block;">
                        @else
                            @if ($generalsetting->logo != null)
                                <img loading="lazy" src="{{ asset($generalsetting->logo) }}" height="40"
                                    style="display:inline-block;">
                            @else
                                <img loading="lazy" src="{{ asset('frontend/images/logo/logo.png') }}" height="40"
                                    style="display:inline-block;">
                            @endif
                        @endif
                    </td>
                    <td style="font-size: 2.5rem;" class="text-right strong">INVOICE</td>
                </tr>
            </table>
            <table>
                @if (Auth::user()->user_type == 'seller')
                    <tr>
                        <td style="font-size: 1.2rem;" class="strong">{{ Auth::user()->shop->name }}</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">{{ Auth::user()->shop->address }}</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">Email: {{ Auth::user()->email }}</td>
                        <td class="text-right small"><span class="gry-color small">Order ID:</span> <span
                                class="strong">{{ $order->code }}</span></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">Phone: {{ Auth::user()->phone }}</td>
                        <td class="text-right small"><span class="gry-color small">Order Date:</span> <span
                                class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
                    </tr>
                @endif
                @if ($sellerdetail != null)
                    <tr>
                        <td style="font-size: 1.2rem;" class="strong">
                            @if ($shop_name != null)
                                {{ $shop_name }}
                            @endif
                        </td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">
                            @if ($address != null)
                                {{ $address }}
                            @endif
                        </td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">Email: @if ($email != null)
                                {{ $email }}
                            @endif
                        </td>
                        <td class="text-right small"><span class="gry-color small">Order ID:</span> <span
                                class="strong">{{ $order->code }}</span></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">Phone: @if ($phone != null)
                                {{ $phone }}
                            @endif
                        </td>
                        <td class="text-right small"><span class="gry-color small">Order Date:</span> <span
                                class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
                    </tr>
                @else
                    <tr>
                        <td style="font-size: 1.2rem;" class="strong">gfd {{ $generalsetting->site_name }}</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">{{ $generalsetting->address }}</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">Email: {{ $generalsetting->email }}</td>
                        <td class="text-right small"><span class="gry-color small">Order ID:</span> <span
                                class="strong">{{ $order->code }}</span></td>
                    </tr>
                    <tr>
                        <td class="gry-color small">Phone: {{ $generalsetting->phone }}</td>
                        <td class="text-right small"><span class="gry-color small">Order Date:</span> <span
                                class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
                    </tr>
                @endif
            </table>

        </div>

        <div style="padding: 1.5rem;padding-bottom: 0">
            <table>
                @php
                    $shipping_address = json_decode($order->shipping_address);
                @endphp
                <tr>
                    <td class="strong small gry-color">Bill to:</td>
                </tr>
                <tr>
                    <td class="strong">{{ $shipping_address->name }}</td>
                </tr>
                <tr>
                    <td class="gry-color small">
                        {{ $shipping_address->address }},
                        {{ $shipping_address->postal_code }},
                        {{ $shipping_address->city }},
                        {{ $shipping_address->district }},
                        {{ $shipping_address->division }},
                        {{ $shipping_address->country }}
                    </td>
                </tr>
                <tr>
                    <td class="gry-color small">Email: {{ @$shipping_address->email }}</td>
                </tr>
                <tr>
                    <td class="gry-color small">Phone: {{ $shipping_address->phone }}</td>
                </tr>
            </table>
        </div>

        <div style="padding: 1.5rem;">
            <table class="padding text-left small border-bottom">
                <thead>
                    <tr class="gry-color" style="background: #eceff4;">
                        <th width="35%">Product Name</th>
                        <th width="15%">Delivery Type</th>
                        <th width="10%">Qty</th>
                        <th width="15%">Unit Price</th>
                        <th width="10%">Tax</th>
                        <th width="15%" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="strong">
                    @php
                        if (Auth::user()->user_type == 'seller') {
                            $user_id = Auth::user()->id;
                        }
                        if ($id != null && $sellerdetail != null) {
                            $user_id = $id;
                        } else {
                            $user_id = \App\User::where('user_type', 'admin')->first()->id;
                        }
                    @endphp
                    @foreach ($order->orderDetails->where('seller_id', $user_id) as $key => $orderDetail)
                        @if ($orderDetail->product)
                            <tr class="">
                                <td>{{ $orderDetail->product->name }} ({{ $orderDetail->variation }})</td>
                                <td>
                                    @if ($orderDetail->shipping_type != null && $orderDetail->shipping_type == 'home_delivery')
                                        {{ __('Home Delivery') }}
                                    @elseif ($orderDetail->shipping_type == 'pickup_point')
                                        @if ($orderDetail->pickup_point != null)
                                            {{ $orderDetail->pickup_point->name }} ({{ __('Pickip Point') }})
                                        @endif
                                    @endif
                                </td>
                                <td class="gry-color">{{ $orderDetail->quantity }}</td>
                                <td class="gry-color currency">
                                    {{ single_price($orderDetail->price / $orderDetail->quantity) }}</td>
                                <td class="gry-color currency">
                                    {{ single_price($orderDetail->tax / $orderDetail->quantity) }}</td>
                                <td class="text-right currency">
                                    {{ single_price($orderDetail->price + $orderDetail->tax) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="padding:0 1.5rem;">
            <table style="width: 40%;margin-left:auto;" class="text-right sm-padding small strong">
                <tbody>
                    <tr>
                        <th class="gry-color text-left">Sub Total</th>
                        <td class="currency">
                            {{ single_price($order->orderDetails->where('seller_id', $user_id)->sum('price')) }}</td>
                    </tr>
                    <tr>
                        <th class="gry-color text-left">Shipping Cost</th>
                        <td class="currency">
                            {{ single_price($order->orderDetails->where('seller_id', $user_id)->sum('shipping_cost')) }}
                        </td>
                    </tr>
                    <tr class="border-bottom">
                        <th class="gry-color text-left">Total Tax</th>
                        <td class="currency">
                            {{ single_price($order->orderDetails->where('seller_id', $user_id)->sum('tax')) }}</td>
                    </tr>
                    <tr>
                        <th class="text-left strong">Grand Total</th>
                        <td class="currency">
                            {{ single_price($order->orderDetails->where('seller_id', $user_id)->sum('price') + $order->orderDetails->where('seller_id', $user_id)->sum('shipping_cost') + $order->orderDetails->where('seller_id', $user_id)->sum('tax')) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>
