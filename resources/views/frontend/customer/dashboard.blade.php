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
                    @include('frontend.inc.customer_side_nav')
                </div>
                <div class="col-lg-9">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-3 col-12">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{ __('Dashboard') }}

                                </h2>

                            </div>

                            <div class="col-md-1 col-12 d-flex" style="justify-content: center;">

                                {{-- <a href="#">
                                    <i class="fa fa-bell-o" style="font-size:24px; color:#000;"></i>
                                </a> --}}
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
                                    $support_ticket = DB::table('tickets')
                                        ->where('client_viewed', 0)
                                        ->where('user_id', Auth::user()->id)
                                        ->count();
                                @endphp
                                <?php //echo $refund_request_addon;
                                ?>
                                <div class="dropdown">

                                    <i class="fa fa-bell-o dropbtn" style="font-size:24px; color:#000;"></i>
                                    @if ($delivery_viewed > 0 || $payment_status_viewed > 0 || $delivery_viewed > 0 || $payment_status_viewed > 0)
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
                                    <i class="fa fa-envelope-o" style="font-size:20px; color:#000;"></i>



                                    @if (\App\BusinessSetting::where('type', 'conversation_system')->first()->value == 1)
                                        {{-- @php
                                            $conversation = \App\Conversation::where('sender_id', Auth::user()->id)
                                                ->where('receiver_viewed', 0)
                                                ->get();
                                        @endphp --}}
                                        {{-- @if (count($conversation) > 0) --}}
                                        @if (count(
                                                \App\Conversation::where('sender_id', Auth::user()->id)->where('receiver_viewed', 0)->get()) > 0)
                                            <span class="alert_msg"
                                                style="color: #fff;position: absolute;top: -4px;	background: green;	border-radius: 15px;width: 15px;text-align: center;height: 15px;font-size: 10px;"><strong>{{ count($conversation) }}</strong></span>
                                        @endif
                                    @endif
                                </a>

                            </div>
                            </div>
                            <div class="col-md-6 col-12">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        {{ __('Default Shipping Address') }}
                                        <div class="float-right">
                                            <a href="{{ route('profile') }}"
                                                class="btn btn-link btn-sm">{{ __('Edit') }}</a>
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">
                                        @if (Auth::user()->addresses != null)
                                            @php
                                                $address = Auth::user()
                                                    ->addresses->where('set_default', 1)
                                                    ->first();
                                            @endphp
                                            @if ($address != null)
                                                <table>
                                                    <tr class="">
                                                        <td>{{ __('Street') }}:</td>
                                                        <td class="p-1">{{ $address->address }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <td>{{ __('Upazilla /Thana /PS') }}:</td>
                                                        <td class="p-1">{{ $address->postal_code }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <td>{{ __('City') }}:</td>
                                                        <td class="p-1">{{ $address->city }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <td>{{ __('District') }}:</td>
                                                        <td class="p-1">{{ $address->district }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <td>{{ __('Division') }}:</td>
                                                        <td class="p-1">{{ $address->division }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <td>{{ __('Country') }}:</td>
                                                        <td class="p-1">{{ $address->country }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <td>{{ __('Phone') }}:</td>
                                                        <td class="p-1">{{ $address->phone }}</td>
                                                    </tr>
                                                </table>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if (\App\BusinessSetting::where('type', 'classified_product')->first()->value)
                                <div class="col-md-6">
                                    <div class="form-box bg-white mt-4">
                                        <div class="form-box-title px-3 py-2 clearfix ">
                                            {{ __('Purchased Package') }}
                                        </div>
                                        @php
                                            $customer_package = \App\CustomerPackage::find(Auth::user()->customer_package_id);
                                        @endphp
                                        <div class="form-box-content p-3">
                                            @if ($customer_package != null)
                                                <div class="form-box-content p-2 category-widget text-center">
                                                    <center><img alt="Package Logo"
                                                            src="{{ asset($customer_package->logo) }}"
                                                            style="height:100px; width:90px;"></center>
                                                    <br>
                                                    <left> <strong>
                                                            <p>{{ __('Product Upload') }}:
                                                                {{ $customer_package->product_upload }}
                                                                {{ __('Times') }}</p>
                                                        </strong></left>
                                                    <strong>
                                                        <p>{{ __('Product Upload Remaining') }}:
                                                            {{ Auth::user()->remaining_uploads }} {{ __('Times') }}</p>
                                                    </strong>
                                                    <strong>
                                                        <p>
                                                        <div class="name mb-0">{{ __('Current Package') }}:
                                                            {{ $customer_package->name }} <span class="ml-2"><i
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
                                                <a href="{{ route('customer_packages_list_show') }}"
                                                    class="btn btn-styled btn-base-1 btn-outline btn-sm">{{ __('Upgrade Package') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <button type="button" class="btn btn-info btn-lg" id="customer_notice_msg_popup" data-toggle="modal"
        data-target="#myModal" style="display:none;">Open Modal</button>

    @if ($notice->only_customer == '1')
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
