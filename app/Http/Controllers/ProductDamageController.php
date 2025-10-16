<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Validator;
use Auth;
use Illuminate\Support\Facades\Gate;

/* included models */
use App\Models\Stock;
use App\Models\Product;
use App\Models\Varient;
use App\Models\VarientData;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\OrderDetail;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductDamageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('damage_list',$user))
        {
            menuSubmenu('inventory_management', 'damage_list');

            $query = OrderDetail::select('orders.*', 'order_details.*', 'products.*', 'order_details.quantity as damage_quantity', 'orders.created_at as damage_created')
                                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                                ->join('products', 'order_details.product_id', '=', 'products.id')
                                ->where('orders.type', 5);

            if (isset($request->fromDate) && $request->fromDate != '') {
                $query->whereDate('order_details.created_at', '>=', $request->fromDate);
            }

            if (isset($request->toDate) && $request->toDate != '') {
                $query->whereDate('order_details.created_at', '<=', $request->toDate);
            }

            if (isset($request->type) && $request->type != '') {
                $query->where('products.type', $request->type);
            }

            if (isset($request->name) && $request->name != '') {
                $query->where('products.name', 'like', '%'.$request->name.'%');
            }

            if (isset($request->code) && $request->code != '') {
                $query->where('products.code', 'like', '%'.$request->code.'%');
            }

            if (isset($request->category_id) && $request->category_id != '') {
                $query->where('products.category_id',$request->category_id);
            }

            $categories = Category::where('status',1)->select('name','id')->get();

            $orders = $query->orderBy('orders.created_at', 'desc')->paginate(20);
            return view('backend.admin.productDamange.index', compact('orders','categories'));
        }
        else
        {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        if(Gate::allows('reconciliation_product_stock',$user))
        {
            menuSubmenu('inventory_management', 'reconciliation_product_stock');

            return view('backend.admin.productDamange.create');
        }
        else
        {
            abort(401);
        }
    }

    public function getProduct($product)
    {
        return Product::where([
            'type'=>$product,
            'status'=>1
        ])->get();
    }

    public function getProductVarient($product)
    {
        $varients = Varient::where('product_id',$product)->get();
        return view('backend.admin.productDamange.varient_option', compact('varients'));
        // $varient = Varient::where('product_id',$product)->first();
        // if($varient)
        // {
        //     $data = VarientData::where('varient_id',$varient->id)->get();
        // }
        // else
        // {
        //     $data = [];
        // }
        // return $data;
    }

    public function getStock($product)
    {
        return Stock::where('product_id',$product)->first();
    }

    public function getVarientStock($product)
    {
        return Stock::where('varient_id',$product)->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),
        [
            'product_type'     => 'required',
            'product'      => 'required',
            'quantity'      => 'required',
            'damange_quantity'      => 'required',
        ]);
        if($validation->fails())
        {
            return back()
            ->withInput()->withErrors('Please, fillup the form correctly and try again.');
        }

        if($request->quantity < $request->damange_quantity)
        {
            return back()->with('error','Damage Quantity is invalid.Try with valid quantity.');
        }
        if($request->product and $request->product_varient)
        {
            $stock = Stock::where('product_id',$request->product)->where('varient_id',$request->product_varient)->first();

            if($stock->quantity < $request->damange_quantity)
            {
                return back()->with('error','Damage Quantity is invalid.Try with valid quantity.');
            }

            $product = Varient::where('id',$request->product_varient)->first();
        }
        else
        {
            $stock = Stock::where([
                'product_id'=>$request->product,
                'varient_id'=>0,
            ])->first();

            if($stock->quantity < $request->damange_quantity)
            {
                return back()->with('error','Damage Quantity is invalid.Try with valid quantity.');
            }

            $product = Product::where('id',$stock->product_id)->first();
        }


        if($request->product_varient) {
            $product_detail = Varient::where('id', $request->product_varient)->first();
        } else {
            $product_detail = Product::where('id', $request->product)->first();
        }

        $stock->quantity = $stock->quantity - $request->damange_quantity;

        DB::transaction(function () use ($request, $stock, $product, $product_detail) {
            $order = new Order;
            $order->type  = 5; // damage
            $order->status = 1; // approved
            $order->tracking_code = date('yhis');
            $order->total_price = $request->damange_quantity * $product->discount_price;
            $order->grand_total_price = $request->damange_quantity * $product->discount_price;
            $order->update_by = Auth::id();
            if ($request->file('document')) {

                $path = $request->file('document')->store('/public/document');

                $path = Str::replace('public/document', '', $path);
                $order->document = Str::replace('/', '', $path);
            }
            $order->save();

            $orderDetail = new OrderDetail;
            $orderDetail->order_id =$order->id;
            $orderDetail->product_id = $request->product;
            $orderDetail->weight = $product_detail->weight;
            $orderDetail->unit = $product_detail->unit;
            $orderDetail->quantity = $request->damange_quantity;
            $orderDetail->varient_id = $request->product_varient ? $request->product_varient : 0;
            $orderDetail->price = $request->damange_quantity * $product->discount_price;
            $orderDetail->save();

            $inventories = new Inventory;
            $inventories->order_id = $order->id;
            $inventories->type = 5;// damage
            $inventories->product_id = $request->product;
            $inventories->varient_id = $request->product_varient ? $request->product_varient : 0;
            $inventories->weight = $product_detail->weight;
            $inventories->unit = $product_detail->unit;
            $inventories->quantity = $request->damange_quantity;
            $inventories->created_by = Auth::id();
            $inventories->save();

            $stock->save();

        });

        return back()->with('success','Adjust damage product submit successfully.');
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
        $user = Auth::user();

        if(Gate::allows('delete_damage',$user))
        {

            $order = Order::where([
                'id' => $id,
                'type' => 5,
            ])->latest()->first();

            DB::transaction(function () use ( $order) {
                if ($order) {
                    foreach ($order->orderDetails as $key => $orderDetails) {
                        Stock::where([
                            'varient_id' => $orderDetails->varient_id,
                            'product_id' => $orderDetails->product_id,
                        ])->increment('quantity', $orderDetails->quantity);
                    }
                }

                $order->orderDetails()->delete();
                $order->inventoryDetails()->delete();
                $order->delete();
            });



            return back()->with('success','Damage order removed successfully.');
        }
        else
        {
            abort(401);
        }
    }
}
