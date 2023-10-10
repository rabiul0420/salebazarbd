<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Subscriber;
use App\Notice;
use Mail;
use App\Mail\EmailManager;
use Auth;
class NoticeController extends Controller
{
    public function index(Request $request)
    {
    
        $notice = Notice::latest()->first();
    	return view('notice.index', compact('notice'));
    }

    public function send(Request $request)
    {
        if($request->show_hide == "on" || !empty($request->show_hide)){
            $show = "1";
        }else{
             $show = "0";
        }
        if($request->only_customer == "on" || !empty($request->only_customer)){
            $only_customer = "1";
        }else{
             $only_customer = "0";
        }
        if($request->only_seller == "on" || !empty($request->only_seller)){
            $only_seller = "1";
        }else{
             $only_seller = "0";
        }
      $data =  Notice::where('id','=','1')->first();
      if(empty($data)){
        $notice = new Notice;
        $notice->user_id =Auth::user()->id;
        $notice->title = $request->title;
        $notice->content = $request->content;
         $notice->notice_show = $show;
         $notice->only_seller = $only_seller;
         $notice->only_customer = $only_customer;
        $notice->save();
        flash(__('Notice has been send'))->success();
        return redirect()->route('notice.index');
      }else{
         
          Notice::where('id','=','1')->first()->update(array('title' => $request->title, 'content' => $request->content,'notice_show'=> $show,'only_customer'=> $only_customer,'only_seller'=> $only_seller));
          flash(__('Notice has been Update'))->success();
        return redirect()->route('notice.index');
      }
    }
}
