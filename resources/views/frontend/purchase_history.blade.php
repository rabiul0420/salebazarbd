@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if (Auth::user()->user_type == 'seller')
                        @include('frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('frontend.inc.customer_side_nav')
                    @endif
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{ __('Purchase History') }}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                                            <li class="active"><a
                                                    href="{{ route('purchase_history.index') }}">{{ __('Purchase History') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <form action="" method="get">
                                <div class="row align-items-center pt-2">

                                    <div class="form-group col-6 col-sm-4">
                                        <div id="reportrange" class="form-control pull-left"
                                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span></span>
                                            <div></div> <b class="caret"></b>
                                        </div>


                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-group">
                                            <select name="status" class="form-control selectpicker" data-placeholder="{{__('Filter by Order Status')}}">
                                                <option value="">Filter by Order Status</option>
                                                <option value="pending" @isset($delivery_status) @if($delivery_status == 'pending') selected @endif @endisset>{{__('Pending')}}</option>
                                                <option value="ready_to_ship" @isset($delivery_status) @if($delivery_status == 'ready_to_ship') selected @endif @endisset>{{__('Ready to ship')}}</option>
                                                <option value="shipped" @isset($delivery_status) @if($delivery_status == 'shipped') selected @endif @endisset>{{__('Shipped')}}</option>
                                                <option value="delivered" @isset($delivery_status) @if($delivery_status == 'delivered') selected @endif @endisset>{{__('Delivered')}}</option>
                                                <option value="cancelled" @isset($delivery_status) @if($delivery_status == 'cancelled') selected @endif @endisset>{{__('Cancelled')}}</option>
                                                <option value="returned" @isset($delivery_status) @if($delivery_status == 'returned') selected @endif @endisset>{{__('Returned')}}</option>
                                                <option value="failed_delivery" @isset($delivery_status) @if($delivery_status == 'failed_delivery') selected @endif @endisset>{{__('Failed Delivery')}}</option>
                                                <option value="refund_only" @isset($delivery_status) @if($delivery_status == 'refund_only') selected @endif @endisset>{{__('Refund Only')}}</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div class="form-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search Keyword">

                                        </div>

                                    </div>
                                    <div class="form-group col-6 col-sm-2">
                                        <button type="submit" class="btn btn-styled btn-base-1">Search</button>
                                    </div>


                                </div>
                            </form>
                        </div>

                        @if (count($orders) > 0)
                            <!-- Order history table -->
                            <div class="card no-border mt-4">

                                <div>
                                    <table class="table table-sm table-hover table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Code') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                                @if (auth()->user()->user_type == 'seller')
                                                    <th>{{ __('Profit') }}</th>
                                                @endif
                                                <th>{{ __('Delivery Status') }}</th>
                                                <th>{{ __('Payment Status') }}</th>
                                                <th>{{ __('Options') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $order)
                                                @if (count($order->orderDetails) > 0)
                                                    <tr>
                                                        <td>
                                                            <a href="#{{ $order->code }}"
                                                                onclick="show_purchase_history_details({{ $order->id }})">{{ $order->code }}</a>
                                                        </td>
                                                        <td>{{ date('d-m-Y', $order->date) }}</td>
                                                        <td>
                                                            {{ single_price($order->grand_total) }}
                                                        </td>
                                                        @if (auth()->user()->user_type == 'seller')
                                                            <td>
                                                                {{ single_price($order->reseller_to_pay) }}
                                                            </td>
                                                        @endif
                                                        <td>
                                                            {{ ucfirst(str_replace('_', ' ', $order->orderDetails->first()->delivery_status)) }}
                                                            @if ($order->delivery_viewed == 0)
                                                                <span class="ml-2"
                                                                    style="color:green"><strong>*</strong></span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge--2 mr-4">
                                                                @if ($order->payment_status == 'paid')
                                                                    <i class="bg-green"></i> {{ __('Paid') }}
                                                                @else
                                                                    <i class="bg-red"></i> {{ __('Unpaid') }}
                                                                @endif
                                                                @if ($order->payment_status_viewed == 0)
                                                                    <span class="ml-2"
                                                                        style="color:green"><strong>*</strong></span>
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn" type="button" id=""
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-right"
                                                                    aria-labelledby="">
                                                                    <button
                                                                        onclick="show_purchase_history_details({{ $order->id }})"
                                                                        class="dropdown-item">{{ __('Order Details') }}</button>
                                                                    <a href="{{ route('customer.invoice.download', $order->id) }}"
                                                                        class="dropdown-item">{{ __('Download Invoice') }}</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="pagination-wrapper py-4">
                            <ul class="pagination justify-content-end">
                                {{ $orders->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size"
            role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title strong-600 heading-5">{{ __('Make Payment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="payment_modal_body"></div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#reportrange div').html('<input type="hidden" name="start" value="' + start.format('YYYY-M-D') +
                    '"><input type="hidden" name="end" value="' + end.format('YYYY-M-D') + '">');






            }
            $('#reportrange').click(function() {
                $('.opensright').css({
                    opacity: "1",
                    visibility: "visible"
                });
            });

            $('#reportrange').daterangepicker({

                // $('.daterangepicker').addClass('daterangecl');
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },


            }, cb);

            cb(start, end);

        });
    </script>
    <script type="text/javascript">
        $('#order_details').on('hidden.bs.modal', function() {
            location.reload();
        });
    </script>
@endsection
