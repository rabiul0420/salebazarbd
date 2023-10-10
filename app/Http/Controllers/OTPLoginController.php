<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use App\User;
use Auth;
use Nexmo;
use App\OtpConfiguration;
use Twilio\Rest\Client;
use Hash;

class OTPLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verification(Request $request){
        
            return view('otp_systems.frontend.user_verification');
        // }
        // else {
        //     flash('You have already verified your number')->warning();
        //     return redirect()->route('home');
        // }
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function verify_phone(Request $request){
        $user = Auth::user();
        if ($user->verification_code == $request->verification_code) {
            $user->email_verified_at = date('Y-m-d h:m:s');
            $user->save();

            flash('Your phone number has been verified successfully')->success();
            return redirect()->route('home');
        }
        else{
            flash('Invalid Code')->error();
            return back();
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function resend_verificcation_code(Request $request){
        $user = User::findOrFail($request->status);
        $user->verification_code = rand(100000,999999);
        $user->save();

        sendSMS($user->phone, env("APP_NAME"), $user->verification_code.' is your verification code for '.env('APP_NAME'));

        return 1;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function reset_password_with_code(Request $request){
        if (($user = User::where('phone', $request->phone)->where('verification_code', $request->code)->first()) != null) {
            if($request->password == $request->password_confirmation){
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                auth()->login($user, true);

                if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')
                {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            }
            else {
                flash("Password and confirm password didn't match")->warning();
                return back();
            }
        }
        else {
            flash("Verification code mismatch")->error();
            return back();
        }
    }

    /**
     * @param  User $user
     * @return void
     */

    public function send_code($user){
        // dd($user->verification_code);
        sendSMS($user->phone, env('APP_NAME'), $user->verification_code.' is your verification code for '.env('APP_NAME'));
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function send_order_code($order){
        if(json_decode($order->shipping_address)->phone != null){
            sendSMS(json_decode($order->shipping_address)->phone, env('APP_NAME'), 'You order has been placed and Order Code is : '.$order->code);
        }
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function send_delivery_status($order){
        if(json_decode($order->shipping_address)->phone != null){
            sendSMS(json_decode($order->shipping_address)->phone, env('APP_NAME'), 'Your delivery status has been updated to '.$order->orderDetails->first()->delivery_status.' for Order code : '.$order->code);
        }
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function send_payment_status($order){
        if(json_decode($order->shipping_address)->phone != null){
            sendSMS(json_decode($order->shipping_address)->phone, env('APP_NAME'), 'Your payment status has been updated to '.$order->payment_status.' for Order code : '.$order->code);
        }
    }

    public function sendtest(Request $request){
        $post_url = "https://login.smsinbd.com/api/send-sms" ;  
                  
                $post_values = array( 
                'api_token' => 'mESvXiklsEKsUPAw2lUOgYVkP4EIizxac0MUPYng',
                'senderid' => '01777333675',
                'contact_number' => '01912211825',
                'message' => 'Hello world',
                );
                
                $post_string = "";
                foreach( $post_values as $key => $value )
                    { $post_string .= "$key=" . urlencode( $value ) . "&"; }
                   $post_string = rtrim( $post_string, "& " );
                  
                $request = curl_init($post_url);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);  
                    curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); 
                    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);  
                    $post_response = curl_exec($request);  
                   curl_close ($request);  
                  
                $responses=array();         
                 $array =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $post_response), true );   
                 
                if($array){ 
                 echo $array['status'] ;
                 
                 echo $array['CamID'] ;
                 
                 print_r($array);
                }

    }
}
