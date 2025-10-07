<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\VarientData;
use App\Models\Stock;
use App\Models\PosCart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;


class PointOfSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        if(Gate::allows('point_of_sale',$user))
        {
            menuSubmenu('store_management', 'point_of_sale');
            $stock = Stock::get();
            $inventoryItems = PosCart::where('user_id',Auth::id())->get();
            $total_price = 0;
            foreach($inventoryItems as $item)
            {
                $total_price +=  $item->price * $item->quantity;
            }
            return view('backend.admin.pos.create',[
                'stock' => $stock,
                'cartItems' => $inventoryItems,
                'total_price' => $total_price
            ]);
        
        } else {
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Stock $item, Request $request)
    {
        
        $pre_cart = PosCart::where('varient_id',$item->varient_id)->where('user_id',Auth::id())->first();
        
        
        if(!$pre_cart)
        {
            
            if($item->product->	discount_price == 0)
            {
                $price = $item->varient ? $item->varient->discount_price : 0;
            }
            else
            {
                $price = $item->product ? $item->product->discount_price : 0;
            }
            

            $cart = new PosCart;           
            
            $cart->stock_id = $item->id;

            $cart->product_id  = $item->product_id;
            $cart->varient_id  = $item->varient_id;
            $cart->quantity  = 1;
            $cart->price  = $price;
            $cart->user_id  = Auth::id();
            $cart->save();
        }
        else
        {
            $pre_cart->quantity = $pre_cart->quantity + 1;
            // $inventoryItem = $pre_cart->serviceInventory;
            
            if($pre_cart->quantity > $item->quantity)
            {        
                
                $inventoryItems = PosCart::where('user_id',Auth::id())->get();
                $total_price = 0;
                foreach($inventoryItems as $item)
                {
                    $total_price +=  $item->price * $item->quantity;
                }
                
                $page = View('backend.admin.pos.ajax.cartTable',['cartItems' =>$inventoryItems,'total_price' => $total_price])->render();
                $message = "Quantity More Than Stock.";
                if($request->ajax())
                {
                    return Response()->json(array(
                        'success' => false,
                        'page' => $page,
                        'message' => $message
                    ));
                }
            }
            else
            {
                $pre_cart->save();
            }
        }


        $inventoryItems = PosCart::where('user_id',Auth::id())->get();
        $total_price = 0;
        foreach($inventoryItems as $item)
        {
            $total_price +=  $item->price * $item->quantity;
        }
        
        $page = View('backend.admin.pos.ajax.cartTable',['cartItems' =>$inventoryItems,'total_price' => $total_price])->render();

        if($request->ajax())
        {
            return Response()->json(array(
                'success' => true,
                'page' => $page,
            ));
        }
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
    public function update($item, $quantity, Request $request)
    {
        $cart = PosCart::find($item);
        $inventoryItem = Stock::find($cart->stock_id);
        
        // $inventoryItem = $cart->serviceInventory;
                
        if($inventoryItem->quantity < $quantity)
        {
            
            $inventoryItems = PosCart::where('user_id',Auth::id())->get();
            $total_price = 0;
            foreach($inventoryItems as $item)
            {
                $total_price +=  $item->price * $item->quantity;
            }
            
            $page = View('backend.admin.pos.ajax.cartTable',['cartItems' =>$inventoryItems,'total_price' => $total_price])->render();
            $message = "Quantity More Than Stock.";
            if($request->ajax())
            {
                return Response()->json(array(
                    'success' => false,
                    'page' => $page,
                    'message' => $message
                ));
            }
        }
        else
        {
            if($quantity > 0)
            {
                $cart->quantity = $quantity;
                $cart->save();
            }
            else
            {
                $cart->quantity = $cart->$quantity;
                $cart->save();
            }

            $inventoryItems = PosCart::where('user_id',Auth::id())->get();
            $total_price = 0;
            foreach($inventoryItems as $item)
            {
                $total_price +=  $item->price * $item->quantity;
            }
            
            $page = View('backend.admin.pos.ajax.cartTable',['cartItems' =>$inventoryItems,'total_price' => $total_price])->render();
            
            if($request->ajax())
            {
                return Response()->json(array(
                    'success' => true,
                    'page' => $page,

                ));
            } 
        }
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

    public function delete($id,Request $request)
    {
        
        $cart = PosCart::find($id);
        $cart->delete();

        $inventoryItems = PosCart::where('user_id',Auth::id())->get();
        $total_price = 0;
        foreach($inventoryItems as $item)
        {
            $total_price +=  $item->price * $item->quantity;
        }
        
        $page = View('backend.admin.pos.ajax.cartTable',['cartItems' =>$inventoryItems,'total_price' => $total_price])->render();

        if($request->ajax())
        {
            return Response()->json(array(
                'success' => true,
                'page' => $page,
            ));
        } 
    }


    public function submit(Request $request)
    {
        $inventoryItems = PosCart::where('user_id',Auth::id())->get();
        
        if($inventoryItems->count() > 0)
        {
            if($request->cancel == 'cancel')
            {     
                foreach($inventoryItems as $item)
                {
                    $item->delete();
                }
            }
            elseif($request->submit == 'submit')
            {
                
                $total_price = 0;
                $total_quantity = 0;
                $salesCenter = [];
                foreach($inventoryItems as $item)
                {
                    $total_quantity += $item->quantity;                 
                    $total_price += $item->price * $item->quantity;
                    
                }
                                

                $order = new Order;
                $order->type = 2; //out
                $order->tracking_code = date('yhis');
                $order->user_id = '';
                $order->status = 1;
                $order->delivery_status =  1;
                $order->payment_status = 1;
                $order->total_price = $total_price;
                $order->grand_total_price = $total_price;
                $order->update_by = Auth::user()->id;
                
                $order->save();

                foreach($inventoryItems as $item)
                {
                    // order details create
                    $orderDetail = new OrderDetail;   
                    $orderDetail->order_id= $order->id;
                    $orderDetail->product_id= $item->product_id;
                    $orderDetail->quantity= $item->quantity;
                    $orderDetail->price= $item->price;
                    $orderDetail->varient_id= $item->varient_id;
                    $orderDetail->update_by  = $order->update_by;               
                    $orderDetail->save(); 
                
                    // inventory create
                    $inventory = new Inventory;
                    $inventory->order_id  = $order->id;
                    $inventory->type  = 2;
                    $inventory->product_id  = $item->product_id;
                    $inventory->varient_id  = $item->varient_id;
                    $inventory->quantity  = $item->quantity;
                    $inventory->created_by  = $order->update_by;
                    $inventory->save();

                    $stock = Stock::find($item->stock_id);
                    $stock->quantity = $stock->quantity - $item->quantity;
                    $stock->save();

                    $item->delete(); 

                }
                
                // return redirect()->route('admin.pos.invoice', ['order' => $order->id]);
                return back()->with('success','Remove all item from cart.');

            }
            return back()->with('success','Remove all item from cart.');
        }
        else
        {
            return back()->with('error','No Item in cart');
        }
        
    }
}
