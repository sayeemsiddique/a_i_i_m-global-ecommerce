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
use Illuminate\Support\Facades\DB;

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
                // $order = Order::where('type',2)->where('tracking_code',$request->order_id)->latest()->first();
                $order = Order::where([
                    // 'user_id' => $user->id,
                    'tracking_code' => $request->order_id,
                    'status' => 1,
                ])->whereIn('delivery_status',[2,3])->latest()->with('orderDetails.returnOrderInfo.orderDetails')->first();
                // if (!$order) {
                //     return redirect()->route('admin.order.order_return')->with('error','Order not found.');
                // }

                // $return_status= $order->status;

                // if ($order->status == 5) {
                //     return redirect()->route("admin.order.order_return")->with('error','This order already returned.');
                // }
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
        // dd($request->all());
        $user = Auth::user();

        if(Gate::allows('order_return', $user))
        {
            $request->validate([
                'order_id' => 'required',
                'reason' => 'required',
            ]);

            if (!isset($request->details_id) or count($request->details_id) == 0) {
                return redirect()->back()->with('error', 'Please select at least one product to return.');
            }

            if ($request->shipping_cost < 0) {
                return redirect()->back()->with('error', 'Shipping Cost can not be negative.');
            }

            $quantity_sum = array_sum($request->details_id);

            if ($quantity_sum <= 0) {
                return redirect()->back()->with('error', 'Please select at least one product to return.');
            }

            $order_id = Crypt::decryptString($request->order_id);

            $order = Order::where('id', $order_id)->first();

            if ($order->status != 1) {
                return redirect()->back()->with('error', 'This order return not possible at this stage');
            }

            if ($order->delivery_status != 3) {
                return redirect()->back()->with('error', 'This order return not possible at this stage');
            }

            foreach ($request->details_id as $detail_id => $quantity) {
                if ($quantity > 0) {
                    $detail_id = Crypt::decryptString($detail_id);
                    $order_detail = OrderDetail::where([
                        'id' => $detail_id,
                    ])->first();

                    if ($order_detail) {
                        if ($order_detail->quantity < $quantity) {
                            return redirect()->back()->with('error', 'Return quantity exceeds ordered quantity for the product.');
                        }
                        $check_already_returned = OrderReturnDetail::where([
                            'order_id' => $order->id,
                            'varient_id' => $order_detail->varient_id,
                            'product_id' => $order_detail->product_id,
                        ])->whereHas('orderReturnInfo', function($q) use ($order) {
                            $q->whereIn('status', [0,1])->where('order_id', $order->id);
                        })->sum('quantity');
                        // dd($check_already_returned);
                        if (($check_already_returned + $quantity) > $order_detail->quantity) {
                            return redirect()->back()->with('error', 'You have already requested return for this product. Return quantity exceeds ordered quantity.');
                        }
                    } else {
                        return redirect()->back()->with('error', 'Order detail not found.');
                    }
                }
            }

            if (($order->status == 0) or $order->delivery_status != 3) {
                return redirect()->back()->with('error', 'Order Return not possible at this stage!');
            }

            $orgin_order_details_quantity = OrderDetail::where([
                'order_id' => $order_id,
            ])->sum('quantity');

            if ($orgin_order_details_quantity < $quantity_sum) {
                return redirect()->back()->with('error', 'Product Return quantity mismatched.');
            }

            DB::transaction(function () use ($request,$order,$user) {

                $voucher_discount = 0;

                $tracking_code = date("yhis");
                $data['tracking_code'] = $tracking_code;
                $data['invoice_no'] = sprintf('%08d', $order->id);;
                $data['order_id'] = $order->id;
                $data['user_id'] = $order->user_id;
                $data['remark'] = $request->reason;
                $data['status'] = 1;
                $data['payment_status'] = $request->payment_status;
                $data['created_by'] = $user->id;

                $data['voucher_type'] = $order->voucher_type ?? '';
                $data['voucher_value'] = $order->voucher_value ?? 0;
                $data['voucher_discount'] = $order->voucher_discount;
                $data['voucher_id'] = $order->voucher_id ?? 0;
                $data['voucher_code'] = $order->voucher_code ?? '';
                $data['shipping_cost'] = $order->shipping_cost ?? 0;
                $data['shipping_area'] = $order->shipping_area ?? 0;
                $data['shipping_address'] = $order->shipping_address ?? 0;

                $return_order = OrderReturn::create($data);

                $grand_total_price = 0;
                foreach ($request->details_id as $detail_id => $quantity) {
                    if ($quantity > 0) {

                        $detail_id = Crypt::decryptString($detail_id);
                        $order_detail = OrderDetail::where([
                            'id' => $detail_id,
                        ])->first();

                        if ($order_detail) {
                            $grand_total_price += round($order_detail->price * $quantity);
                            $return_data['return_order_id'] = $return_order->id;
                            $return_data['order_id'] = $order->id;
                            $return_data['order_detail_id'] = $detail_id;
                            $return_data['product_id'] = $order_detail->product_id;
                            $return_data['varient_id'] = $order_detail->varient_id;
                            $return_data['quantity'] = $quantity;
                            $return_data['price'] = $order_detail->price;
                            $return_data['f_price'] = $order_detail->f_price;
                            $return_data['discount'] = $order_detail->discount;
                            $return_data['discount_type'] = $order_detail->discount_type;
                            $return_data['weight'] = $order_detail->weight;
                            $return_data['unit'] = $order_detail->unit;
                            $return_data['stock_status'] = 1;
                            $return_data['created_by'] = $user->id;

                            OrderReturnDetail::create($return_data);

                            $inventory = new Inventory;
                            $inventory->order_id = $return_order->id;
                            $inventory->type = 6;
                            $inventory->product_id = $order_detail->product_id;
                            $inventory->varient_id = $order_detail->varient_id;
                            $inventory->quantity = $quantity;
                            $inventory->created_by = $user->id;
                            $inventory->save();


                            Stock::where([
                                'varient_id' => $order_detail->varient_id,
                                'product_id' => $order_detail->product_id,
                            ])->increment('quantity', $quantity);

                            // $order_detail->decrement('quantity', $quantity);

                        }
                    }
                }

                if ($order->voucher_id > 0) {
                    if ($order->total_price > 0) {
                        $voucher_discount = ($grand_total_price * ($order->voucher_discount ?? 0)) / $order->total_price;
                    }
                }

                $payment['type'] = 2;
                $payment['order_id'] = $return_order->id;
                $payment['user_id'] = $order->user_id;
                $payment['amount'] = round($grand_total_price - ($voucher_discount + ($order->shipping_cost ?? 0)));
                $payment['payment_method'] = 5;
                $payment['status'] = $request->payment_status;
                $payment['created_by'] = $user->id;
                Payment::create($payment);



                $return_order->voucher_discount = round($voucher_discount);
                $return_order->total_price = round($grand_total_price);
                $return_order->grand_total_price = round($grand_total_price - ($voucher_discount + ($order->shipping_cost ?? 0)));
                $return_order->save();
            });





            return redirect()->back()->with('success', 'Order Return Submitted Successfully!');

            // $order = Order::where('id',$request->order_id)->latest()->first();

            // if (!$order) {
            //     return redirect()->route("admin.order.index")->with('error','Order not fount');
            // }
            // // if ($order->status == 5) {
            // //     return redirect()->route("admin.order.index")->with('error','Order alredy returned');
            // // }

            // if (isset($request->whole_return) and $request->whole_return == 1) {


            //     $this->whole_order_return_confirm($request);

            //     return redirect()->route("admin.order.index")->with('success','Whole order has been returned for order: '.$order->tracking_code);

            // } else {

            //     if (isset($request->qty) and count($request->qty) == 0) {
            //         return redirect()->back()->with('error','Return quantity is required.');
            //     }

            //     foreach ($request->qty as $key => $qty) {
            //         $check_previous_returns_quantity = OrderReturnDetail::where([
            //             'order_id' => $order->id,
            //             'order_detail_id' => $key,
            //         ])->sum('quantity');

            //         if ($check_previous_returns_quantity > 0) {
            //             $order_detail = OrderDetail::where('id',$key)->latest()->first();

            //             if($order_detail) {
            //                 $available_quantity = $order_detail->quantity - $check_previous_returns_quantity;

            //                 if ($available_quantity < 0) {
            //                     return redirect()->back()->with('error','No available quantity to return for product: '.$order_detail->productInfo->name);
            //                 }
            //                 if ($qty > $available_quantity) {
            //                     return redirect()->back()->with('error','Return quantity can not be more than available quantity to return for product: '.$order_detail->productInfo->name);
            //                 }
            //             } else {
            //                 return redirect()->back()->with('error','Order detail not found.');
            //             }
            //         }

            //     }

            //     $order_return_data_detail = [];
            //     $order_total_price = 0;




            //     foreach ($request->product_id as $key => $product_id) {
            //         if ($request->qty[$key] > 0) {

            //             $order_detail = OrderDetail::where('id',$request->order_details_id[$key])->latest()->first();

            //             if($order_detail) {
            //                 if($order_detail->quantity > 0) {
            //                     $order_detail->quantity = $request->qty[$key];
            //                     $order_total_price += $order_detail->price * $request->qty[$key];
            //                     $order_return_data_detail[]  = $order_detail->toArray();
            //                 }

            //             }
            //         }
            //     }

            //     $data["order_id"] = $order->id;
            //     $data["type"] = 2;
            //     $data["tracking_code"] = $order->tracking_code;
            //     $data["status"] = 1;
            //     $data["payment_status"] = 1;
            //     $data["total_price"] = $order_total_price;
            //     $data["grand_total_price"] = $order_total_price;
            //     $data["user_type_discount"] = $order->user_type_discount;
            //     $data["discount_amount"] = 0;
            //     $data["shipping_cost"] = 0;
            //     $data["packing_type"] = $order->packing_type;
            //     $data["packing_amount"] = 0;
            //     $data["courier_cost"] = 0;
            //     $data["discount_percent_in_total"] = 0;
            //     $data["discount_amount_in_total"] = 0;
            //     $data["discount_on_amount"] = 0;
            //     $data["remark"] = $request->remark;
            //     $data["created_by"] = auth()->user()->id;
            //     $data["user_id"] = $order->user_id;

            //     DB::transaction(function () use ($request,$data) {

            //         $OrderReturn = OrderReturn::create($data);
            //         foreach ($order_return_data_detail as $key => $order_return_data_details) {
            //             unset($order_return_data_details['variation']);
            //             unset($order_return_data_details['update_by']);
            //             unset($order_return_data_details['id']);
            //             $order_return_data_details['order_id'] = $order->id;
            //             $order_return_data_details['return_order_id'] = $OrderReturn->id;
            //             OrderReturnDetail::create($order_return_data_details);

            //             Stock::where([
            //                 'varient_id' => $order_return_data_details['varient_id'],
            //                 'product_id' => $order_return_data_details['product_id'],
            //             ])->increment('quantity', $order_return_data_details['quantity']);
            //         }

            //         foreach ($request->product_id as $key => $product_id) {
            //             if ($request->qty[$key] > 0) {
            //                 $order_details_datas = OrderDetail::where('id',$request->order_details_id[$key])->latest()->first();

            //                 if($order_details_datas) {
            //                     if($order_details_datas->quantity > 0) {
            //                         $order_detail_data['quantity'] = $order_details_datas->quantity - $request->qty[$key];

            //                         $order_details_datas->update($order_detail_data);
            //                     }

            //                 }
            //             }
            //         }

            //         $Return['invoice_no'] = sprintf('%08d', $OrderReturn->id);
            //         $OrderReturn->update($Return);

            //         $payment_data['amount'] = $order_total_price;
            //         $payment_data['type'] = 2;
            //         $payment_data['user_id'] = $order->user_id;
            //         $payment_data['order_id'] = $order->id;
            //         $payment_data['payment_approved'] = 1;
            //         $payment_data['status'] = 1;
            //         $payment_data['created_by'] = auth()->user()->id;

            //         Payment::create($payment_data);

            //         $update_order_data['return_status'] = 1;
            //         $update_order_data['return_amount'] = $order->return_amount + $order_total_price;
            //         $update_order_data['returned_amount'] = 0;
            //         $update_order_data['total_price'] = $order->total_price - $order_total_price;
            //         $update_order_data['grand_total_price'] = $order->grand_total_price - $order_total_price;

            //         $order->update($update_order_data);

            //     });


            //     return redirect()->route("admin.order.index")->with('success','Quantity has been returned for order: '.$order->tracking_code);
            // }

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
                // unset($data['coupon_discount']);
                // unset($data['personal_vehicle']);
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

            if(isset($request->main_order_id) and $request->main_order_id != '') {
                $query->whereHas('mainOrderInfo', function ($new_query) use ($request) {
                    $new_query->where('tracking_code', 'like','%'.$request->main_order_id.'%');
                });
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

    public function returnOrderStatusUpdate(Request $request)
    {
        $user = Auth::user();
        // dd($request->all());

        // if(Gate::allows('order_return_list', $user))
        // {
            $orderReturn = OrderReturn::where('id',$request->orderId)->latest()->first();

            if (!$orderReturn) {
                return redirect()->back()->with('error','Order not found.');
            }

            if ($request->shipping_cost < 0) {
                return redirect()->back()->with('error','Shipping Cost can not be negative.');
            }

            $update_data['status'] = $request->status;
            $update_data['payment_status'] = $request->payment_status;
            $update_data['shipping_cost'] = $request->shipping_cost ?? 0;
            $update_data['grand_total_price'] = ($orderReturn->total_price) - (($orderReturn->voucher_discount ?? 0) + ($request->shipping_cost ?? 0));

            $orderReturn->update($update_data);

            $get_payment = Payment::where([
                'order_id' => $orderReturn->id,
                'type' => 2
            ])->latest()->first();

            $previous_payment_status = $get_payment->status ?? 0;

            if ($get_payment) {
                $payment_update['status'] = $request->payment_status;
                $get_payment->update($payment_update);
            } else {
                $get_payment = new Payment;
                $get_payment->type = 2;
                $get_payment->order_id = $orderReturn->id;
                $get_payment->user_id = $orderReturn->user_id;
                $get_payment->amount = $orderReturn->grand_total_price;
                $get_payment->payment_method = $orderReturn->delivery_option;
                $get_payment->status = $request->payment_status; // helper function return payment functon status check
                $get_payment->created_by = $user->id;
                $get_payment->save();
            }

            $get_main_order_payment = Payment::where([
                'order_id' => $orderReturn->order_id,
                'type' => 1
            ])->latest()->first();

            $get_main_order = Order::where([
                'id' => $orderReturn->order_id,
            ])->latest()->first();

            // dd($orderReturn);

            if ($request->payment_status == 1) {
                if ($get_main_order_payment) {
                    if ($previous_payment_status != 1) {
                        // $deducted_amount = $get_main_order_payment->amount - $get_payment->amount;
                        // $main_payment_update['amount'] = $deducted_amount;
                        // $get_main_order_payment->update($main_payment_update);

                        // $main_order_amount_update['grand_total_price'] = $get_main_order->grand_total_price - $get_payment->amount;
                        // $main_order_amount_update['total_price'] = $get_main_order->total_price - $get_payment->amount;
                        // $get_main_order->update($main_order_amount_update);
                    }
                }
            } else {
                if ($get_main_order_payment) {
                    if ($previous_payment_status == 1) {
                        // $added_amount = $get_main_order_payment->amount + $get_payment->amount;
                        // $main_payment_update['amount'] = $added_amount;
                        // $get_main_order_payment->update($main_payment_update);

                        // $main_order_amount_update['grand_total_price'] = $get_main_order->grand_total_price + $get_payment->amount;
                        // $main_order_amount_update['total_price'] = $get_main_order->total_price + $get_payment->amount;
                        // $get_main_order->update($main_order_amount_update);
                    }
                }
            }

            if (isset($request->return_to_stock) and count($request->return_to_stock) > 0 and $request->status == 1) {
                foreach ($request->return_to_stock as $key => $value) {

                    $order_return_detail = OrderReturnDetail::where('id',$key)->latest()->first();

                    if ($order_return_detail) {
                        $order_return_detail_update['stock_status'] = 1;
                        $order_return_detail->update($order_return_detail_update);

                        if ($order_return_detail->quantity > 0) {
                            $inventory = Inventory::where([
                                'order_id' => $orderReturn->id,
                                'type' => 6,
                                'product_id' => $order_return_detail->product_id,
                                'varient_id' => $order_return_detail->varient_id,
                            ])->latest()->first();

                            if ($inventory) {

                                if ($inventory->quantity > $order_return_detail->quantity) {
                                    $inventory_update['quantity'] = $order_return_detail->quantity;
                                    $inventory->update($inventory_update);


                                    $difference = $inventory->quantity - $order_return_detail->quantity;
                                    Stock::where([
                                        'varient_id' => $order_return_detail->varient_id,
                                        'product_id' => $order_return_detail->product_id,
                                    ])->increment('quantity', $$difference);

                                    // OrderDetail::where('order_id', $orderReturn->order_id)
                                    //     ->where('product_id', $order_return_detail->product_id)
                                    //     ->where('varient_id', $order_return_detail->varient_id)
                                    //     ->where('id', $order_return_detail->order_detail_id)
                                    //     ->decrement('quantity', $difference);
                                } else if ($inventory->quantity < $order_return_detail->quantity) {
                                    $difference = $order_return_detail->quantity - $inventory->quantity;

                                    $check_stock = Stock::where([
                                        'varient_id' => $order_return_detail->varient_id,
                                        'product_id' => $order_return_detail->product_id,
                                    ])->first();

                                    if ($check_stock && ($check_stock->quantity < $difference)) {
                                       return redirect()->back()->with('error','Insufficient stock for product: '.($order_return_detail->productInfo->name ?? '').'. Available stock is '.$check_stock->quantity.', required '.$difference.'.');
                                    }

                                    $inventory_update['quantity'] = $order_return_detail->quantity;
                                    $inventory->update($inventory_update);


                                    Stock::where([
                                        'varient_id' => $order_return_detail->varient_id,
                                        'product_id' => $order_return_detail->product_id,
                                    ])->decrement('quantity', $difference);

                                    // OrderDetail::where('order_id', $orderReturn->order_id)
                                    //     ->where('product_id', $order_return_detail->product_id)
                                    //     ->where('varient_id', $order_return_detail->varient_id)
                                    //     ->where('id', $order_return_detail->order_detail_id)
                                    //     ->increment('quantity', $difference);
                                }

                            } else {
                                $inventory = new Inventory;
                                $inventory->order_id = $orderReturn->id;
                                $inventory->type = 6;
                                $inventory->product_id = $order_return_detail->product_id;
                                $inventory->varient_id = $order_return_detail->varient_id;
                                $inventory->quantity = $order_return_detail->quantity;
                                $inventory->created_by = $user->id;
                                $inventory->save();


                                Stock::where([
                                    'varient_id' => $order_return_detail->varient_id,
                                    'product_id' => $order_return_detail->product_id,
                                ])->increment('quantity', $order_return_detail->quantity);

                                // OrderDetail::where('order_id', $orderReturn->order_id)
                                //     ->where('product_id', $order_return_detail->product_id)
                                //     ->where('varient_id', $order_return_detail->varient_id)
                                //     ->where('id', $order_return_detail->order_detail_id)
                                //     ->decrement('quantity', $order_return_detail->quantity);

                            }
                        }


                    }
                }
            }

            if ($request->status == 1 and (!isset($request->return_to_stock) or count($request->return_to_stock) == 0)) {

                $order_return_details = OrderReturnDetail::where('return_order_id',$orderReturn->id)->get();
                foreach ($order_return_details as $order_return_detail) {
                    $order_return_detail_update['stock_status'] = 0;
                    $order_return_detail->update($order_return_detail_update);

                    $inventory = Inventory::where([
                        'order_id' => $orderReturn->id,
                        'type' => 6,
                        'product_id' => $order_return_detail->product_id,
                        'varient_id' => $order_return_detail->varient_id,
                    ])->latest()->first();

                    if ($inventory) {

                        $check_stock = Stock::where([
                            'varient_id' => $order_return_detail->varient_id,
                            'product_id' => $order_return_detail->product_id,
                        ])->first();

                        if ($check_stock && ($check_stock->quantity < $order_return_detail->quantity)) {
                            return redirect()->back()->with('error','Insufficient stock for product: '.($order_return_detail->productInfo->name ?? '').'. Available stock is '.$check_stock->quantity.', required '.$order_return_detail->quantity.'.');
                        }

                        Stock::where([
                            'varient_id' => $order_return_detail->varient_id,
                            'product_id' => $order_return_detail->product_id,
                        ])->decrement('quantity', $order_return_detail->quantity);

                        // OrderDetail::where('order_id', $orderReturn->order_id)
                        //     ->where('product_id', $order_return_detail->product_id)
                        //     ->where('varient_id', $order_return_detail->varient_id)
                        //     ->where('id', $order_return_detail->order_detail_id)
                        //     ->increment('quantity', $order_return_detail->quantity);

                        $inventory->delete();
                    }
                }
            }

            if ($request->status != 1) {
                $order_return_details = OrderReturnDetail::where('return_order_id',$orderReturn->id)->get();

                foreach ($order_return_details as $order_return_detail) {
                    $order_return_detail_update['stock_status'] = 0;
                    $order_return_detail->update($order_return_detail_update);

                    $inventory = Inventory::where([
                        'order_id' => $orderReturn->id,
                        'type' => 6,
                        'product_id' => $order_return_detail->product_id,
                        'varient_id' => $order_return_detail->varient_id,
                    ])->latest()->first();

                    if ($inventory) {

                        $check_stock = Stock::where([
                            'varient_id' => $order_return_detail->varient_id,
                            'product_id' => $order_return_detail->product_id,
                        ])->first();

                        if ($check_stock && ($check_stock->quantity < $order_return_detail->quantity)) {
                            return redirect()->back()->with('error','Insufficient stock for product: '.($order_return_detail->productInfo->name ?? '').'. Available stock is '.$check_stock->quantity.', required '.$order_return_detail->quantity.'.');
                        }

                        Stock::where([
                            'varient_id' => $order_return_detail->varient_id,
                            'product_id' => $order_return_detail->product_id,
                        ])->decrement('quantity', $order_return_detail->quantity);

                        // OrderDetail::where('order_id', $orderReturn->order_id)
                        //     ->where('product_id', $order_return_detail->product_id)
                        //     ->where('varient_id', $order_return_detail->varient_id)
                        //     ->where('id', $order_return_detail->order_detail_id)
                        //     ->increment('quantity', $order_return_detail->quantity);

                        $inventory->delete();
                    }
                }
            }

            return redirect()->back()->with('success','Order return status has been updated successfully.');

        // }
        // else
        // {
        //     abort(403);
        // }
    }
}
