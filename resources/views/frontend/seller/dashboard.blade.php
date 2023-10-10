@extends('frontend.layouts.app')

@section('content')
    <style>
        .dropbtn {

            color: white;
            padding: 4px 7px 7px 0px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 179px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            overflow-y: scroll;
            min-height: 42px;
            max-height: 100px;
            font-size: 11px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.seller_side_nav')
                </div>

                <div class="col-lg-9">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-2 col-12">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{ __('Dashboard') }}

                                </h2>

                            </div>

                            <div class="col-md-1 col-12 d-flex " style="justify-content: center;">

                                {{-- <a href="#">

                                    <i class="fa fa-bell-o" style="font-size:24px; color:#000;"></i>

                                </a> --}}
                                
                                <!--$orders = DB::table('orders')-->
                                <!--        ->orderBy('code', 'desc')-->
                                <!--        ->join('order_details', 'orders.id', '=', 'order_details.order_id')-->
                                <!--        ->where('order_details.seller_id', Auth::user()->id)-->
                                <!--        ->where('orders.viewed', 0)-->
                                <!--        ->select('orders.id')-->
                                <!--        ->distinct()-->
                                <!--        ->count();-->
                                
                                @php
                                    $delivery_viewed = App\Order::where('user_id', Auth::user()->id)
                                        ->where('delivery_viewed', 0)
                                        ->get()
                                        ->count();
                                    $payment_status_viewed = App\Order::where('user_id', Auth::user()->id)
                                        ->where('payment_status_viewed', 0)
                                        ->get()
                                        ->count();
                                    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                                    $club_point_addon = \App\Addon::where('unique_identifier', 'club_point')->first();
                                    
                                    $orders = \App\Models\Notification::where('seller_id', Auth::user()->id)
                                        ->where('is_read', 0)->count();
                                        
                                    $review_count = DB::table('reviews')
                                        ->orderBy('code', 'desc')
                                        ->join('products', 'products.id', '=', 'reviews.product_id')
                                        ->where('products.user_id', Auth::user()->id)
                                        ->where('reviews.viewed', 0)
                                        ->select('reviews.id')
                                        ->distinct()
                                        ->count();
                                    $support_ticket = DB::table('tickets')
                                        ->where('client_viewed', 0)
                                        ->where('user_id', Auth::user()->id)
                                        ->count();
                                @endphp
                                <?php //echo $refund_request_addon;
                                ?>
                                <div class="dropdown">

                                    <i class="fa fa-bell-o dropbtn" style="font-size:24px; color:#000;"></i>
                                    @if (
                                        $delivery_viewed > 0 ||
                                            $payment_status_viewed > 0 ||
                                            $delivery_viewed > 0 ||
                                            $payment_status_viewed > 0 ||
                                            $orders > 0)
                                        <span class="alert_msg"
                                            style="color: transparent;position: absolute;top: 2px;background: #e21b1b;border-radius: 18px;width: 10px;height: 10px;text-align: center;left: 19px;"><strong>.</strong></span>
                                    @endif
                                    <div class="dropdown-content">
                                        @if ($delivery_viewed > 0 || $payment_status_viewed > 0)
                                            <a href="{{ route('purchase_history.index') }}"><span class="ml-2"
                                                    style="color:green"><strong>{{ $delivery_viewed }}
                                                        {{ __('Purchase History') }}</strong></span>
                                                </span></a>
                                        @endif
                                        @if ($orders > 0)
                                            <a href="{{ route('orders.index') }}"> <span class="ml-2" style="color:green">
                                                    <strong>({{ $orders }} {{ __('Orders') }}
                                                        {{ 'New' }})</strong></span></span></a>
                                        @endif
                                        @if ($review_count > 0)
                                            <a href="{{ route('reviews.seller') }}"> <span class="ml-2"
                                                    style="color:green"> <strong>({{ $review_count }} {{ __('Orders') }}
                                                        {{ 'New' }})</strong></span></span></a>
                                        @endif
                                        @if ($support_ticket > 0)
                                            <a href="{{ route('support_ticket.index') }}"> <span class="ml-2"
                                                    style="color:green"><strong>({{ $support_ticket }}
                                                        {{ __('New') }})</strong></span></span></a>
                                        @endif
                                    </div>
                                </div>


                            <!--</div>-->
                            <!--<div class="col-md-1 col-12">-->
                                    <div class="ml-5 pl-3 mt-1">
                                <a href="{{ route('conversations.index') }}"
                                    class="{{ areActiveRoutesHome(['conversations.index', 'conversations.show']) }}">
                                    <i class="fa fa-envelope-o" style="font-size:24px; color:#000;"></i>
                                    @if (\App\BusinessSetting::where('type', 'conversation_system')->first()->value == 1)
                                        @php
                                            $conversation_sent = \App\Conversation::where('sender_id', Auth::user()->id)
                                                ->where('sender_viewed', 0)
                                                ->get();
                                            $conversation_recieved = \App\Conversation::where('receiver_id', Auth::user()->id)
                                                ->where('receiver_viewed', 0)
                                                ->get();
                                        @endphp

                                        @if (count($conversation_sent) + count($conversation_recieved) > 0)
                                            <span class="alert_msg"
                                                style="color: #fff;position: absolute;top: -4px;	background: green;	border-radius: 15px;width: 15px;text-align: center;height: 15px;font-size: 10px;"><strong>{{ count($conversation_sent) + count($conversation_recieved) }}</strong></span>
                                        @endif
                                    @endif
                                </a>
                            </div>
                            </div>

                            <div class="col-md-8 col-12">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                        <li class="active"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- dashboard content -->
                    <div class="">
                        @if (Auth::user()->role == 3 || Auth::user()->role == 1)
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <div class="dashboard-widget text-center green-widget mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-upload"></i>
                                            <span
                                                class="d-block title heading-3 strong-400">{{ count(\App\Product::where('user_id', Auth::user()->id)->get()) }}</span>
                                            <span class="d-block sub-title">{{ __('Products') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="dashboard-widget text-center red-widget mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-cart-plus"></i>
                                            <span
                                                class="d-block title heading-3 strong-400">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('delivery_status', 'delivered')->get()) }}</span>
                                            <span class="d-block sub-title">{{ __('Total sale') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="dashboard-widget text-center blue-widget mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-dollar"></i>
                                            @php
                                                $orderDetails = \App\OrderDetail::where('seller_id', Auth::user()->id)->get();
                                                $total = 0;
                                                foreach ($orderDetails as $key => $orderDetail) {
                                                    // if ($orderDetail->order->payment_status == 'paid') {
                                                    if ($orderDetail->payment_status == 'paid') {
                                                        $total += $orderDetail->price;
                                                    }
                                                }
                                            @endphp
                                            <span
                                                class="d-block title heading-3 strong-400">{{ single_price($total) }}</span>
                                            <span class="d-block sub-title">{{ __('Total earnings') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="dashboard-widget text-center yellow-widget mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-check-square-o"></i>
                                            <span
                                                class="d-block title heading-3 strong-400">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('delivery_status', 'delivered')->get()) }}</span>
                                            <span class="d-block sub-title">{{ __('Successful orders') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif(Auth::user()->role == 2 || Auth::user()->role == 1)
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="dashboard-widget text-center green-widget mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-shopping-cart"></i>
                                            @if (Session::has('cart'))
                                                <span class="d-block title">{{ count(Session::get('cart')) }}
                                                    {{ __('Product(s)') }}</span>
                                            @else
                                                <span class="d-block title">0 {{ __('Product') }}</span>
                                            @endif
                                            <span class="d-block sub-title">{{ __('in your cart') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="dashboard-widget text-center red-widget mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-heart"></i>
                                            <span class="d-block title">{{ count(Auth::user()->wishlists) }}
                                                {{ __('Product(s)') }}</span>
                                            <span class="d-block sub-title">{{ __('in your wishlist') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="dashboard-widget text-center yellow-widget mt-4 c-pointer">
                                        <a href="javascript:;" class="d-block">
                                            <i class="fa fa-building"></i>
                                            @php
                                                $orders = \App\Order::where('user_id', Auth::user()->id)->get();
                                                $total = 0;
                                                foreach ($orders as $key => $order) {
                                                    $total += count($order->orderDetails);
                                                }
                                            @endphp
                                            <span class="d-block title">{{ $total }} {{ __('Product(s)') }}</span>
                                            <span class="d-block sub-title">{{ __('you ordered') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-7">
                                @if (Auth::user()->role == 3 || Auth::user()->role == 1)
                                    <div class="form-box bg-white mt-4">
                                        <div class="form-box-title px-3 py-2 text-center">
                                            {{ __('Seller Orders') }}
                                        </div>
                                        <div class="form-box-content p-3">
                                            <table class="table mb-0 table-bordered" style="font-size:14px;">
                                                <tr>
                                                    <td>{{ __('Total orders') }}:</td>
                                                    <td><strong class="heading-6">
                                                            {{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->get()) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Pending orders') }}:</td>
                                                    <td><strong
                                                            class="heading-6">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('delivery_status', 'pending')->get()) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Cancelled orders') }}:</td>
                                                    <td><strong
                                                            class="heading-6">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('delivery_status', 'cancelled')->get()) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Successful orders') }}:</td>
                                                    <td><strong
                                                            class="heading-6">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('delivery_status', 'delivered')->get()) }}</strong>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @elseif(Auth::user()->role == 2 || Auth::user()->role == 1)
                                    <div class="form-box bg-white mt-4">
                                        <div class="form-box-title px-3 py-2 text-center">
                                            {{ __('Reseller Orders') }}
                                        </div>
                                        <div class="form-box-content p-3">
                                            <table class="table mb-0 table-bordered" style="font-size:14px;">
                                                <tr>
                                                    <td>{{ __('Total orders') }}:</td>
                                                    <td><strong class="heading-6">
                                                            {{ count(\App\Order::where('user_id', Auth::user()->id)->get()) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Pending orders') }}:</td>
                                                    <td><strong
                                                            class="heading-6">{{ count(\App\Order::where('user_id', Auth::user()->id)->where('status', '1')->get()) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Cancelled orders') }}:</td>
                                                    <td><strong
                                                            class="heading-6">{{ count(\App\Order::where('user_id', Auth::user()->id)->where('delivery_status', 'cancelled')->get()) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('Successful orders') }}:</td>
                                                    <td><strong
                                                            class="heading-6">{{ count(\App\Order::where('user_id', Auth::user()->id)->where('delivery_status', 'delivered')->get()) }}</strong>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-5">
                                <div class="bg-white mt-4 p-5 text-center">
                                    <div class="mb-3">
                                        @if (Auth::user()->seller->verification_status == 0)
                                            <img loading="lazy"
                                                src="{{ asset('frontend/images/icons/non_verified.png') }}"
                                                alt="" width="130">
                                        @else
                                            <img loading="lazy" src="{{ asset('frontend/images/icons/verified.png') }}"
                                                alt="" width="130">
                                        @endif
                                    </div>
                                    @if (Auth::user()->seller->verification_status == 0)
                                        <a href="{{ route('shop.verify') }}"
                                            class="btn btn-styled btn-base-1">{{ __('Verify Now') }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if (Auth::user()->role == 3 || Auth::user()->role == 1)
                                <div class="col-md-8">
                                    <div class="form-box bg-white mt-4">
                                        <div class="form-box-title px-3 py-2 text-center">
                                            {{ __('Products') }}
                                        </div>
                                        <div class="form-box-content p-3 category-widget">
                                            <ul class="clearfix">
                                                @foreach (\App\Category::all() as $key => $category)
                                                    @if (count($category->products->where('user_id', Auth::user()->id)) > 0)
                                                        <li><a>{{ __($category->name) }}<span>({{ count($category->products->where('user_id', Auth::user()->id)) }})</span></a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <div class="text-center">
                                                <a href="{{ route('seller.products.upload') }}"
                                                    class="btn pt-3 pb-1">{{ __('Add New Product') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                @if (
                                    \App\Addon::where('unique_identifier', 'seller_subscription')->first() != null &&
                                        \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated)
                                    <div class="form-box bg-white mt-4">
                                        <div class="form-box-title px-3 py-2 clearfix ">
                                            {{ __('Purchased Package') }}
                                        </div>
                                        @php
                                            $seller_package = \App\SellerPackage::find(Auth::user()->seller->seller_package_id);
                                        @endphp
                                        <div class="form-box-content p-3">
                                            @if ($seller_package != null)
                                                <div class="form-box-content p-2 category-widget text-center">
                                                    <center><img alt="Package Logo"
                                                            src="{{ asset($seller_package->logo) }}"
                                                            style="height:100px; width:90px;"></center>
                                                    <br>
                                                    <strong>
                                                        <p>{{ __('Product Upload Remaining') }}:
                                                            {{ Auth::user()->seller->remaining_uploads }}
                                                            {{ __('Times') }}</p>
                                                    </strong>
                                                    <strong>
                                                        <p>{{ __('Digital Product Upload Remaining') }}:
                                                            {{ Auth::user()->seller->remaining_digital_uploads }}
                                                            {{ __('Times') }}</p>
                                                    </strong>
                                                    <strong>
                                                        <p>{{ __('Package Expires at') }}:
                                                            {{ Auth::user()->seller->invalid_at }}</p>
                                                    </strong>
                                                    <strong>
                                                        <p>
                                                        <div class="name mb-0">{{ __('Current Package') }}:
                                                            {{ $seller_package->name }} <span class="ml-2"><i
                                                                    class="fa fa-check-circle"
                                                                    style="color:green"></i></span></div>
                                                        </p>
                                                    </strong>
                                                </div>
                                            @else
                                                <div class="form-box-content p-2 category-widget text-center">
                                                    <center><strong>
                                                            <p>{{ __('Package Not Found') }}</p>
                                                        </strong></center>
                                                </div>
                                            @endif
                                            <div class="text-center">
                                                <a href="{{ route('seller_packages_list') }}"
                                                    class="btn btn-styled btn-base-1 btn-outline btn-sm">{{ __('Upgrade Package') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (Auth::user()->role == 3 || Auth::user()->role == 1)
                                    <div class="bg-white mt-4 p-4 text-center">
                                        <div class="heading-4 strong-700">{{ __('Shop') }}</div>
                                        <p>{{ __('Manage & organize your shop') }}</p>
                                        <a href="{{ route('shops.index') }}"
                                            class="btn btn-styled btn-base-1 btn-outline btn-sm">{{ __('Go to setting') }}</a>
                                    </div>
                                @endif
                                <div class="bg-white mt-4 p-4 text-center">
                                    <div class="heading-4 strong-700">{{ __('Payment') }}</div>
                                    <p>{{ __('Configure your payment method') }}</p>
                                    <a href="{{ route('profile') }}"
                                        class="btn btn-styled btn-base-1 btn-outline btn-sm">{{ __('Configure Now') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <button type="button" class="btn btn-info btn-lg" id="customer_notice_msg_popup" data-toggle="modal"
        data-target="#myModal" style="display:none;">Open Modal</button>

    @if ($notice->only_seller == '1')
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title text-center">{{ $notice->title }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <p><?php echo $content = stripslashes($notice->content); ?></p>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div> --}}
                </div>

            </div>
        </div>
    @endif

@endsection

@section('script')
    <script>
        $("document").ready(function() {
            $("#customer_notice_msg_popup").trigger('click');
        });
    </script>
@endsection
