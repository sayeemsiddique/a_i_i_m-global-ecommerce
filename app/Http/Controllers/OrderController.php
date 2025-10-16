<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Payment;
use App\Models\OrderDetail;
use App\Models\Stock;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('order_list', $user))
        {
            menuSubmenu('manage_order', 'order_list');

            $query = Order::where('type',2);

            if ($request->fromDate and $request->fromDate !='') {
                $query->whereDate('created_at','>=',$request->fromDate);
            }

            if ($request->toDate and $request->toDate !='') {
                $query->whereDate('created_at','<=',$request->toDate);
            }

            if ($request->order_id and $request->order_id !='') {
                $query->where('tracking_code','like','%'.$request->order_id.'%');
            }

            $orders = $query->latest()->paginate(20);

            return view('backend.admin.order.index', compact('orders'));

        }
        else
        {
            abort(403);
        }

    }

    public function show($id)
    {
        $user = Auth::user();

        if(Gate::allows('view_order', $user))
        {
            menuSubmenu('manage_order', 'order_list');

            $id = Crypt::decryptString($id);

            $order = Order::where('id',$id)->latest()->first();
            $setting = Setting::oldest()->first();
            $payment = Payment::where('order_id', $id)->first();

            return view('backend.admin.order.show', compact('order', 'setting', 'payment'));

        }
        else
        {
            abort(403);
        }

    }

    // Order Payment status update
    public function paymentUpdate(Request $request)
    {
        $order = Order::where('id', $request->orderId)->first();
        $order->payment_status = $request->paymentStatus;
        $order->save();

        $payment = Payment::where('order_id', $request->orderId)->first();
        $payment->status = $request->paymentStatus;
        $payment->save();

        return redirect()->back()->with('success', 'Payment Status Updated Successfully...!!!');
    }

    // Order status update
    public function orderUpdate(Request $request)
    {
        $order = Order::where('id', $request->orderId)->first();
        $order->status = $request->orderStatus;
        $order->save();

        return redirect()->back()->with('success', 'Order Status Updated Successfully...!!!');
    }

    // Order delivery update
    public function deliveryUpdate(Request $request)
    {
        $order = Order::where('id', $request->orderId)->first();
        $order->delivery_status = $request->deliveryStatus;
        $order->save();

        // Get Order products & manage stock
        if($request->deliveryStatus == 2)
        {
            $products = OrderDetail::where('order_id', $request->orderId)->groupBy('product_id')->get();
            foreach($products as $product){
                // Manage stock
                $stock = Stock::where('product_id', $product->product_id)->where('varient_id', $product->varient_id)->first();
                $stock->quantity -= $product->quantity;
                $stock->save();

                // insert history into inventory table
                $inventory = new Inventory;
                $inventory->order_id = $request->orderId;
                $inventory->type = 2;
                $inventory->product_id = $product->product_id;
                $inventory->varient_id = $product->varient_id;
                $inventory->quantity = $product->quantity;
                $inventory->created_by = Auth::user()->id;
                $inventory->save();

            }
        }


        return redirect()->back()->with('success', 'Delivery Status Updated Successfully...!!!');
    }

    public function pending_list(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('pending_order_list', $user))
        {
            menuSubmenu('manage_order', 'pending_order_list');

            $query = Order::where('type',2)->where('status', 0);

            if (isset($request->fromDate) and $request->fromDate != '') {
                $query->whereDate('created_at','>=',$request->fromDate);
            }

            if (isset($request->toDate) and $request->toDate != '') {
                $query->whereDate('created_at','<=',$request->toDate);
            }

            if (isset($request->order_id) and $request->order_id != '') {
                $query->where('tracking_code','like','%'.$request->order_id.'%');
            }

            $orders = $query->whereHas('orderDetails', function ($new_query) {
                $new_query->whereHas('productInfo', function ($n_new_query) {
                    $n_new_query->where('type', 1);
                });
            })->latest()->paginate(20);

            return view('backend.admin.order.pending', compact('orders'));

        }
        else
        {
            abort(403);
        }
    }

    public function orderStatusUpdate(Request $request)
    {
        // dd($request->all());

        // "orderId" => "346"
        // "stage" => "1"
        // "delivery_status" => "2"
        // "payment_status" => "1"
        // "delivery_date" => null

        DB::transaction(function () use ($request) {

            $order = Order::where('id', $request->orderId)->first();
            $order->status = $request->stage ?? 0;
            $order->delivery_status = $request->delivery_status ?? 0;
            $order->payment_status = $request->payment_status ?? 0; // but its status manage from payments table
            $order->save();

            $payment = Payment::where([
                'order_id' => $request->orderId,
                'type' => 1
            ])->first();
            // $payment->type = 1; // 1=sale,2=return
            $payment->status = $request->payment_status ?? 0; // 1 => 'Pending',2 => 'Recieved',3 => 'Rejected',4 => 'Returned',
            $payment->save();

            // check stock has enough quantity or not
            foreach($order->orderDetails as $order_detail){
                $check_stock = Stock::where('product_id', $order_detail->product_id)
                                ->where('varient_id', $order_detail->varient_id)
                                ->first();

                if($order_detail->quantity > $check_stock->quantity){
                    return redirect()->back()->with('error', ($check_stock->product->name ?? "").' Stock quantity is less then order quantity, Please update stock first.');
                }
            }

            // delivery status 1 => 'Pending', 2 => 'On Delivery', 3 => 'Delivered',  4 => 'Returned',
            if ($request->delivery_status == 1) {

                foreach($order->orderDetails as $order_detail){
                    $inventory = Inventory::where([
                        'order_id' => $request->orderId,
                        'product_id' => $order_detail->product_id,
                        'varient_id' => $order_detail->varient_id,
                        'type' => 2
                    ])->first();

                    if($inventory){
                        $stock = Stock::where('product_id', $inventory->product_id)->where('varient_id', $inventory->varient_id)->first();

                        $stock->quantity += $inventory->quantity;

                        $stock->save();
                        $inventory->delete();
                    }
                }

            } elseif ($request->delivery_status == 2 || $request->delivery_status == 3) {
                foreach($order->orderDetails as $order_detail){
                    $inventory = Inventory::where([
                        'order_id' => $request->orderId,
                        'product_id' => $order_detail->product_id,
                        'varient_id' => $order_detail->varient_id,
                        'type' => 2
                    ])->first();

                    if($inventory) {

                        if($inventory->quantity > $order_detail->quantity) {

                            $will_return_in_stock = $inventory->quantity - $order_detail->quantity;
                            $stock = Stock::where('product_id', $inventory->product_id)->where('varient_id', $inventory->varient_id)->first();
                            $stock->quantity += $will_return_in_stock;
                            $stock->save();
                        } else if($inventory->quantity < $order_detail->quantity) {

                            $will_deduct_from_stock = $order_detail->quantity - $inventory->quantity;
                            $stock = Stock::where('product_id', $inventory->product_id)->where('varient_id', $inventory->varient_id)->first();
                            $stock->quantity -= $will_deduct_from_stock;
                            $stock->save();
                        }

                    } else {
                        // insert history into inventory table
                        $inventory = new Inventory;
                        $inventory->order_id = $request->orderId;
                        $inventory->type = 2;
                        $inventory->product_id = $order_detail->product_id;
                        $inventory->varient_id = $order_detail->varient_id;
                        $inventory->quantity = $order_detail->quantity;
                        $inventory->created_by = Auth::user()->id;
                        $inventory->save();

                        // Manage stock
                        $stock = Stock::where('product_id', $order_detail->product_id)->where('varient_id', $order_detail->varient_id)->first();
                        $stock->quantity -= $order_detail->quantity;
                        $stock->save();
                    }

                }
            } else if ($request->delivery_status == 4) {

                foreach($order->orderDetails as $order_detail){
                    $inventory = new Inventory;
                    $inventory->order_id = $request->orderId;
                    $inventory->type = 6; // return
                    $inventory->product_id = $order_detail->product_id;
                    $inventory->varient_id = $order_detail->varient_id;
                    $inventory->quantity = $order_detail->quantity;
                    $inventory->created_by = Auth::user()->id;
                    $inventory->save();

                    // Manage stock
                    $stock = Stock::where('product_id', $order_detail->product_id)->where('varient_id', $order_detail->varient_id)->first();
                    $stock->quantity += $order_detail->quantity;
                    $stock->save();
                }

            }


            // if($request->stage == 0) {

                // $user = User::where('id', $order->user_id)->first();
                // $msg = 'Order no: '.$order->tracking_code.' is now pending';

                // $adminMail = 'actbisf.bcic@gmail.com';

                // Mail::to($adminMail)->send(new OrderStatusMailTo($user, $adminMail, $msg));

            // } elseif($request->stage == 1) {

                // $setting = Setting::where('id', 1)->first();

                // // Send Mail notification to user of order success
                // $user = User::where('id', $order->user_id)->first();
                // $msg = 'Your order no: '.$order->tracking_code.' has been accepted, <a href="'.route("download.invoice",[$order->id,$order->tracking_code]).'">Please click this link to download your invoice</a>';

                // Mail::to($order->email)->send(new OrderFeedbackMail($user, $msg, $order, $setting));


                // $msg = 'Order no: '.$order->tracking_code.' has been accepted';

                // $adminMail = 'actbisf.bcic@gmail.com';

                // Mail::to($adminMail)->send(new OrderStatusMailTo($user, $adminMail, $msg));
            // } elseif($request->stage == 2) {

                // $inventories = Inventory::where('order_id', $request->orderId)->get();

                // if(count($inventories) > 0){
                //     foreach($inventories as $inventory){
                //         $stock = Stock::where('product_id', $inventory->product_id)->where('varient_id', $inventory->varient_id)->first();

                //         $stock->quantity += $inventory->quantity;

                //         $stock->save();
                //         $inventory->delete();
                //     }
                // }

                // $setting = Setting::where('id', 1)->first();

                // // Send Mail notification to user of order fail
                // $user = User::where('id', $order->user_id)->first();
                // $msg = 'Your order no: '.$order->tracking_code.' Has been Rejected.';

                // Mail::to($order->email)->send(new OrderFeedbackMail($user, $msg, $order,$setting ));

                // $msg = 'Order no: '.$order->tracking_code.' Has been Rejected.';

                // $adminMail = 'actbisf.bcic@gmail.com';

                // Mail::to($adminMail)->send(new OrderStatusMailTo($user, $adminMail, $msg));
            // }elseif($request->stage == 3){
                // Check if enough stock available
                // $products = OrderDetail::where('order_id', $request->orderId)->get();

                // foreach($products as $product){
                //     $stock = Stock::where('product_id', $product->product_id)->where('varient_id', $product->varient_id)->first();

                //     if($product->quantity > $stock->quantity){
                //         return redirect()->back()->with('error', 'Stock quantity is less then order quantity, Please update stock first.');
                //     }
                // }

                // $products = OrderDetail::where('order_id', $request->orderId)->get();
                // $inventories = Inventory::where('order_id', $request->orderId)->get();

                // foreach($inventories as $inventory_data){
                //     $stock = Stock::where('product_id', $inventory_data->product_id)->where('varient_id', $inventory_data->varient_id)->first();

                //     $stock->quantity += $inventory_data->quantity;

                //     $stock->save();
                //     $inventory_data->delete();
                // }

                // foreach($products as $product){
                //     // Manage stock
                //     $stock = Stock::where('product_id', $product->product_id)->where('varient_id', $product->varient_id)->first();

                //     $stock->quantity -= $product->quantity;

                //     $stock->save();

                //     // insert history into inventory table
                //     $inventory = new Inventory;

                //     $inventory->order_id = $request->orderId;
                //     $inventory->type = 2;
                //     $inventory->product_id = $product->product_id;
                //     $inventory->varient_id = $product->varient_id;
                //     $inventory->quantity = $product->quantity;
                //     $inventory->created_by = Auth::user()->id;

                //     $inventory->save();
                // }

                // $setting = Setting::where('id', 1)->first();
                // $user = User::where('id', $order->user_id)->first();
                // $msg = 'Your order no: '.$order->tracking_code.' is on delivery stage.';

                // Mail::to($order->email)->send(new OrderFeedbackMail($user, $msg, $order,$setting ));

                // $msg = 'Order no: '.$order->tracking_code.' is on delivery stage.';

                // $adminMail = 'actbisf.bcic@gmail.com';

                // Mail::to($adminMail)->send(new OrderStatusMailTo($user, $adminMail, $msg));
            // }elseif($request->stage == 4){

                // $setting = Setting::where('id', 1)->first();
                // $user = User::where('id', $order->user_id)->first();

                // $msg = 'Your order no: '.$order->tracking_code.' has been delivered.';

                // Mail::to($order->email)->send(new OrderFeedbackMail($user, $msg, $order,$setting ));

                // $msg = 'Order no: '.$order->tracking_code.' has been delivered.';

                // $adminMail = 'actbisf.bcic@gmail.com';

                // Mail::to($adminMail)->send(new OrderStatusMailTo($user, $adminMail, $msg));
            // }
        });


        return redirect()->back()->with('success', 'Order Status Updated Successfully...!!!');
    }

    public function stock_in_list(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('product_stock', $user))
        {
            menuSubmenu('inventory_management', 'product_stock');

            $query = Order::where('type', 1);

            $query->whereHas('orderDetails', function ($new_query) {
                $new_query->whereHas('productInfo', function ($n_new_query) {
                    $n_new_query->where('type', 1);
                });
            });

            if (isset($request->fromDate) and $request->fromDate !='') {
                $query->whereDate('created_at','>=',$request->fromDate);
            }

            if (isset($request->toDate) and $request->toDate !='') {
                $query->whereDate('created_at','<=',$request->toDate);
            }

            if (isset($request->order_id) and $request->order_id !='') {
                $query->where('tracking_code','like','%'.$request->order_id.'%');
            }

            if (isset($request->type) and $request->type !='') {

                $query->whereHas('user', function ($new_query) use ($request) {
                    $new_query->where('type', $request->type);
                });
            }

            $orders = $query->latest()->paginate(20);

            return view('backend.admin.order.stock_in_list', compact('orders'));

        }
        else
        {
            abort(403);
        }
    }

    public function stock_in_show($id)
    {
        $user = Auth::user();

        if(Gate::allows('view_order', $user))
        {
            menuSubmenu('inventory_management', 'product_stock');

            $order = Order::where('id',$id)->first();
            $setting = Setting::oldest()->first();
            $payment = Payment::where('order_id', $id)->first();

            return view('backend.admin.order.stock_in_show', compact('order', 'setting', 'payment'));

        }
        else
        {
            abort(403);
        }

    }

    public function deduct_stock_list(Request $request)
    {
        $user = Auth::user();

        if (isset($request->deduct) and $request->deduct == 1) {
            return redirect()->route('admin.order.deduct_stock_list')->with('success', 'Product Deducted Successfull');
        }


            menuSubmenu('inventory_management', 'product_stock');

            $query = Order::where('type', 6);

            $query->whereHas('orderDetails', function ($new_query) {
                $new_query->whereHas('productInfo', function ($n_new_query) {
                    $n_new_query->where('type', 1);
                });
            });

            if (isset($request->fromDate) and $request->fromDate !='') {
                $query->whereDate('created_at','>=',$request->fromDate);
            }

            if (isset($request->toDate) and $request->toDate !='') {
                $query->whereDate('created_at','<=',$request->toDate);
            }

            if (isset($request->order_id) and $request->order_id !='') {
                $query->where('tracking_code','like','%'.$request->order_id.'%');
            }

            if (isset($request->type) and $request->type !='') {

                $query->whereHas('user', function ($new_query) use ($request) {
                    $new_query->where('type', $request->type);
                });
            }

            $orders = $query->latest()->paginate(20);

            return view('backend.admin.order.stock_deduct_list', compact('orders'));


    }

    public function completed_list(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('complete_order_list', $user))
        {
            menuSubmenu('manage_order', 'complete_order_list');

            $query = Order::where('type',2)->where('stage', 4);

            if (isset($request->fromDate) and $request->fromDate != '') {
                $query->whereDate('created_at','>=',$request->fromDate);
            }

            if (isset($request->toDate) and $request->toDate != '') {
                $query->whereDate('created_at','<=',$request->toDate);
            }

            if (isset($request->order_id) and $request->order_id != '') {
                $query->where('tracking_code','like','%'.$request->order_id.'%');
            }

            $orders = $query->whereHas('orderDetails', function ($new_query) {
                $new_query->whereHas('productInfo', function ($n_new_query) {
                    $n_new_query->where('type', 1);
                });
            })->latest()->paginate(20);

            return view('backend.admin.order.complete', compact('orders'));

        }
        else
        {
            abort(403);
        }
    }
}
