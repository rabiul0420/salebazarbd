<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use Auth;
use DB;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $conditions = ['user_id'=> Auth::user()->id];

        if($request->search != null){
            $conditions = array_merge($conditions, ['code' => $request->search]);
        }
       
        // if($request->status != null && $request->status != 'pending'){
        //     $conditions = array_merge($conditions, ['delivery_status' => $request->status]);
        // }
        

        $orders = Order::where($conditions);
        
        $delivery_status = null;
        if($request->status != null){
            $delivery_status = $request->status; 
           
            $orders = $orders->whereHas('orderDetails', function($query) use($request){
               $query->where('delivery_status', $request->status);
            });

        }
        // dd($orders);
       //  if($request->start != null){
       //     $orders = $orders->whereDate('created_at', '>=' , $request->start);
       //  }
       // if($request->end != null){
       //     $orders = $orders->whereDate('created_at', '>=' , $request->end);
       //  }

        $orders = $orders->orderBy('code', 'desc')->paginate(9);

        return view('frontend.purchase_history', compact('orders', 'delivery_status'));
    }

    public function digital_index()
    {

        $orders = DB::table('orders')
                        ->orderBy('code', 'desc')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->join('products', 'order_details.product_id', '=', 'products.id')
                        ->where('orders.user_id', Auth::user()->id)
                        ->where('products.digital', '1')
                        ->where('order_details.payment_status', 'paid')
                        ->select('order_details.id')
                        ->paginate(1);
        return view('frontend.digital_purchase_history', compact('orders'));
    }

    public function purchase_history_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = 1;
        $order->payment_status_viewed = 1;
        $order->save();
        return view('frontend.partials.order_details_customer', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
