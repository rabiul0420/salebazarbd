<div class="card sticky-top">
    <div class="card-title py-3">
        <div class="row align-items-center">
            <div class="col-6">
                <h3 class="heading heading-3 strong-400 mb-0">
                    <span>{{ __('Summary') }}</span>
                </h3>
            </div>

            <div class="col-6 text-right">
                <span class="badge badge-md badge-success">{{ count(Session::get('cart')) }} {{ __('Items') }}</span>
            </div>
        </div>
    </div>

    <div class="card-body">
        @if (
            \App\Addon::where('unique_identifier', 'club_point')->first() != null &&
                \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
            @php
                $total_point = 0;
            @endphp
            @foreach (Session::get('cart') as $key => $cartItem)
                @php
                    $product = \App\Product::find($cartItem['id']);
                    $total_point += $product->earn_point * $cartItem['quantity'];

                @endphp
            @endforeach
            <div class="club-point mb-3 bg-soft-base-1 border-light-base-1 border">
                {{ __('Total Club point') }}:
                <span class="strong-700 float-right">{{ $total_point }}</span>
            </div>
        @endif
        <table class="table-cart table-cart-review">
            <thead>
                <tr>
                    <th class="product-name">{{ __('Product') }}</th>
                    <th class="product-total text-right">{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    if (!Auth::check()) {
                        $user_address = [];
                    } else {

                        $user_address =
                        Auth::user()
                        ->addresses->where('set_default', 1)
                        ->first() ??
                        (Auth::user()->addresses->first() ?? []);
                    }
                    // dd($user_address);
                    $unique_shop = [];
                    $subtotal = 0;
                    $tax = 0;
                    $shipping = 0;
                    // if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'flat_rate') {
                    //     $shipping = \App\BusinessSetting::where('type', 'flat_rate_shipping_cost')->first()->value;
                    // }
                    $admin_products = [];
                    $seller_products = [];

                    // dd(Auth::user()->addresses);
                    function lowerCompare($str1 = '', $str2 = '')
                    {
                        if (strtolower($str1) == strtolower($str2)) {
                            return true;
                        }
                        return false;
                    }

                @endphp
                @foreach (Session::get('cart') as $key => $cartItem)
                    @php
                        $product = \App\Product::find($cartItem['id']);
                        if ($product->added_by == 'admin') {
                            array_push($admin_products, $cartItem['id']);
                        } else {
                            $product_ids = [];
                            if (array_key_exists($product->user_id, $seller_products)) {
                                $product_ids = $seller_products[$product->user_id];
                            }
                            array_push($product_ids, $cartItem['id']);
                            $seller_products[$product->user_id] = $product_ids;
                        }
                        $subtotal += $cartItem['price'] * $cartItem['quantity'];
                        $tax += $cartItem['tax'] * $cartItem['quantity'];
                        // if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'product_wise_shipping') {
                        //     $shipping += $cartItem['shipping'];
                        // }
                        // calculating shipping ** I know... **

                        //  dd(lowerCompare('hi','Hi'));
                        if ($product->shipping_type == 'dynamic') {
                            $shipping_charges = json_decode($product->shipping_charges);
                            $shop_address = $cartItem['address'];
                            $tmpShip = 0;
                            if (!array_key_exists($product->user_id, $unique_shop)) {
                                $matchpoint = [];
                                // array_push($unique_shop, $product->user_id);
                                // dd($shipping_charges, $shop_address, $user_address);
                                // dd($shop_address->postal_code, $user_address->postal_code);

                                // dd($shop_address->postal_code, $user_address->postal_code);
                                if (lowerCompare($shop_address->postal_code ?? '', $user_address->postal_code ?? '')) {
                                    // Upazilla /Thana /PS
                                    $tmpShip += $shipping_charges->sutp;
                                    $matchpoint = ['sutp', $tmpShip];
                                } elseif (lowerCompare($shop_address->city ?? '', $user_address->city ?? '')) {
                                    // City
                                    // dd($shop_address->city, $user_address->city);
                                    $tmpShip += $shipping_charges->scity;
                                    $matchpoint = ['scity', $tmpShip];
                                    // $matchpoint = 'scity';
                                } elseif (lowerCompare($shop_address->district ?? '', $user_address->district ?? '')) {
                                    // District
                                    $tmpShip += $shipping_charges->sdistrict;
                                    $matchpoint = ['sdistrict', $tmpShip];
                                    // $matchpoint = 'sdistrict';
                                } elseif (lowerCompare($shop_address->division ?? '', $user_address->division ?? '')) {
                                    // Division
                                    $tmpShip += $shipping_charges->sdivision;
                                    $matchpoint = ['sdivision', $tmpShip];
                                    // $matchpoint = 'sdivision';
                                    // } elseif (lowerCompare($shop_address->country ?? '', $user_address->country ?? '')) {
                                    //     // Country
                                    //     $tmpShip += $shipping_charges->scountry;
                                    //     $matchpoint = ['scountry', $tmpShip];
                                    //     // $matchpoint = 'scountry';
                                } else {
                                    # code...
                                    $tmpShip += $shipping_charges->scountry;
                                    $matchpoint = ['scountry', $tmpShip];
                                    // $matchpoint = 'none';
                                }

                                $unique_shop[$product->user_id] = $matchpoint;
                            } else {
                                $match = $unique_shop[$product->user_id][0];
                                $old = $unique_shop[$product->user_id][1];
                                // matching shipping cost of two product from same shop
                                $c = $shipping_charges->$match > $old;
                                // dd($shipping_charges->$match, $old, $c);
                                if ($c) {
                                    $unique_shop[$product->user_id][1] = $shipping_charges->$match;
                                }
                                // if ($unique_shop[$product->user_id] != 'none') {
                                //     $shipping_charges->$unique_shop[$product->user_id] < $tmpShip ? ($tmpShip += $shipping_charges->$unique_shop[$product->user_id]) : ($tmpShip += 0);
                                // } else {
                                //     $shipping_charges->scountry < $tmpShip ? ($tmpShip += $shipping_charges->scountry) : ($tmpShip += 0);
                                // }
                            }
                            // $shipping += $tmpShip;
                        } else {
                            // $shipping += $cartItem['shipping'];
                            $matchpoint = ['scountry', $cartItem['shipping']];
                            $unique_shop[$product->user_id] = $matchpoint;
                        }

                        $product_name_with_choice = $product->name;
                        if ($cartItem['variant'] != null) {
                            $product_name_with_choice = $product->name . ' - ' . $cartItem['variant'];
                        }
                    @endphp
                    <tr class="cart_item">
                        <td class="product-name">
                            {{ $product_name_with_choice }}
                            <strong class="product-quantity">× {{ $cartItem['quantity'] }}</strong>
                        </td>
                        <td class="product-total text-right">
                            <span class="pl-4">{{ single_price($cartItem['price'] * $cartItem['quantity']) }}</span>
                        </td>
                    </tr>
                @endforeach
                @php
                    foreach ($unique_shop as $key => $value) {
                        $shipping += $value[1];
                    }
                    // dd($unique_shop);
                    // dd(Session::get('shipping_info'));
                    if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'seller_wise_shipping') {
                        if (!empty($admin_products)) {
                            $shipping = \App\BusinessSetting::where('type', 'shipping_cost_admin')->first()->value;
                        }
                        if (!empty($seller_products)) {
                            foreach ($seller_products as $key => $seller_product) {
                                $shipping += \App\Shop::where('user_id', $key)->first()->shipping_cost;
                            }
                        }
                    }
                @endphp
            </tbody>
        </table>

        <table class="table-cart table-cart-review">

            <tfoot>
                <tr class="cart-subtotal">
                    <th>{{ __('Subtotal') }}</th>
                    <td class="text-right">
                        <span class="strong-600">{{ single_price($subtotal) }}</span>
                    </td>
                </tr>

                <tr class="cart-shipping">
                    <th>{{ __('Tax') }}</th>
                    <td class="text-right">
                        <span class="text-italic">{{ single_price($tax) }}</span>
                    </td>
                </tr>

                <tr class="cart-shipping">
                    <th>{{ __('Shipping Cost') }}</th>
                    <td class="text-right">
                        <span class="text-italic">{{ single_price($shipping) }}</span>
                    </td>
                </tr>

                @if (Session::has('coupon_discount'))
                    <tr class="cart-shipping">
                        <th>{{ __('Coupon Discount') }}</th>
                        <td class="text-right">
                            <span class="text-italic">{{ single_price(Session::get('coupon_discount')) }}</span>
                        </td>
                    </tr>
                @endif

                @php
                    $total = $subtotal + $tax + $shipping;
                    if (Session::has('coupon_discount')) {
                        $total -= Session::get('coupon_discount');
                    }
                @endphp

                <tr class="cart-total">
                    <th><span class="strong-600">{{ __('Total') }}</span></th>
                    <td class="text-right">
                        <strong><span>{{ single_price($total) }}</span></strong>
                    </td>
                </tr>
            </tfoot>
        </table>

        @if (Auth::check() && \App\BusinessSetting::where('type', 'coupon_system')->first()->value == 1)
            @if (Session::has('coupon_discount'))
                <div class="mt-3">
                    <form class="form-inline" action="{{ route('checkout.remove_coupon_code') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group flex-grow-1">
                            <div class="form-control bg-gray w-100">
                                {{ \App\Coupon::find(Session::get('coupon_id'))->code }}</div>
                        </div>
                        <button type="submit" class="btn btn-base-1">{{ __('Change Coupon') }}</button>
                    </form>
                </div>
            @else
                <div class="mt-3">
                    <form class="form-inline" action="{{ route('checkout.apply_coupon_code') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group flex-grow-1">
                            <input type="text" class="form-control w-100" name="code"
                                placeholder="{{ __('Have coupon code? Enter here') }}" required>
                        </div>
                        <button type="submit" class="btn btn-base-1">{{ __('Apply') }}</button>
                    </form>
                </div>
            @endif
        @endif

    </div>
</div>
