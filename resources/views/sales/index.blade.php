@extends('layouts.app')

@section('content')
@php
    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
@endphp
<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading bord-btm clearfix pad-all h-100">
        <h3 class="panel-title pull-left pad-no">{{__('Orders')}}</h3>

        <div class="pull-right clearfix">
            <form class="" id="sort_orders" action="" method="GET">
                <div class="box-inline pad-rgt pull-left  col-md-3">
                    <div class="input-group input-daterange">
                        <input autocomplete="of" name="start" type="text" class="form-control" value="2020-10-17">
                        <div class="input-group-addon">to</div>
                        <input name="end" type="text" class="form-control" on="date_orders()"  value="2020-10-18">
                    </div>
                </div>
                <div class="box-inline pad-rgt pull-left">
                    <div class="select" style="min-width: 300px;">
                        <select class="form-control demo-select2" name="payment_type" id="payment_type" onchange="sort_orders()">
                            <option value="">{{__('Filter by Payment Status')}}</option>
                            <option value="paid"  @isset($payment_status) @if($payment_status == 'paid') selected @endif @endisset>{{__('Paid')}}</option>
                            <option value="unpaid"  @isset($payment_status) @if($payment_status == 'unpaid') selected @endif @endisset>{{__('Un-Paid')}}</option>
                        </select>
                    </div>
                </div>
                <div class="box-inline pad-rgt pull-left">
                    <div class="select" style="min-width: 300px;">
                        <select class="form-control demo-select2" name="delivery_status" id="delivery_status" onchange="sort_orders()">
                            <option value="">{{__('Filter by Deliver Status')}}</option>
                            <option value="pending"   @isset($delivery_status) @if($delivery_status == 'pending') selected @endif @endisset>{{__('Pending')}}</option>
                            <option value="ready_to_ship"   @isset($delivery_status) @if($delivery_status == 'ready_to_ship') selected @endif @endisset>{{__('Ready to ship')}}</option>
                            <option value="shipped"   @isset($delivery_status) @if($delivery_status == 'shipped') selected @endif @endisset>{{__('Shipped')}}</option>
                            <option value="delivered"   @isset($delivery_status) @if($delivery_status == 'delivered') selected @endif @endisset>{{__('Delivered')}}</option>
                            <option value="cancelled" @isset($delivery_status) @if($delivery_status == 'cancelled') selected @endif @endisset>{{__('Cancelled')}}</option>
                            <option value="returned" @isset($delivery_status) @if($delivery_status == 'returned') selected @endif @endisset>{{__('Returned')}}</option>
                            <option value="failed_delivery" @isset($delivery_status) @if($delivery_status == 'failed_delivery') selected @endif @endisset>{{__('Failed Delivery')}}</option>
                            <option value="refund_only" @isset($delivery_status) @if($delivery_status == 'refund_only') selected @endif @endisset>{{__('Refund Only')}}</option>
                        </select>
                    </div>
                </div>
                <div class="box-inline pad-rgt pull-left">
                    <div class="" style="min-width: 200px;">
                        <input type="text" class="form-control" id="search" on="search_orders()" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="Type Order code & hit Enter">
                    </div>
                </div>
                
            </form>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-striped demo-dt-basic mar-no" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order Code</th>
                    <th>Num. of Products</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Delivery Status</th>
                    <th>Payment Status</th>
                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                        <th>Refund</th>
                    @endif
                    <th>Status</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order_id)
                    @php
                        $order = \App\Order::find($order_id->id);
                    @endphp
                    <tr>
                        <td>
                            {{ ($key+1) }}
                        </td>
                        <td>
                            {{ $order->code }}
                        </td>
                        <td>
                            {{ count($order->orderDetails) }}
                        </td>
                        <td>
                            @if ($order->user != null)
                                {{ $order->user->name }}
                            @else
                                Guest ({{ $order->guest_id }})
                            @endif
                        </td>
                        <td>
                            {{ single_price($order->grand_total) }}
                        </td>
                        
                        <td>
                                <!--$status = 'Delivered';-->
                                <!--foreach ($order->orderDetails as $key => $orderDetail) {-->
                                <!--    if($orderDetail->delivery_status != 'delivered'){-->
                                <!--        $status = 'Pending';-->
                                <!--    }-->
                                <!--    if($orderDetail->delivery_status == 'cancelled'){-->
                                <!--        $status = 'Cancelled';-->
                                <!--    }-->
                                <!--}-->
                              @php
                                $status = $order->orderDetails->first()->delivery_status;
                            @endphp
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                          
                          
                        </td>
                        <td>
                            <span class="badge badge--2 mr-4">
                                @if ($order->payment_status == 'paid')
                                    <i class="bg-green"></i> Paid
                                @else
                                    <i class="bg-red"></i> Unpaid
                                @endif
                            </span>
                        </td>
                        @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                            <td>
                                @if (count($order->refund_requests) > 0)
                                    {{ count($order->refund_requests) }} Refund
                                @else
                                    No Refund
                                @endif
                            </td>
                        @endif
                        <td><label class="switch">
                                <input onchange="update_status(this)" value="{{ $order->id }}" type="checkbox" <?php if($order->status == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" style="overflow: scroll;max-height: 200px;">
                                    <li><a href="{{route('sales.show', encrypt($order->id))}}">{{__('View')}}</a></li>
                                    <li><a href="{{ route('customer.invoice.download', $order->id) }}">{{__('Download Invoice')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('orders.destroy_id', $order->id)}}');">{{__('Delete')}}</a></li>
                                    <li><a href="{{route('orders.update-order-status', ['status' => 'pending', 'id' => $order->id])}}">{{__('Pending Order')}}</a></li>
                                    <li><a href="{{route('orders.update-order-status', ['status' => 'ready_to_ship', 'id' => $order->id])}}">{{__('Ready to ship Order')}}</a></li>
                                    <li><a href="{{route('orders.update-order-status', ['status' => 'shipped', 'id' => $order->id])}}">{{__('Shipped Order')}}</a></li>
                                    <li><a href="{{route('orders.update-order-status', ['status' => 'delivered', 'id' => $order->id])}}">{{__('Delivered Order')}}</a></li>
                                    <li><a href="{{route('orders.update-order-status', ['status' => 'cancelled', 'id' => $order->id])}}">{{__('Cancel Order')}}</a></li>
                                    <li><a href="{{route('orders.update-order-status', ['status' => 'returned', 'id' => $order->id])}}">{{__('Returned Order')}}</a></li>
                                    <li><a href="{{route('orders.update-order-status', ['status' => 'failed_delivery', 'id' => $order->id])}}">{{__('Failed Delivery Order')}}</a></li>
                                    <li><a href="{{route('orders.update-order-status', ['status' => 'refund_only', 'id' => $order->id])}}">{{__('Refund Only Order')}}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>

@endsection


@section('script')
    <script type="text/javascript">
    
        $.fn.datepicker.defaults.format = "dd-mm-yyyy";
            $('.input-daterange input').each(function() {
            $(this).datepicker('clearDates');
        });
        function search_orders(el){
            $('#sort_orders').submit();
        }
        function sort_orders(el){
            $('#sort_orders').submit();
        }
        function date_orders(el){
            $('#sort_orders').submit();
        }

         function update_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('order.status.update') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Order status updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }


    </script>
@endsection
