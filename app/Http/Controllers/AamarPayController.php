<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AamarPayController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $order = Order::findOrFail(Session::get('order_id'));
        
        $url = 'https://sandbox.aamarpay.com/request.php'; // live url https://secure.aamarpay.com/request.php

        $fields = array(
            'store_id' => 'aamarpaytest', //store id will be aamarpay,  contact integration@aamarpay.com for test/live id
            'amount' => '200', //transaction amount
            'payment_type' => 'VISA', //no need to change
            'currency' => 'BDT',  //currenct will be USD/BDT
            'tran_id' => uniqid(), //transaction id must be unique from your end
            'cus_name' => $user->name ?? "Customer Name",  //customer name
            'cus_email' => $user->email ?? "customeremail@mail.com", //customer email address
            'cus_add1' => $user->address ?? "Customer Address",  //customer address
            'cus_add2' => '', //customer address
            'cus_city' => $user->city ?? "Customer City",  //customer city
            'cus_state' => $user->city ?? "State",  //state
            'cus_postcode' => $user->postal_code ?? "N/A", //postcode or zipcode
            'cus_country' => $user->country ?? "Customer Country",  //country
            'cus_phone' => $user->phone ?? "Customer Phone", //customer phone number
            'cus_fax' => 'Not¬Applicable',  //fax
            'ship_name' => 'ship name', //ship name
            'ship_add1' => session()->get('shipping_info')['address'],  //ship address
            'ship_add2' => '',
            'ship_city' => session()->get('shipping_info')['city'],
            'ship_state' => session()->get('shipping_info')['area'],
            'ship_postcode' => session()->get('shipping_info')['area'],
            'ship_country' => session()->get('shipping_info')['country'],
            'desc' => 'Payment for Order: ' . $order->id,
            'success_url' => route('order_confirmed'), //your success route
            'fail_url' => route('home'), //your fail route
            'cancel_url' => route('home'), //your cancel route
            'opt_a' => '',  //optional paramter
            'opt_b' => '',
            'opt_c' => '',
            'opt_d' => '',
            'signature_key' => 'dbb74894e82415a2f7ff0ec3a97e4183'
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
    }

    function redirect_to_merchant($url)
    {
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

            <form name="redirectpost" method="post" action="<?php echo 'https://sandbox.aamarpay.com/' . $url; ?>"></form>
            <!-- for live url https://secure.aamarpay.com -->
        </body>

        </html>
<?php
        exit;
    }

    public function success(Request $request)
    {
        return $request->input('mer_txnid');
    }

    public function fail(Request $request)
    {
        return $request->all();
    }
}
