<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nexmo;
use Twilio\Rest\Client;
use App\OtpConfiguration;
use App\User;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$users = User::all();
        return view('otp_systems.sms.index',compact('users'));
    }

    //send message to multiple users
    public function send(Request $request)
    {
        foreach ($request->user_phones as $key => $phone) {
            sendSMS($phone, env('APP_NAME'), $request->content);
        }

    	flash(__('SMS has been sent.'))->success();
    	return redirect()->route('admin.dashboard');
    }

    public function sendtest(Request $request){
        
        $rr=implode("|",$request->user_phones);

        // $yy="https://login.smsinbd.com/api/send-sms?api_token=mESvXiklsEKsUPAw2lUOgYVkP4EIizxac0MUPYng&senderid=Albeen.com&message=Hello%20world%202&contact_number=01912211825";
        // dd($yy);

            $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://login.smsinbd.com/api/send-sms?api_token=mESvXiklsEKsUPAw2lUOgYVkP4EIizxac0MUPYng&senderid=Albeen.com&message=Hello%20world%202&contact_number=01912211825",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  
));

$response = curl_exec($curl);

curl_close($curl);
dd($response);


    }
}
