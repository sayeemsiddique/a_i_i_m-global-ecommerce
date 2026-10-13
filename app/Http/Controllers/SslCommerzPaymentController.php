<?php

namespace App\Http\Controllers;

use App\Mail\AuthorNewOrder;
use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Crypt;
use App\Models\Cart;
use App\Models\ShippingAddress;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Permission;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        $tracking_code = date("yhis");




        if (count($request->cart_id) == 0) {
            return back()->with('error', "Your cart is empty");
        }

        $productIds = [];

        foreach ($request->cart_id as $key => $cartId) {
            $productIds[$key] = Crypt::decryptString($cartId);
        }

        $carts = Cart::where('user_id', auth()->user()->id)->whereIn('id',$productIds)->with('productInfo','varientInfo')->latest()->get();

        if (count($carts) == 0) {
            return back()->with('error', "Your cart is empty");
        }

        if (($request->store_delivery_option ?? 0) != 3) {
            $shipping_address = ShippingAddress::where('id', $request->shipping_address)->where('user_id', auth()->user()->id)->latest()->first();
            if (!$shipping_address) {
                return back()->with('error', "Shipping address not found");
            }
            $request->store_id = 0;
        } else {
            $shipping_address = null;
        }

        $product_total_price = 0; // total sale price
        $product_before_discount = 0;
        foreach ($carts as $key => $cart) {
            if ($cart->variation_id == 0) {
                $product_total_price +=  $cart->cartProductPrice() * $cart->quantity;
                $product_before_discount +=  ($cart->productInfo->price ?? 0)  * $cart->quantity;
            } else {
                $product_total_price +=  $cart->cartProductPrice() * $cart->quantity;
                $product_before_discount +=  ($cart->varientInfo->price ?? 0)  * $cart->quantity;
            }
        }

        $voucher = Voucher::where('code', $request->voucher_discount_amount_code)->first();
        $voucher_discount = $voucher ? round($voucher->applyDiscount($product_total_price) ?? 0) : 0;


        // if (!auth()->user()->email) {
        //     return back()->with('error', "Please set your email address before Pay With SSLCOMMERZ Gateway");
        // }

        $order_data['tracking_code'] = $tracking_code;
        $order_data['transaction_id'] = $tracking_code;
        $order_data['user_id'] = auth()->user()->id;
        $order_data['status'] = 3;
        $order_data['payment_status'] = 1;
        // $order_data['total_price'] = round($product_total_price) - round($voucher_discount);
        $order_data['total_price'] = round($product_total_price);
        $order_data['grand_total_price'] = round($product_total_price) + round($shipping_address->divisionInfo->shipping_cost ?? 0) - round($voucher_discount);
        $order_data['discount_amount'] = 0;
        // $order_data['coupon_discount'] = 0;
        $order_data['shipping_cost'] = round($shipping_address->divisionInfo->shipping_cost ?? 0);
        $order_data['type'] = 2;
        $order_data['vat'] = $request->vat ?? 0;
        $order_data['tax'] = $request->tax ?? 0;
        $order_data['shipping_address'] = $request->shipping_address ?? "";
        $order_data['ship_different_address'] = 0;
        $order_data['delivery_status'] = 0;
        $order_data['shipping_area'] = $request->shipping_area ?? 0;
        // $order_data['personal_vehicle'] = $request->personal_vehicle ?? 0;
        $order_data['delivery_option'] = $request->delivery_option ?? 0;


        $post_data = array();
        $post_data['total_amount'] = $order_data['grand_total_price']; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $tracking_code; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = ''.auth()->user()->first_name . ' ' . auth()->user()->last_name.'';
        $post_data['cus_email'] = auth()->user()->email ?? 'nomail@mail.com';
        $post_data['cus_add1'] = $shipping_address->address ?? '';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = ''.auth()->user()->mobile.'';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = ''.auth()->user()->first_name . ' ' . auth()->user()->last_name.'';
        $post_data['ship_add1'] = "".($shipping_address->divisionInfo->name ?? '')."";
        $post_data['ship_add2'] = "".($shipping_address->districtInfo->name ?? '')."";
        $post_data['ship_city'] = "".($shipping_address->divisionInfo->name ?? '')."";
        $post_data['ship_state'] = "".($shipping_address->divisionInfo->name ?? '')."";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = ''.($shipping_address->phone_no ?? '').'';
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = auth()->user()->id;
        $post_data['value_b'] = implode(',', $productIds);
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";



        $order_data['created_at'] = now();
        $order_data['updated_at'] = now();
        $order_data['update_by'] = auth()->user()->id;
        $order_data['voucher_type'] = $voucher->type ?? '';
        $order_data['voucher_value'] = $voucher->value ?? 0;
        $order_data['voucher_discount'] = round($voucher_discount);
        $order_data['voucher_id'] = $voucher->id ?? 0;
        $order_data['voucher_code'] = $voucher->code ?? '';
        $order_data['store_id'] = $request->store_id ?? 0;


        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where([
                'transaction_id' => $post_data['tran_id'],
                'user_id' => auth()->user()->id
            ])
            ->updateOrInsert($order_data);
            // ->updateOrInsert([
            //     // 'name' => $post_data['cus_name'],
            //     // 'email' => $post_data['cus_email'],
            //     // 'phone' => $post_data['cus_phone'],
            //     'grand_total_price' => $post_data['total_amount'],
            //     'status' => 3,
            //     // 'address' => $post_data['cus_add1'],
            //     'transaction_id' => $post_data['tran_id'],
            //     // 'currency' => $post_data['currency']
            // ]);

        $sslc = new SslCommerzNotification();
        // dd($sslc);
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');
        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        echo "Transaction is Successful";
        // dd($request->all());
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $user_id = $request->input('value_a');
        $cart_ids = $request->input('value_b');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order = Order::where([
                'transaction_id' => $tran_id,
                'user_id' => $user_id
            ])->first();
// dd($tran_id);
// dd($user_id);
        // if ($order->status == 'Pending') {
        if ($order) {

            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where([
                        'transaction_id' => $tran_id,
                        'user_id' => $user_id
                    ])
                    ->update([
                        'status' => 0,
                        'payment_status' => 2,
                    ]);

                DB::transaction(function () use ($request,$cart_ids,$order,$user_id) {
                    $data = $request->all();

                    $carts = Cart::where('user_id', auth()->user()->id)->whereIn('id',explode(',',$cart_ids))->with('productInfo','varientInfo')->latest()->get();

                    if ($order->store_id == 0) {
                        $shipping_address = ShippingAddress::where('id', $order->shipping_address)->where('user_id', $user_id)->latest()->first();
                        if (!$shipping_address) {
                            echo "Invalid shipping address";
                            // return back()->with('error', "Shipping address not found");
                        }
                    }

                    if (count($carts) == 0) {
                        echo "Invalid shipping address";
                        // return back()->with('error', "Your cart is empty");
                    }

                    $product_total_price = 0; // total sale price
                    $product_before_discount = 0;
                    foreach ($carts as $key => $cart) {
                        if ($cart->variation_id == 0) {
                            $product_total_price +=  $cart->cartProductPriceOnTime($order->created_at) * $cart->quantity;
                            $product_before_discount +=  ($cart->productInfo->price ?? 0)  * $cart->quantity;
                        } else {
                            $product_total_price +=  $cart->cartProductPriceOnTime($order->created_at) * $cart->quantity;
                            $product_before_discount +=  ($cart->varientInfo->price ?? 0)  * $cart->quantity;
                        }
                    }

                    foreach ($carts as $key => $cart) {
                        $order_detail['order_id'] = $order->id;
                        $order_detail['product_id'] = $cart->product_id;
                        $order_detail['quantity'] = $cart->quantity;
                        $order_detail['varient_id'] = $cart->variation_id;
                        $order_detail['campaign_details_id'] = $cart->getProductInCampaignOnTime($order->created_at)->id ?? 0;

                        if ($cart->variation_id == 0){
                            $order_detail['f_price'] = $cart->productInfo->price ?? 0;
                            $order_detail['price'] = $cart->cartProductPriceOnTime($order->created_at);
                            $order_detail['discount'] = $cart->productInfo->discount ?? 0;
                            $order_detail['discount_type'] = $cart->productInfo->discount_type ?? 0;
                        } else {
                            $order_detail['f_price'] = $cart->varientInfo->price ?? 0;
                            $order_detail['price'] = $cart->cartProductPriceOnTime($order->created_at);
                            $order_detail['discount'] = $cart->varientInfo->discount ?? 0;
                            $order_detail['discount_type'] = $cart->varientInfo->discount_type ?? 0;
                        }

                        if ($cart->getProductInCampaignOnTime($order->created_at)) {
                            // than overight the discount info
                            $campaign_info = $cart->getProductInCampaignOnTime($order->created_at);
                            $order_detail['discount'] = $campaign_info->discount;
                            $order_detail['discount_type'] = $campaign_info->discount_type;
                        }

                        OrderDetail::create($order_detail);
                    }

                    $payment_data['user_id'] = $user_id;
                    $payment_data['order_id'] = $order->id;
                    $payment_data['amount'] = $order->grand_total_price;
                    $payment_data['payment_method'] = 2; // 1 = cash on delivery, 2 = bkash, 3 = online payment
                    // $payment_data['bank_id'] = $request->bank_id ?? "";

                    $payment_data['status'] = 2;
                    $payment_data['type'] = 1;
                    $payment_data['created_by'] = $user_id;

                    Payment::create($payment_data);

                    // Cart::where('user_id', auth()->user()->id)->delete();
                    Cart::where('user_id', $user_id)->whereIn('id',explode(',',$cart_ids))->delete();

                    if(auth()->user()->mobile != ''){
                        $data['number'] = auth()->user()->mobile;
                        $data['message'] = 'Your Order has been placed at Sneho Digital, your order Tracking ID: '.$order->transaction_id;
                        // app('App\Http\Controllers\FrontendController')->sms_send($data);
                        $this->sms_send($data);
                    }

                    $mail_permission = Permission::where('name_en','author_get_new_order_mail')->first();

                    if ($mail_permission) {
                        $mail_users = User::whereHas('role', function ($query) use ($mail_permission) {
                            $query->whereHas('permissions', function ($new_query) use ($mail_permission) {
                                $new_query->where('permission_id', $mail_permission->id);
                            });
                        })->where('status',1)->get();
                        // dd($order);
                        foreach ($mail_users as $key => $mail_user) {
                            if ($mail_user->email) {
                                Mail::to($mail_user->email)->send(new AuthorNewOrder($order,$mail_user));
                            }
                        }
                    }

                });

                return redirect()->route('account_orders')->with('success', "Transaction is successfully Completed");
            }
        // } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            // echo "Transaction is successfully Completed";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            // echo "Invalid Transaction";
            return redirect()->route('account_orders')->with('success', "Invalid Transaction");
        }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $user_id = $request->input('value_a');

        DB::table('orders')
            ->where([
                'transaction_id' => $tran_id,
                'user_id' => $user_id,
                // 'status' => 3,
            ])->delete();

        return redirect()->route('checkout')->with('error', "Transaction is Failed");

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $user_id = $request->input('value_a');

        DB::table('orders')
            ->where([
                'transaction_id' => $tran_id,
                'user_id' => $user_id,
                // 'status' => 3,
            ])->delete();

        // if ($order_details->status == 'Pending') {
        //     $update_product = DB::table('orders')
        //         ->where('transaction_id', $tran_id)
        //         ->update(['status' => 'Canceled']);
        //     echo "Transaction is Cancel";
        // } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
        //     echo "Transaction is already Successful";
        // } else {
        //     echo "Transaction is Invalid";
        // }
        return redirect()->route('checkout')->with('error', "Transaction is Failed");

    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');
            $user_id = $request->input('value_a');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where([
                    'transaction_id' => $tran_id,
                    'user_id' => $user_id
                ])->first();

            if ($order_details) {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->grand_total_price, $order_details->currency);
                if ($order_details->status == 3) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    // $update_product = DB::table('orders')
                    //     ->where('transaction_id', $tran_id)
                    //     ->update(['status' => 0]);

                    echo "Transaction still incomplete";
                }
            } else if ($order_details->status == 1 || $order_details->status == 2) {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

    public function sms_send($data)
    {
        $url = "http://bulksmsbd.net/api/smsapi";
        $api_key = "y3FfVATWkcvMDn67cNkp";
        $senderid = "8809617611033";
        $number = $data['number'];
        $message = $data['message'];

        $data = [
            "api_key" => $api_key,
            "senderid" => $senderid,
            "number" => $number,
            "message" => $message
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

}
