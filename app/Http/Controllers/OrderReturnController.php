<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Order;
use App\Models\Setting;
use App\Models\OrderReturn;
use App\Models\Inventory;
use App\Models\OrderReturnDetail;
use App\Models\Stock;
use App\Models\OrderDetail;
use App\Models\Payment;
use Auth;
use Illuminate\Support\Facades\Crypt;

class OrderReturnController extends Controller
{
    // order return
    public function order_return(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('order_return', $user))
        {
            menuSubmenu('manage_order', 'order_return');

            $order = null;

            $setting = Setting::oldest()->first();

            if (isset($request->order_id) and $request->order_id !="") {
                $order = Order::where('type',2)->where('tracking_code',$request->order_id)->latest()->first();
                if (!$order) {
                    return redirect()->route('admin.order.order_return')->with('error','Order not found.');
                }

                $return_status= $order->status;

                if ($order->status == 5) {
                    return redirect()->route("admin.order.order_return")->with('error','This order already returned.');
                }
            }

            return view('backend.admin.order.order_return', compact('order','setting'));

        }
        else
        {
            abort(403);
        }
    }

    public function order_return_confirm(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('order_return', $user))
        {

            $order = Order::where('id',$request->order_id)->latest()->first();

            dd($request->all());

            if (!$order) {
                return redirect()->route("admin.order.index")->with('error','Order not fount');
            }
            // if ($order->status == 5) {
            //     return redirect()->route("admin.order.index")->with('error','Order alredy returned');
            // }

            if (isset($request->whole_return) and $request->whole_return == 1) {


                $this->whole_order_return_confirm($request);

                return redirect()->route("admin.order.index")->with('success','Whole order has been returned for order: '.$order->tracking_code);

            } else {

                if (isset($request->qty) and count($request->qty) == 0) {
                    return redirect()->back()->with('error','Return quantity is required.');
                }

                foreach ($request->qty as $key => $qty) {
                    $check_previous_returns_quantity = OrderReturnDetail::where([
                        'order_id' => $order->id,
                        'order_detail_id' => $key,
                    ])->sum('quantity');

                    if ($check_previous_returns_quantity > 0) {
                        $order_detail = OrderDetail::where('id',$key)->latest()->first();

                        if($order_detail) {
                            $available_quantity = $order_detail->quantity - $check_previous_returns_quantity;

                            if ($available_quantity < 0) {
                                return redirect()->back()->with('error','No available quantity to return for product: '.$order_detail->productInfo->name);
                            }
                            if ($qty > $available_quantity) {
                                return redirect()->back()->with('error','Return quantity can not be more than available quantity to return for product: '.$order_detail->productInfo->name);
                            }
                        } else {
                            return redirect()->back()->with('error','Order detail not found.');
                        }
                    }

                }

                $order_return_data_detail = [];
                $order_total_price = 0;




                foreach ($request->product_id as $key => $product_id) {
                    if ($request->qty[$key] > 0) {

                        $order_detail = OrderDetail::where('id',$request->order_details_id[$key])->latest()->first();

                        if($order_detail) {
                            if($order_detail->quantity > 0) {
                                $order_detail->quantity = $request->qty[$key];
                                $order_total_price += $order_detail->price * $request->qty[$key];
                                $order_return_data_detail[]  = $order_detail->toArray();
                            }

                        }
                    }
                }

                $data["order_id"] = $order->id;
                $data["type"] = 2;
                $data["tracking_code"] = $order->tracking_code;
                $data["status"] = 1;
                $data["payment_status"] = 1;
                $data["total_price"] = $order_total_price;
                $data["grand_total_price"] = $order_total_price;
                $data["user_type_discount"] = $order->user_type_discount;
                $data["discount_amount"] = 0;
                $data["shipping_cost"] = 0;
                $data["packing_type"] = $order->packing_type;
                $data["packing_amount"] = 0;
                $data["courier_cost"] = 0;
                $data["discount_percent_in_total"] = 0;
                $data["discount_amount_in_total"] = 0;
                $data["discount_on_amount"] = 0;
                $data["remark"] = $request->remark;
                $data["created_by"] = auth()->user()->id;
                $data["user_id"] = $order->user_id;

                DB::transaction(function () use ($request,$data) {

                    $OrderReturn = OrderReturn::create($data);
                    foreach ($order_return_data_detail as $key => $order_return_data_details) {
                        unset($order_return_data_details['variation']);
                        unset($order_return_data_details['update_by']);
                        unset($order_return_data_details['id']);
                        $order_return_data_details['order_id'] = $order->id;
                        $order_return_data_details['return_order_id'] = $OrderReturn->id;
                        OrderReturnDetail::create($order_return_data_details);

                        Stock::where([
                            'varient_id' => $order_return_data_details['varient_id'],
                            'product_id' => $order_return_data_details['product_id'],
                        ])->increment('quantity', $order_return_data_details['quantity']);
                    }

                    foreach ($request->product_id as $key => $product_id) {
                        if ($request->qty[$key] > 0) {
                            $order_details_datas = OrderDetail::where('id',$request->order_details_id[$key])->latest()->first();

                            if($order_details_datas) {
                                if($order_details_datas->quantity > 0) {
                                    $order_detail_data['quantity'] = $order_details_datas->quantity - $request->qty[$key];

                                    $order_details_datas->update($order_detail_data);
                                }

                            }
                        }
                    }

                    $Return['invoice_no'] = sprintf('%08d', $OrderReturn->id);
                    $OrderReturn->update($Return);

                    $payment_data['amount'] = $order_total_price;
                    $payment_data['type'] = 2;
                    $payment_data['user_id'] = $order->user_id;
                    $payment_data['order_id'] = $order->id;
                    $payment_data['payment_approved'] = 1;
                    $payment_data['status'] = 1;
                    $payment_data['created_by'] = auth()->user()->id;

                    Payment::create($payment_data);

                    $update_order_data['return_status'] = 1;
                    $update_order_data['return_amount'] = $order->return_amount + $order_total_price;
                    $update_order_data['returned_amount'] = 0;
                    $update_order_data['total_price'] = $order->total_price - $order_total_price;
                    $update_order_data['grand_total_price'] = $order->grand_total_price - $order_total_price;

                    $order->update($update_order_data);

                });


                return redirect()->route("admin.order.index")->with('success','Quantity has been returned for order: '.$order->tracking_code);
            }

        }
        else
        {
            abort(403);
        }
    }

    public function whole_order_return_confirm(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('order_return', $user))
        {
            DB::transaction(function () use ($request) {

            $order = Order::where('id',$request->order_id)->latest()->first();




                $data = $order;
                $data = $data->toArray();
                $data['order_id'] = $order->id;
                $data['status'] = 1;
                $data['payment_status'] = 1;
                unset($data['id']);
                unset($data['email']);
                unset($data['phone']);
                unset($data['ship_different_address']);
                unset($data['delivery_status']);
                unset($data['coupon_discount']);
                unset($data['personal_vehicle']);
                unset($data['code']);
                unset($data['stage']);
                unset($data['return_status']);
                unset($data['replace_status']);
                unset($data['vat']);
                unset($data['tax']);
                unset($data['update_by']);
                unset($data['return_amount']);
                unset($data['returned_amount']);

                $OrderReturn = OrderReturn::create($data);

                $Return['invoice_no'] = sprintf('%08d', $OrderReturn->id);
                $OrderReturn->update($Return);

                if (isset($request->order_details_id) and $request->order_details_id != '') {
                    foreach ($request->order_details_id as $key => $order_details_id) {
                        $order_detrail = OrderDetail::where('id',$order_details_id)->latest()->first();
                        if ($order_detrail) {
                            $return_order_detrail = $order_detrail->toArray();
                            $return_order_detrail['return_order_id'] = $return_order_detrail['order_id'];
                            unset($return_order_detrail['variation']);
                            unset($return_order_detrail['update_by']);

                            OrderReturnDetail::create($return_order_detrail);

                            $order_detrail_data['quantity'] = 0;
                            $order_detrail->update($order_detrail_data);


                            Stock::where([
                                'varient_id' => $return_order_detrail['varient_id'],
                                'product_id' => $return_order_detrail['product_id'],
                            ])->increment('quantity', $return_order_detrail['quantity']);
                        }

                    }

                }

                $inventory_data = Inventory::where([
                    'order_id' => $request->order_id,
                    'type' => 2
                ])->get();

                foreach ($inventory_data as $inventoryData) {
                    $new_inventory = $inventoryData->toArray();
                    $new_inventory['type'] = 6;
                    Inventory::create($new_inventory);
                }

                $payment_amount  = Payment::where([
                    'type' => 1,
                    'order_id' => $request->order_id
                ])->get();

                if (count($payment_amount) > 0) {
                    $total_payment_amount = $payment_amount->sum("amount");
                } else {
                    $total_payment_amount = $order->grand_total_price;
                }

                $update_order_data['return_status'] = 1;
                $update_order_data['status'] = 5;
                $update_order_data['return_amount'] = $total_payment_amount;
                $update_order_data['returned_amount'] = 0;

                $order->update($update_order_data);



                $payment_data['amount'] = $total_payment_amount;
                $payment_data['type'] = 2;
                $payment_data['user_id'] = $order->user_id;
                $payment_data['order_id'] = $order->id;
                $payment_data['payment_approved'] = 1;
                $payment_data['status'] = 1;
                $payment_data['created_by'] = auth()->user()->id;

                Payment::create($payment_data);


            return redirect()->route("admin.order.index")->with('success','Whole order has been returned for order: '.$order->tracking_code);
        });

        }
        else
        {
            abort(403);
        }
    }

    public function order_return_list(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('order_return_list', $user))
        {
            menuSubmenu('manage_order', 'order_return_list');

            $query = OrderReturn::latest();

            if(isset($request->fromDate) and $request->fromDate != '') {
                $query->whereDate('created_at', '>=',$request->fromDate);
            }

            if(isset($request->toDate) and $request->toDate != '') {
                $query->whereDate('created_at', '>=',$request->toDate);
            }

            if(isset($request->order_id) and $request->order_id != '') {
                $query->where('tracking_code', 'like','%'.$request->order_id.'%');
            }

            // if(isset($request->type) and $request->type != '') {
            //     $query->whereHas('userInfo',function ($new_query) use ($request) {
            //         $new_query->where('type',$request->type);
            //     });
            // }
            $orders = $query->paginate(20);
            $setting = Setting::oldest()->first();

            return view('backend.admin.order.order_return_list', compact('orders','setting'));

        }
        else
        {
            abort(403);
        }
    }

    public function order_return_show($id)
    {
        menuSubmenu('manage_order', 'order_return_list');
        $id = Crypt::decryptString($id);

        // $order = Order::where('id',$id)->latest()->first();
        $orderReturn = OrderReturn::where('id',$id)->latest()->first();
        $setting = Setting::oldest()->first();
        $payment = Payment::where('order_id', $id)->first();

        return view('backend.admin.order.order_return_show', compact('orderReturn', 'setting', 'payment'));
    }
}
