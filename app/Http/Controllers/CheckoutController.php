<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Category;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\InstamojoController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PublicSslCommerzPaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\PaytmController;
use App\Http\Controllers\AamarpayController;
use App\Order;
// use App\Models\Order;
use App\BusinessSetting;
use App\Coupon;
use App\CouponUsage;
use App\User;
use App\Product;
use App\Address;
use Session;

class CheckoutController extends Controller
{

    public function __construct()
    {
        //
    }

    //check the selected payment gateway and redirect to that controller accordingly
    public function checkout(Request $request) 
    { 
        if ($request->payment_option != null) {

            $orderController = new OrderController;
            $orderController->store($request);

            $request->session()->put('payment_type', 'cart_payment');

            $refferred_by = 0;

            $product_referral_code = \Illuminate\Support\Facades\Session::get('product_referral_code');
            if($product_referral_code){
                $refferred_by = User::where('referral_code',$request->product_referral_code)->value('id');
            }

      
     



            if ($request->session()->get('order_id') != null) {
                if ($request->payment_option == 'paypal') {
                    $paypal = new PaypalController;
                    return $paypal->getCheckout();
                } elseif ($request->payment_option == 'stripe') {
                    $stripe = new StripePaymentController;
                    return $stripe->stripe();
                } elseif ($request->payment_option == 'sslcommerz') {
                    $sslcommerz = new PublicSslCommerzPaymentController;
                    return $sslcommerz->index($request);
                } elseif ($request->payment_option == 'instamojo') {
                    $instamojo = new InstamojoController;
                    return $instamojo->pay($request);
                } elseif ($request->payment_option == 'razorpay') {
                    $razorpay = new RazorpayController;
                    return $razorpay->payWithRazorpay($request);
                } elseif ($request->payment_option == 'paystack') {
                    $paystack = new PaystackController;
                    return $paystack->redirectToGateway($request);
                } elseif ($request->payment_option == 'voguepay') {
                    $voguePay = new VoguePayController;
                    return $voguePay->customer_showForm();
                } elseif ($request->payment_option == 'aamarpay') {
                    // dd(session()->all());
                    $user = Auth::user();
                    $order = Order::findOrFail($request->session()->get('order_id'));

                    if (env('AAMARPAY_MERCHANT_ID') == "aamarpaytest" || env('AAMARPAY_SIGNATURE_KEY') == "dbb74894e82415a2f7ff0ec3a97e4183") {
                        // Sandbox Mode
                        $url = 'https://sandbox.aamarpay.com/request.php';
                    } else {
                        // Live Mode
                        $url = 'https://secure.aamarpay.com/request.php';
                    }

                    $fields = array(
                        'store_id' => env('AAMARPAY_MERCHANT_ID'), //store id will be aamarpay,  contact integration@aamarpay.com for test/live id
                        'amount' => $order->grand_total, //transaction amount
                        'payment_type' => 'VISA', //no need to change
                        'currency' => 'BDT',  //currenct will be USD/BDT
                        'tran_id' => uniqid(), //transaction id must be unique from your end
                        'cus_name' => $user->name ?? "Customer Name",  //customer name
                        'cus_email' => $user->email ?? "customeremail@mail.com", //customer email address
                        'cus_add1' => $user->address ?? "Customer Address",  //customer address
                        'cus_add2' => '', //customer address
                        'cus_city' => $user->city ?? "Customer City",  //customer city
                        'cus_state' => $user->city ?? "Customer State",  //state
                        'cus_postcode' => $user->postal_code ?? "N/A", //postcode or zipcode
                        'cus_country' => $user->country ?? "Customer Country",  //country
                        'cus_phone' => $user->phone ?? "1231231231231", //customer phone number
                        'cus_fax' => 'Not¬Applicable',  //fax
                        'ship_name' => 'Ship Name', //ship name
                        'ship_add1' => session()->get('shipping_info')['address'],  //ship address
                        'ship_add2' => session()->get('shipping_info')['address'],
                        'ship_city' => session()->get('shipping_info')['city'],
                        'ship_state' => session()->get('shipping_info')['area'],
                        'ship_postcode' => session()->get('shipping_info')['area'],
                        'ship_country' => session()->get('shipping_info')['country'],
                        'desc' => 'Payment for Order: ' . $order->id,
                        'success_url' => route('success'), //your success route
                        'fail_url' => route('home'), //your fail route
                        'cancel_url' => route('home'), //your cancel route
                        'opt_a' => $order->id,  //optional paramter
                        'opt_b' => '',
                        'opt_c' => '',
                        'opt_d' => '',
                        'signature_key' => env('AAMARPAY_SIGNATURE_KEY')
                    ); //signature key will provided aamarpay, contact integration@aamarpay.com for test/live signature key

                    $fields_string = http_build_query($fields);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_VERBOSE, true);
                    curl_setopt($ch, CURLOPT_URL, $url);

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
                    curl_close($ch);

                    $this->redirect_to_merchant($url_forward);
                } elseif ($request->payment_option == 'paytm') {
                    $paytm = new PaytmController;
                    return $paytm->index();
                } elseif ($request->payment_option == 'cash_on_delivery') {

                    $request->session()->put('cart', collect([]));
                    $request->session()->forget('shipping_info');
                    $request->session()->forget('delivery_info');
                    $request->session()->forget('coupon_id');
                    $request->session()->forget('coupon_discount');

                    flash("Your order has been placed successfully")->success();
                    return redirect()->route('order_confirmed');
                } elseif ($request->payment_option == 'wallet') {
                    $user = Auth::user();
                    $user->balance -= Order::findOrFail($request->session()->get('order_id'))->grand_total;

                    $user->save();
                    return $this->checkout_done($request->session()->get('order_id'), null);
                } else {
                    $order = Order::findOrFail($request->session()->get('order_id'));
                    $order->manual_payment = 1;
                    $order->referred_by = $refferred_by;
                    $order->save();

                    $request->session()->put('cart', collect([]));
                    $request->session()->forget('shipping_info');
                    $request->session()->forget('delivery_info');
                    $request->session()->forget('coupon_id');
                    $request->session()->forget('coupon_discount');

                    flash(__('Your order has been placed successfully. Please submit payment information from purchase history'))->success();
                    return redirect()->route('order_confirmed');
                }
            }
        } else {
            flash(__('Select Payment Option.'))->success();
            return back();
        }
    }

    function redirect_to_merchant($url)
    {
        if (env('AAMARPAY_MERCHANT_ID') == "aamarpaytest" || env('AAMARPAY_SIGNATURE_KEY') == "dbb74894e82415a2f7ff0ec3a97e4183") {
            $formUrl = 'https://sandbox.aamarpay.com/' . $url;
        } else {
            $formUrl = 'https://secure.aamarpay.com/' . $url;
        }

?>
        <html xmlns="http://www.w3.org/1999/xhtml">

        <head>
            <script type="text/javascript">
                function closethisasap() {
                    document.forms["redirectpost"].submit();
                }
            </script>
        </head>

        <body onLoad="closethisasap();">
            <form name="redirectpost" method="post" action="<?php echo $formUrl; ?>"></form>
        </body>

        </html>
<?php
        exit;
    }

    public function success(Request $request)
    {
        try {
            // dd($request->all());
            $order_id = $request->input('opt_a');
            return $this->checkout_done($order_id, null);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //redirects to this method after a successfull checkout
    public function checkout_done($order_id, $payment)
    {
        // dd(session()->all());
        $order = Order::findOrFail($order_id);

        $order->payment_status = 'paid';
        $order->payment_details = $payment;
        $order->save();

        if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
            $affiliateController = new AffiliateController;
            $affiliateController->processAffiliatePoints($order);
        }

        if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
            $clubpointController = new ClubPointController;
            $clubpointController->processClubPoints($order);
        }

        if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() == null || !\App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
            if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {
                $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->payment_status = 'paid';
                    $orderDetail->save();
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $seller = $orderDetail->product->user->seller;
                        $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price * (100 - $commission_percentage)) / 100 + $orderDetail->tax + $orderDetail->shipping_cost;
                        $seller->save();
                    }
                }
            } else {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->payment_status = 'paid';
                    $orderDetail->save();
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $commission_percentage = $orderDetail->product->category->commision_rate;
                        $seller = $orderDetail->product->user->seller;
                        $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price * (100 - $commission_percentage)) / 100  + $orderDetail->tax + $orderDetail->shipping_cost;
                        $seller->save();
                    }
                }
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->payment_status = 'paid';
                $orderDetail->save();
                if ($orderDetail->product->user->user_type == 'seller') {
                    $seller = $orderDetail->product->user->seller;
                    $seller->admin_to_pay = $seller->admin_to_pay + $orderDetail->price + $orderDetail->tax + $orderDetail->shipping_cost;
                    $seller->save();
                }
            }
        }

        $order->commission_calculated = 1;
        $order->save();

        Session::put('cart', collect([]));
        Session::put('order_id', $order_id);
        Session::forget('shipping_info');
        Session::forget('payment_type');
        Session::forget('delivery_info');
        Session::forget('coupon_id');
        Session::forget('coupon_discount');

        flash(__('Payment completed'))->success();
        return redirect()->route('order_confirmed');
    }

    public function get_shipping_info(Request $request)
    {
        if (Session::has('cart') && count(Session::get('cart')) > 0) {
            $categories = Category::all();
            return view('frontend.shipping_info', compact('categories'));
        }
        flash(__('Your cart is empty'))->success();
        return back();
    }

    public function store_shipping_info(Request $request)
    {
        if (Auth::check()) {
            // if (auth()->user()->user_type == 'seller') {
            //     if ($request->city == null) {
            //         flash("Please add shipping city")->warning();
            //         return back();
            //     }
            //     $data['name'] = $request->name;
            //     $data['postal_code'] = $address->postal_code;
            //     $data['address'] = $address->address;
            //     $data['city'] = $address->city;
            //     $data['district'] = $address->district;
            //     $data['division'] = $address->division;
            //     $data['region'] = $address->region;
            //     $data['area'] = $request->area;
            //     $data['phone'] = $address->phone;
            //     $data['country'] = $request->country;
            //     $data['checkout_type'] = $request->checkout_type;
            //     if ($request['shipping_type_admin'] == 'home_delivery') {
            //         $data['shipping_type'] = 'home_delivery';
            //         // $object['shipping'] = \App\Product::find($object['id'])->shipping_cost;
            //     } else {
            //         $data['shipping_type'] = 'pickup_point';
            //         $data['pickup_point'] = $request->pickup_point_id_admin;
            //         // $object['shipping'] = 0;
            //     }
            //     // dd($data);
            // } else {
            //     if ($request->address_id == null) {
            //         flash("Please add shipping address")->warning();
            //         return back();
            //     }
            //     $address = Address::findOrFail($request->address_id);
            //     $data['name'] = Auth::user()->name;
            //     $data['email'] = Auth::user()->email;
            //     $data['postal_code'] = $address->postal_code;
            //     $data['address'] = $address->address;
            //     $data['city'] = $address->city;
            //     $data['district'] = $address->district;
            //     $data['division'] = $address->division;
            //     $data['region'] = $address->region;
            //     $data['area'] = $request->area;
            //     $data['phone'] = $address->phone;
            //     $data['country'] = $request->country;
            //     $data['checkout_type'] = $request->checkout_type;
            //     $data['shipping_type'] = 'home_delivery';
            // }

            if ($request->address_id == null) {
                flash("Please add shipping address")->warning();
                return back();
            }
            $address = Address::findOrFail($request->address_id);
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;
            $data['postal_code'] = $address->postal_code;
            $data['address'] = $address->address;
            $data['city'] = $address->city;
            $data['district'] = $address->district;
            $data['division'] = $address->division;
            $data['region'] = $address->region;
            $data['area'] = $address->area;
            $data['phone'] = $address->phone;
            $data['country'] = $address->country;
            $data['checkout_type'] = $request->checkout_type;
            $data['shipping_type'] = 'home_delivery';
        } else {
            flash("Please Login to Continue")->warning();
            return back();
            // $data['name'] = $request->name;
            // $data['address'] = $request->address;
            // $data['region'] = $request->region;
            // $data['city'] = $request->city;
            // $data['area'] = $request->area;
            // $data['phone'] = $request->phone;
            // $data['country'] = $request->country;
            // $data['checkout_type'] = $request->checkout_type;
            // $data['shipping_type'] = 'home_delivery';
        }

        $subtotal = 0;
        $tax = 0;

        $user_address = $address;
        $unique_shop = [];

        $shipping = 0;

        function lowerCompare($str1 = '', $str2 = '')
        {
            if (strtolower($str1) == strtolower($str2)) {
                return true;
            }
            return false;
        }

        // if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'flat_rate') {
        //     $shipping = \App\BusinessSetting::where('type', 'flat_rate_shipping_cost')->first()->value;
        // }
        // calculating shipping ** I know... **
        foreach (Session::get('cart') as $key => $cartItem) {
            $product = Product::find($cartItem['id']);
            $subtotal += $cartItem['price'] * $cartItem['quantity'];
            $tax += $cartItem['tax'] * $cartItem['quantity'];

            if ($product->shipping_type == 'dynamic') {
                $shipping_charges = json_decode($product->shipping_charges);
                $shop_address = $cartItem['address'];
                $tmpShip = 0;


                if (!array_key_exists($product->user_id, $unique_shop)) {
                    $matchpoint = [];
                    // array_push($unique_shop, $cartItem['user_id']);
                    // dd($shipping_charges, $shop_address, $user_address);
                    // dd($shop_address->postal_code, $user_address->postal_code);

                    if (lowerCompare($shop_address->postal_code, $user_address->postal_code)) {
                        // Upazilla /Thana /PS
                        $tmpShip += $shipping_charges->sutp;
                        $matchpoint = ['sutp', $tmpShip, 1];
                        // third value acts as how many items are from a shop
                    } elseif (lowerCompare($shop_address->city, $user_address->city)) {
                        // City
                        $tmpShip += $shipping_charges->scity;
                        $matchpoint = ['scity', $tmpShip, 1];
                        // $matchpoint = 'scity';
                    } elseif (lowerCompare($shop_address->district, $user_address->district)) {
                        // District
                        $tmpShip += $shipping_charges->sdistrict;
                        $matchpoint = ['sdistrict', $tmpShip, 1];
                        // $matchpoint = 'sdistrict';
                    } elseif (lowerCompare($shop_address->division, $user_address->division)) {
                        // Division
                        $tmpShip += $shipping_charges->sdivision;
                        $matchpoint = ['sdivision', $tmpShip, 1];
                        // $matchpoint = 'sdivision';
                        // } elseif (lowerCompare($shop_address->country, $user_address->country)) {
                        //     // Country
                        //     $tmpShip += $shipping_charges->scountry;
                        //     $matchpoint = ['scountry', $tmpShip, 1];
                        //     // $matchpoint = 'scountry';
                    } else {
                        # code...
                        $tmpShip += $shipping_charges->scountry;
                        $matchpoint = ['scountry', $tmpShip, 1];
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
                    $unique_shop[$product->user_id][2] = $unique_shop[$product->user_id][2] + 1;
                    // increasing product count
                    // if ($unique_shop[$product->user_id] != 'none') {
                    //     $shipping_charges->$unique_shop[$product->user_id] < $tmpShip ? ($tmpShip += $shipping_charges->$unique_shop[$product->user_id]) : ($tmpShip += 0);
                    // } else {
                    //     $shipping_charges->scountry < $tmpShip ? ($tmpShip += $shipping_charges->scountry) : ($tmpShip += 0);
                    // }
                }
                // $shipping += $tmpShip;
            } else {
                // $shipping += $cartItem['shipping'];
                $matchpoint = ['scountry', $cartItem['shipping'], 1];
                $unique_shop[$product->user_id] = $matchpoint;
            }

            // $shipping += $shipping;
        }
        foreach ($unique_shop as $key => $value) {
            $shipping += $value[1];
        }

        $data['shipping'] = $shipping;
        $data['unique_shop'] = $unique_shop;

        $shipping_info = $data;
        // dd($data);
        $request->session()->put('shipping_info', $shipping_info);

        $shipping_type = $request['shipping_type_admin'];
        $pickup_point = $request->pickup_point_id_admin;
        // $pickup_point=
        $total = $subtotal + $tax + $shipping;
        $cart = $request->session()->get('cart', collect([]));
        $cart = $cart->map(function ($object, $key) use ($shipping_type, $pickup_point, $unique_shop) {

            $object['shipping_type'] = $shipping_type;
            $object['pickup_point'] = $pickup_point;
            $object['unique_shop'] = $unique_shop;

            return $object;
        });
        $request->session()->put('cart', $cart);

        if (Session::has('coupon_discount')) {
            $total -= Session::get('coupon_discount');
        }
        // dd(Session::get('cart'));
        // return view('frontend.delivery_info');
        return view('frontend.payment_select', compact('total'));
    }

    public function store_delivery_info(Request $request)
    {
        if (Session::has('cart') && count(Session::get('cart')) > 0) {
            $cart = $request->session()->get('cart', collect([]));
            $cart = $cart->map(function ($object, $key) use ($request) {
                if (\App\Product::find($object['id'])->added_by == 'admin') {
                    if ($request['shipping_type_admin'] == 'home_delivery') {
                        $object['shipping_type'] = 'home_delivery';
                        // $object['shipping'] = \App\Product::find($object['id'])->shipping_cost;
                    } else {
                        $object['shipping_type'] = 'pickup_point';
                        $object['pickup_point'] = $request->pickup_point_id_admin;
                        // $object['shipping'] = 0;
                    }
                } else {
                    if ($request['shipping_type_' . \App\Product::find($object['id'])->user_id] == 'home_delivery') {
                        $object['shipping_type'] = 'home_delivery';
                        // $object['shipping'] = \App\Product::find($object['id'])->shipping_cost;
                    } else {
                        $object['shipping_type'] = 'pickup_point';
                        $object['pickup_point'] = $request['pickup_point_id_' . \App\Product::find($object['id'])->user_id];
                        // $object['shipping'] = 0;
                    }
                }
                return $object;
            });

            $request->session()->put('cart', $cart);

            $subtotal = 0;
            $tax = 0;

            $shipping_info = Session::get('shipping_info');
            $shipping = $shipping_info->shipping;

            foreach (Session::get('cart') as $key => $cartItem) {
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                // $shipping += $cartItem['shipping'] * $cartItem['quantity'];
            }
            // $shipping = 0;

            $total = $subtotal + $tax + $shipping;

            if (Session::has('coupon_discount')) {
                $total -= Session::get('coupon_discount');
            }

            //dd($total);

            return view('frontend.payment_select', compact('total'));
        } else {
            flash('Your Cart was empty')->warning();
            return redirect()->route('home');
        }
    }

    public function get_payment_info(Request $request)
    {
        $subtotal = 0;
        $tax = 0;
        $shipping_info = Session::get('shipping_info');
        $shipping = $shipping_info->shipping ?? 0;
        foreach (Session::get('cart') as $key => $cartItem) {
            $subtotal += $cartItem['price'] * $cartItem['quantity'];
            $tax += $cartItem['tax'] * $cartItem['quantity'];
            // $shipping += $cartItem['shipping'] * $cartItem['quantity'];
        }

        $total = $subtotal + $tax + $shipping;

        if (Session::has('coupon_discount')) {
            $total -= Session::get('coupon_discount');
        }

        return view('frontend.payment_select', compact('total'));
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();

        if ($coupon != null) {
            if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                if (CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first() == null) {
                    $coupon_details = json_decode($coupon->details);

                    if ($coupon->type == 'cart_base') {
                        $subtotal = 0;
                        $tax = 0;
                        $shipping_info = Session::get('shipping_info');
                        $shipping = $shipping_info->shipping ?? 0;
                        foreach (Session::get('cart') as $key => $cartItem) {
                            $subtotal += $cartItem['price'] * $cartItem['quantity'];
                            $tax += $cartItem['tax'] * $cartItem['quantity'];
                            // $shipping += $cartItem['shipping'] * $cartItem['quantity'];
                        }
                        $sum = $subtotal + $tax + $shipping;

                        if ($sum > $coupon_details->min_buy) {
                            if ($coupon->discount_type == 'percent') {
                                $coupon_discount =  ($sum * $coupon->discount) / 100;
                                if ($coupon_discount > $coupon_details->max_discount) {
                                    $coupon_discount = $coupon_details->max_discount;
                                }
                            } elseif ($coupon->discount_type == 'amount') {
                                $coupon_discount = $coupon->discount;
                            }
                            $request->session()->put('coupon_id', $coupon->id);
                            $request->session()->put('coupon_discount', $coupon_discount);
                            flash('Coupon has been applied')->success();
                        }
                    } elseif ($coupon->type == 'product_base') {
                        $coupon_discount = 0;
                        foreach (Session::get('cart') as $key => $cartItem) {
                            foreach ($coupon_details as $key => $coupon_detail) {
                                if ($coupon_detail->product_id == $cartItem['id']) {
                                    if ($coupon->discount_type == 'percent') {
                                        $coupon_discount += $cartItem['price'] * $coupon->discount / 100;
                                    } elseif ($coupon->discount_type == 'amount') {
                                        $coupon_discount += $coupon->discount;
                                    }
                                }
                            }
                        }
                        $request->session()->put('coupon_id', $coupon->id);
                        $request->session()->put('coupon_discount', $coupon_discount);
                        flash('Coupon has been applied')->success();
                    }
                } else {
                    flash('You already used this coupon!')->warning();
                }
            } else {
                flash('Coupon expired!')->warning();
            }
        } else {
            flash('Invalid coupon!')->warning();
        }
        return back();
    }

    public function remove_coupon_code(Request $request)
    {
        $request->session()->forget('coupon_id');
        $request->session()->forget('coupon_discount');
        return back();
    }

    public function order_confirmed()
    {
        try {
            // dd(session()->all());
            $order = Order::findOrFail(Session::get('order_id'));
            return view('frontend.order_confirmed', compact('order'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
