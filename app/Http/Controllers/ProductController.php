<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\VarientType;
use App\Models\Varient;
use App\Models\VarientData;
use App\Models\VarientValue;
use App\Models\Stock;
use App\Models\ProductInfo;
use App\Models\Inventory;
use App\Models\Upload;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->complete) and $request->complete == 1) {
            return redirect()->route('admin.product.index')->with('success', 'Product Saved Successfull');
        }
        $user = Auth::user();

        
        if(Gate::allows('all_product',$user))
        {
            menuSubmenu('product_setting', 'all_product');
            $query = Product::whereNotIn('status', [2])->where([
                'type' => 1
            ])->latest();

            if (isset($request->name) and $request->name != '') {
                $query->where('name', 'like', '%'.$request->name.'%')->orWhere('code', 'like', '%'.$request->name.'%');
            }
            
            if (isset($request->category_id) and $request->category_id != '') {
                $query->where('category_id', $request->category_id);
            }

            $products = $query->select('id', 'type', 'name', 'slug', 'barcode', 'code','category_id', 'sub_category_id','status')->paginate(25);

            $categories = Category::where([
                // 'parent_id' => 0,
                'status' => 1,
            ])->select('id', 'sl', 'name', 'status',)->get();

            return view('backend.admin.product.index',[
                'products' => $products,
                'categories' => $categories
            ]);
        
        } else {
            abort(403);
        }
        
    }

    public function create()
    {
        $user = Auth::user();

        if(Gate::allows('add_product',$user))
        {
            menuSubmenu('product_setting', 'add_product');
            $categories = Category::where([
                // 'parent_id' => 0,
                'status' => 1,
            ])->get();
            
            $brands = Brand::where([
                'status' => 1,
            ])->get();
            
            $varienttypes = VarientType::with('varientValues')->where([
                'status' => 1,
            ])->get();

            return view('backend.admin.product.create', compact('categories','brands','varienttypes'));
        
        } else {
            abort(403);
        }
        
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        DB::transaction(function () use ($request) {
        $user = Auth::user();

        if(Gate::allows('add_product',$user))
        {
            $request->validate([
                'name' => 'required|unique:products',
            ]);

            $data = $request->all();

            $product['name'] = $request->name;
            $product['type'] = 1;
            $product['code'] = $request->code;
            $product['weight'] = $request->weight;
            $product['added_by'] = auth()->user()->id;
            $product['user_id'] = auth()->user()->id;
            $product['category_id'] = $request->category_id;
            $product['sub_category_id'] = $request->sub_category_id;
            $product['brand_id'] = $request->brand_id;
            $product['status'] = $request->status ?? 0;
            $product['featured'] = $request->featured;
            $product['unit'] = $request->unit;
            $product['has_varient'] = $request->has_varient ?? 0;
            $product['created_by'] = auth()->user()->id;
            $product['price'] = $request->price ?? 0;
            $product['discount'] = $request->discount ?? 0;
            $product['discount_type'] = $request->discount_type ?? 0;
            $product['quantity'] = $request->quantity ?? 0;
            $product['shop_id'] = $request->shop_id ?? 0;
            $product['vendor_id'] = $request->vendor_id ?? 0;

            if(!isset($request->has_varient)){
                if (isset($request->discount) and $request->discount > 0) {
                    if (in_array(($request->discount_type ?? 0), [1,2])) {
                        if ($request->discount_type == 2) {
                            $product['discount_price'] = ($request->price ?? 0) - ((($request->price ?? 0) * $request->discount) / 100);
                        } else {
                            $product['discount_price'] = ($request->price ?? 0) - ($request->discount ?? 0);
                        }
                    } else {
                        $product['discount_price'] = ($request->price ?? 0);
                    }
                } else {
                    $product['discount_price'] = $request->price ?? 0;
                }
                $product['sl_price'] = $product['discount_price'];
            }

            

            unset($data['files']);
            if ($request->file('image')) {
                $cp = $request->file('image');
                $extension = strtolower($cp->getClientOriginalExtension());
                $randomFileName = 'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

                Storage::disk('public')->put('product/'.$randomFileName, File::get($cp));

                $product['image'] = $randomFileName;
            }

            $product['slug'] = Str::of($request->name)->slug('-');
            $product['created_by'] = auth()->user()->id;

            if(isset($request->has_varient) and $request->has_varient != ''){
                $product['varient_type_ids'] = implode(',', $request->varient_type_ids);
            }

            
            $get = Product::create($product);

            $product_info['meta_title'] = $request->name ?? '';
            $product_info['product_id'] = $get->id;
            $product_info['meta_description'] = $request->description ?? '';
            $product_info['description'] = $request->description ?? '';

            $get_info = ProductInfo::create($product_info);

            if ($request->gallery) {
                foreach ($request->gallery as $key => $gallery) {
                    if($request->gallery[$key]){
                        $cp = $request->file('gallery')[$key];
                        $extension = strtolower($cp->getClientOriginalExtension());
                        $randomFileName = 'gallery'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

                        Storage::disk('public')->put('gallery/'.$randomFileName, File::get($cp));

                        $image['name'] = $randomFileName;
                        $image['table'] = 'product';
                        // // product id
                        $image['service_id'] = $get->id;
                        $image['myme_type'] = $request->file('gallery')[$key]->extension();
                        $image['real_name'] = $request->file('gallery')[$key]->getClientOriginalName();

                        $image['created_by'] = Auth::user()->id;
                        Upload::create($image);
                    }
                    
                }
            }

            

            if(isset($request->has_varient) and $request->has_varient != ''){

                $order['type'] = 3;
                $order['user_id'] = auth()->user()->id;
                $order['delivery_status'] = 1;

                $order_data = Order::create($order);

                foreach ($request->sale_price as $key => $sale_price) {

                    if (isset($request->file('varient_image')[$key]) and $request->file('varient_image')[$key]) {
                
                        $cp = $request->file('varient_image')[$key];
                        $extension = strtolower($cp->getClientOriginalExtension());
                        $randomFileName = 'varient_image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

                        Storage::disk('public')->put('varient_image/'.$randomFileName, File::get($cp));

                        $varient['image'] = $randomFileName;
                    }

                    $varient['status'] = 1;
                    $varient['quantity'] = $request->sale_quantity[$key];
                    $varient['price'] = $sale_price;
                    // $varient['vat'] = 0;
                    // $varient['tax'] = 0;
                    $varient['discount'] = $request->varient_discount[$key] ?? 0;
                    $varient['discount_type'] = $request->varient_discount_type[$key] ?? 0;
                    $varient['created_by'] = auth()->user()->id;
                    $varient['product_id'] = $get->id;
                    $varient['weight'] = $request->weights[$key] ?? 0;

                    // if (($request->varient_discount[$key] ?? 0) > 0) {
                        if (in_array(($request->varient_discount_type[$key] ?? 0), [1,2])) {
                            if ($request->varient_discount_type[$key] == 2) {
                                $varient['discount_price'] = ($sale_price) - ((($sale_price) * $request->varient_discount[$key]) / 100);
                            } else {
                                $varient['discount_price'] = ($sale_price) - ($request->varient_discount[$key]);
                            }
                            
                        } else {
                            $varient['discount_price'] = $sale_price;
                        }
                    // } else {
                    //     $varient['discount_price'] = $sale_price;
                    // }
                    
                    $varient_data = Varient::create($varient);

                    $inventory['type'] = 3;
                    $inventory['product_id'] = $get->id;
                    $inventory['varient_id'] = $varient_data->id;
                    $inventory['quantity'] = $request->sale_quantity[$key] ?? 0;
                    $inventory['created_by'] = auth()->user()->id;
                    Inventory::create($inventory);

                    $stock['quantity'] = $varient['quantity'];
                    $stock['product_id'] = $get->id;
                    $stock['varient_id'] = $varient_data->id;

                    Stock::create($stock);

                    $order_detail['order_id'] = $order_data->id;
                    $order_detail['product_id'] = $get->id;
                    $order_detail['quantity'] = $varient['quantity'];
                    $order_detail['varient_id'] = $varient_data->id;
                    OrderDetail::create($order_detail);

                    foreach ($request->varient_type_ids as $index => $type_id) {
                        if ($request->varient_name[$type_id][$key] ?? '') {
                            $varient_datas['varient_type_id'] = $type_id;
                            $varient_datas['data_value'] = $request->varient_name[$type_id][$key] ?? '';

                            $check = VarientValue::where([
                                'varient_type_id' => $type_id,
                                'value' => $varient_datas['data_value'],
                            ])->first();

                            if (!$check) {
                                $varientdata['varient_type_id'] = $type_id;
                                $varientdata['value'] = $request->varient_name[$type_id][$key] ?? '';
                                if ($varientdata['value']) {
                                    $check = VarientValue::create($varientdata);
                                }
                                
                            }


                            $varient_datas['product_id'] = $get->id;
                            $varient_datas['varient_id'] = $varient_data->id;
                            $varient_datas['varient_value_id'] = $check->id ?? 0;
                            VarientData::create($varient_datas);
                        }
                    }

                    $get->sl_price = $get->cheapVarient->discount_price ?? 0;

                    $get->save();
                }
            } else {
                $order['type'] = 3;
                $order['user_id'] = auth()->user()->id;
                $order['delivery_status'] = 1;
                $order_data = Order::create($order);

                $order_detail['order_id'] = $order_data->id;
                $order_detail['product_id'] = $get->id;
                $order_detail['quantity'] = $request->quantity;
                $order_detail['varient_id'] = 0;
                OrderDetail::create($order_detail);

                $inventory['type'] = 3;
                $inventory['product_id'] = $get->id;
                $inventory['varient_id'] = 0;
                $inventory['quantity'] = $request->quantity;
                $inventory['created_by'] = auth()->user()->id;
                Inventory::create($inventory);

                $stock['quantity'] = $request->quantity;
                $stock['product_id'] = $get->id;
                $stock['varient_id'] = 0;
                Stock::create($stock);
            }

            if($request->ajax()){
                return response()->json(['success' => 'Product Added'], 200);
            }

            return redirect()->route('admin.product.index')->with('success', 'Product Added');
        
        } else {
            abort(403);
        }

        });
        
    }

    public function edit($id)
    {
        $user = Auth::user();

        if(Gate::allows('edit_product',$user))
        {
            menuSubmenu('product_setting', 'edit_product');

            $product = Product::with('productVarient')->where('id',$id)->latest()->first();
            // return view('backend.admin.product.edit', compact('product'));
            $categories = Category::where([
                'parent_id' => 0,
                'status' => 1,
            ])->get();
            
            $brands = Brand::where([
                'status' => 1,
            ])->get();
            
            $varienttypes = VarientType::with('varientValues')->where([
                'status' => 1,
            ])->get();

            return view('backend.admin.product.edit', compact('categories','brands','varienttypes','product'));
        } else {
            abort(403);
        }
        
    }

    public function update(Request $request, $id)
    {

        // dd($request->all());
        
        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
        ]);

        DB::transaction(function () use ($request, $id) {
        $data = $request->all();
        
        $old_product = Product::where('id', $id)->latest()->first();

        $product['name'] = $request->name;
        $product['code'] = $request->code;
        $product['weight'] = $request->weight;
        $product['added_by'] = auth()->user()->id;
        $product['user_id'] = auth()->user()->id;
        $product['category_id'] = $request->category_id;
        $product['sub_category_id'] = $request->sub_category_id;
        $product['brand_id'] = $request->brand_id;
        $product['status'] = $request->status ?? 0;
        $product['featured'] = $request->featured;
        $product['unit'] = $request->unit;
        $product['has_varient'] = $request->has_varient ?? 0;
        $product['created_by'] = auth()->user()->id;
        $product['price'] = $request->price ?? 0;
        $product['discount'] = $request->discount ?? 0;
        $product['discount_type'] = $request->discount_type ?? 0;
        $product['quantity'] = $request->quantity ?? 0;
        $product['shop_id'] = $request->shop_id ?? 0;
        $product['vendor_id'] = $request->vendor_id ?? 0;

        unset($data['files']);

        if ($request->file('image')) {
            $cp = $request->file('image');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = 'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('product/'.$randomFileName, File::get($cp));

            $product['image'] = $randomFileName;

        }

        $product['slug'] = Str::of($request->name)->slug('-');
        $product['update_by'] = auth()->user()->id;

        if(isset($request->has_varient) and $request->has_varient != ''){
            $product['varient_type_ids'] = implode(',', $request->varient_type_ids);
        }

        if(!isset($request->has_varient)){
            if (isset($request->discount) and $request->discount > 0) {
                if (isset($request->discount_type) and $request->discount_type != '') {
                    if ($request->discount_type == 2) {
                        $product['discount_price'] = ($request->price ?? 0) - ((($request->price ?? 0) * $request->discount) / 100);
                    } else {
                        $product['discount_price'] = ($request->price ?? 0) - ($request->discount ?? 0);
                    }
                    
                } else {
                    $product['discount_price'] = ($request->price ?? 0) - ($request->discount ?? 0);
                }
            } else {
                $product['discount_price'] = $request->price ?? 0;
            }

            $product['sl_price'] = $product['discount_price'];
        }

                
        $get = Product::where('id', $id)->update($product);


        $product_info['meta_title'] = $request->name ?? '';
        $product_info['product_id'] = $id;
        $product_info['meta_description'] = $request->description ?? '';
        $product_info['description'] = $request->description ?? '';

        $get_info = ProductInfo::where('product_id',$id)->update($product_info);

        if ($request->gallery) {
            foreach ($request->gallery as $key => $gallery) {
                if($request->gallery[$key]){
                    $cp = $request->file('gallery')[$key];
                    $extension = strtolower($cp->getClientOriginalExtension());
                    $randomFileName = 'gallery'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

                    Storage::disk('public')->put('gallery/'.$randomFileName, File::get($cp));

                    $image['name'] = $randomFileName;
                    $image['table'] = 'product';
                    // // product id
                    $image['service_id'] = $get->id;
                    $image['myme_type'] = $request->file('gallery')[$key]->extension();
                    $image['real_name'] = $request->file('gallery')[$key]->getClientOriginalName();

                    $image['created_by'] = Auth::user()->id;
                    Upload::create($image);
                }
                
            }
        }

                

                if(isset($request->has_varient) and $request->has_varient != ''){

                    foreach ($request->sale_price as $key => $sale_price) {

                        if (isset($request->file('varient_image')[$key]) and $request->file('varient_image')[$key]) {
                            $cp = $request->file('varient_image')[$key];
                            $extension = strtolower($cp->getClientOriginalExtension());
                            $randomFileName = 'varient_image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

                            Storage::disk('public')->put('varient_image/'.$randomFileName, File::get($cp));

                            $varient['image'] = $randomFileName;
                        }

                        $varient['status'] = 1;
                        $varient['quantity'] = $request->sale_quantity[$key] ?? 0;
                        $varient['price'] = $sale_price;
                        // $varient['vat'] = 0;
                        // $varient['tax'] = 0;
                        $varient['discount'] = $request->varient_discount[$key] ?? 0;
                        $varient['discount_type'] = $request->varient_discount_type[$key] ?? 0;
                        $varient['created_by'] = auth()->user()->id;
                        $varient['product_id'] = $id;
                        $varient['weight'] = $request->weights[$key] ?? 0;

                        if (($request->varient_discount[$key] ?? 0) > 0) {
                            if ($request->varient_discount_type[$key] != '') {
                                if ($request->varient_discount_type[$key] == 2) {
                                    $varient['discount_price'] = ($sale_price) - ((($sale_price) * $request->varient_discount[$key]) / 100);
                                } else {
                                    $varient['discount_price'] = ($sale_price) - ($request->varient_discount[$key]);
                                }
                                
                            } else {
                                $varient['discount_price'] = ($sale_price) - ($request->varient_discount[$key]);
                            }
                        } else {
                            $varient['discount_price'] = $sale_price;
                        }

                        if ($request->varient_id[$key] > 0) {

                            $get_stock = Varient::where('id',$request->varient_id[$key])->latest()->first();

                            $check_stock = Stock::where([
                                'product_id' => $id,
                                'varient_id' => $request->varient_id[$key] ?? 0
                            ])->latest()->first();

                            if ($check_stock) {
                                if ($get_stock->quantity > $varient['quantity']) {
                                
                                    Stock::where('varient_id',$request->varient_id[$key])->decrement('quantity', ($get_stock->quantity - $varient['quantity']));
                                } else if($get_stock->quantity < $varient['quantity']) {
                                    
                                    Stock::where('varient_id',$request->varient_id[$key])->increment('quantity', ($varient['quantity'] - $get_stock->quantity));
                                }
                            } else {
                                $stock['quantity'] = $varient['quantity'];
                                $stock['product_id'] = $id;
                                $stock['varient_id'] = $request->varient_id[$key];

                                Stock::create($stock);
                                
                            }

                            Varient::where([
                                'product_id' => $id,
                                'id' => $request->varient_id[$key],
                                // 'status' => 1,
                            ])->update($varient);

                            $get_inventory = Inventory::where([
                                'type' => 3,
                                'product_id' => $id,
                                'varient_id' => $request->varient_id[$key],
                            ])->latest()->first();

                            // get order exist
                            $get_order_detail = OrderDetail::where([
                                'product_id' => $id,
                            ])->with(['orderInfo' => function ($query) {
                                $query->where('type', 3);
                            }])->latest()->first();

                            if ($get_order_detail) {
                                $order_get_data = $get_order_detail->orderInfo;
                            } else {
                                $order_data['type'] = 3;
                                $order_data['user_id'] = auth()->user()->id;
                                $order_data['delivery_status'] = 1;
                                $order_get_data = Order::create($order_data);
                            }

                            // get order details exist
                            $get_order_detail_data = OrderDetail::where([
                                'product_id' => $id,
                                'order_id' => $order_get_data->id,
                                'varient_id' => $request->varient_id[$key],
                            ])->latest()->first();

                            if ($get_order_detail_data) {
                                $get_order_detail_data['quantity'] = $varient['quantity'];
                                $get_order_detail_data->save();
                            } else {
                                $set_order_detail_data['quantity'] = $varient['quantity'];
                                $set_order_detail_data['order_id'] = $order_get_data->id;
                                $set_order_detail_data['varient_id'] = $request->varient_id[$key] ?? 0;
                                $set_order_detail_data['product_id'] = $id;
                                OrderDetail::create($set_order_detail_data);
                            }




                            if ($get_inventory) {

                                $inventory_data['quantity'] = $varient['quantity'];
                                $inventory_data['updated_by'] = auth()->user()->id;
                                Inventory::where([
                                    'type' => 3,
                                    'product_id' => $id,
                                    'varient_id' => $request->varient_id[$key] ?? 0,
                                ])->update($inventory_data);

                            } else {

                                $inventory['type'] = 3;
                                $inventory['product_id'] = $id;
                                $inventory['varient_id'] = $request->varient_id[$key];
                                $inventory['quantity'] = $varient['quantity'];
                                $inventory['created_by'] = auth()->user()->id;
                                Inventory::create($inventory);

                            }

                            



                            $varient_data = Varient::where([
                                'product_id' => $id,
                                'id' => $request->varient_id[$key],
                            ])->latest()->first();
                        } else {

                            $varient_data = Varient::create($varient);

                            // get order exist
                            $get_order_detail = OrderDetail::where([
                                'product_id' => $id,
                            ])->with(['orderInfo' => function ($query) {
                                $query->where('type', 3);
                            }])->latest()->first();

                            if ($get_order_detail) {
                                $order_get_data = $get_order_detail->orderInfo;
                            } else {
                                $order_data['type'] = 3;
                                $order_data['user_id'] = auth()->user()->id;
                                $order_data['delivery_status'] = 1;
                                $order_get_data = Order::create($order_data);
                            }

                            // get order details exist
                            $get_order_detail_data = OrderDetail::where([
                                'product_id' => $id,
                                'order_id' => $order_get_data->id,
                                'varient_id' => $varient_data->id,
                            ])->latest()->first();

                            if ($get_order_detail_data) {
                                $get_order_detail_data['quantity'] = $varient['quantity'];
                                $get_order_detail_data->save();
                            } else {
                                $set_order_detail_data['quantity'] = $varient['quantity'];
                                $set_order_detail_data['order_id'] = $order_get_data->id;
                                $set_order_detail_data['varient_id'] = $varient_data->id;
                                $set_order_detail_data['product_id'] = $id;
                                OrderDetail::create($set_order_detail_data);
                            }

                            $inventory['type'] = 3;
                            $inventory['order_id'] = $order_get_data->id;
                            $inventory['product_id'] = $id;
                            $inventory['varient_id'] = $varient_data->id;
                            $inventory['quantity'] = $varient['quantity'];
                            $inventory['created_by'] = auth()->user()->id;
                            Inventory::create($inventory);

                            $stock['quantity'] = $varient['quantity'];
                            $stock['product_id'] = $id;
                            $stock['varient_id'] = $varient_data->id;

                            Stock::create($stock);
                        }

                        foreach ($request->varient_type_ids as $index => $type_id) {
                            if ($request->varient_name[$type_id][$key] ?? '') {
                                $varient_datas['varient_type_id'] = $type_id;
                                $varient_datas['data_value'] = $request->varient_name[$type_id][$key] ?? '';

                                $check = VarientValue::where([
                                    'varient_type_id' => $type_id,
                                    'value' => $varient_datas['data_value'],
                                ])->first();

                                if (!$check) {
                                    $varientdata['varient_type_id'] = $type_id;
                                    $varientdata['value'] = $request->varient_name[$type_id][$key] ?? '';
                                    if ($varientdata['value']) {
                                        $check = VarientValue::create($varientdata);
                                    }
                                    
                                }

                                VarientData::updateOrInsert(
                                    ['varient_id' => $varient_data->id, 'product_id' => $id, 'varient_type_id' => $type_id],
                                    ['data_value' => $varient_datas['data_value'], 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s"), 'varient_value_id' => $check->id ?? 0]
                                );
                            }
                            
                        }

                        $get_product_data = Product::find($id);

                        $get_product_data->sl_price = $get_product_data->cheapVarient->discount_price ?? 0;

                        $get_product_data->save();
                    }
                } else {

                    $varient['status'] = 0;
                    Varient::where([
                        'product_id' => $id,
                    ])->update($varient);

                    $check_stock = Stock::where([
                        'varient_id' => 0,
                        'product_id' => $id,
                    ])->latest()->first();

                    if ($check_stock) {
                        if ($old_product->quantity > $request->quantity) {
                            Stock::where([
                                'varient_id' => 0,
                                'product_id' => $id,
                            ])->decrement('quantity', ($old_product->quantity - $request->quantity));
                        } else if($old_product->quantity < $request->quantity) {
                            Stock::where([
                                'varient_id' => 0,
                                'product_id' => $id,
                            ])->increment('quantity', ($request->quantity - $old_product->quantity));
                        }
                    } else {
                        $stock['quantity'] = $request->quantity;
                        $stock['product_id'] = $id;
                        $stock['varient_id'] = 0;
                        Stock::create($stock);
                    }
                }

                if($request->ajax()){
                    return response()->json(['success' => 'Product Updated'], 200);
                }

                return redirect()->route('admin.product.index')->with('success', 'Product Updated');
        });
    }
    
    public function show($id)
    {
        
        $user = Auth::user();

        if (Gate::allows('view_product', $user)) 
        {
            menuSubmenu('product_setting', 'view_product');
            $product = Product::findOrFail($id);
            if ($product and  $product->type == 2 ) {
                return view('backend.admin.product.material_show', compact('product'));
            }
            return view('backend.admin.product.show', compact('product'));
        } else {
            abort(403);
        }
    }
    
    public function destroy($id)
    {
        $user = Auth::user();

        if (Gate::allows('view_product', $user)) 
        {
            $product = Product::findOrFail($id);
            $product->update(['status' => 2]);
            return redirect()->back()->with('success', 'Product Deleted');
        } else {
            abort(403);
        }
        
    }
    
    public function stock(Request $request)
    {
        if (isset($request->complete) and $request->complete == 1) {
            return redirect()->route('admin.product.stock')->with('success', 'Product Stock Added Successfull');
        }
        menuSubmenu('inventory_management', 'product_stock');
        

        $user = Auth::user();

        if (Gate::allows('product_stock', $user)) 
        {
            $query = Product::latest();

            if (isset($request->name) and $request->name != '') {
                $query->where('name','like', '%'.$request->name.'%');
            }
            $products = $query->withSum('productStock', 'quantity')->where([
                'status' => 1,
                'type' => 1,
            ])->with('productSingleStock','productStock')->paginate(20);
            return view('backend.admin.product.stock', compact('products'));
        } else {
            abort(403);
        }

        
    }
    
    public function add_stock(Request $request)
    {
        menuSubmenu('inventory_management', 'product_stock');

        $user = Auth::user();

        if (Gate::allows('product_add_stock', $user)) 
        {
            $categories = Category::where([
                'parent_id' => 0,
                'status' => 1,
            ])->get();
            
            $brands = Brand::where([
                'status' => 1,
            ])->get();
    
            

            
            
            if ($request->category_id and $request->category_id != '') {
                $query = Product::withSum('productStock', 'quantity')->where([
                    'status' => 1,
                    'type' => 1
                ]);

                $query->where('category_id', $request->category_id);
            } else {
                $query = Product::withSum('productStock', 'quantity')->where([
                    'status' => -9
                ]);
            }

            if ($request->name and $request->name != '') {
                $query->where('name','like', '%'.$request->name.'%');
            }
            
            $products = $query->latest()->with('productSingleStock','productStock')->get();
            
            return view('backend.admin.product.add_stock', compact('products','categories','brands'));
        } else {
            abort(403);
        }
        

        
    }
    
    public function store_inventory(Request $request)
    {
        if (array_sum($request->stock) < 1) {
            $request->validate([
                'quantity' => 'required',
            ]);
        }
        $order['type'] = 1;
        $order['tracking_code'] = date("yhis");
        if ($request->file('document')) {
            $path = $request->file('document')->store('/public/document');
            $path = Str::replace('public/document', '', $path);
            $order['document'] = Str::replace('/', '', $path);
        }
        $data = Order::create($order);

        
        foreach ($request->product_id as $key => $value) {
            if (($request->stock[$key] ?? 0) > 0) {

                $order_detail['order_id'] = $data->id;
                $order_detail['product_id'] = $value;
                $order_detail['quantity'] = $request->stock[$key];
                $order_detail['varient_id'] = $request->varient_id[$key];
                OrderDetail::create($order_detail);


                $inventory['type'] = 1;
                $inventory['order_id'] = $data->id;
                $inventory['product_id'] = $value;
                $inventory['varient_id'] = $request->varient_id[$key];
                $inventory['quantity'] = $request->stock[$key];
                $inventory['created_by'] = auth()->user()->id;
                Inventory::create($inventory);


    
                Stock::where([
                    'product_id' => $value,
                    'varient_id' => $request->varient_id[$key]
                ])->increment('quantity', $request->stock[$key]);

                
            }
        }

    }
    
    public function material_index(Request $request)
    {
        if (isset($request->complete) and $request->complete == 1) {
            return redirect()->route('admin.product.material_index')->with('success', 'Product Saved Successfull');
        }
        $user = Auth::user();

        if(Gate::allows('all_material_product',$user))
        {            
            menuSubmenuSubsubmeny('settings', 'product_setting', 'all_material_product');

            $query = Product::whereNotIn('status', [2])->where([
                'type' => 2
            ])->latest();

            if (isset($request->name) and $request->name != '') {
                $query->where('name', 'like', '%'.$request->name.'%');
            }

            $products = $query->paginate(25);

            return view('backend.admin.product.material_index',compact('products'));
        
        } else {
            abort(403);
        }
    }
    
    public function material_store(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('add_material_product',$user))
        {
            $request->validate([
                'name' => 'required|unique:products',
            ]);

            $data = $request->all();

            $product['name'] = $request->name;
            $product['type'] = 2;
            $product['added_by'] = auth()->user()->id;
            $product['user_id'] = auth()->user()->id;
            $product['category_id'] = 0;
            $product['sub_category_id'] = 0;
            $product['brand_id'] = 0;
            $product['status'] = 1;
            $product['has_varient'] = 0;
            $product['created_by'] = auth()->user()->id;
            $product['price'] = 0;
            $product['discount'] = 0;
            $product['quantity'] = $request->quantity ?? 0;

            unset($data['files']);
            if ($request->file('image')) {
                
                $path = $request->file('image')->store('/public/product');
                
                $path = Str::replace('public/product', '', $path);
                $product['image'] = Str::replace('/', '', $path);
            }

            $product['slug'] = Str::of($request->name)->slug('-');

            $get = Product::create($product);

            $product_info['meta_title'] = $request->name ?? '';
            $product_info['product_id'] = $get->id;
            $product_info['meta_description'] = $request->description ?? '';
            $product_info['description'] = $request->description ?? '';

            $get_info = ProductInfo::create($product_info);
            
            $order['type'] = 3;
            $order['user_id'] = auth()->user()->id;
            $order['delivery_status'] = 1;
            $order_data = Order::create($order);
            
            $order_detail['order_id'] = $order_data->id;
            $order_detail['product_id'] = $get->id;
            $order_detail['quantity'] = $request->quantity;
            $order_detail_data = OrderDetail::create($order_detail);

            $inventory['order_id'] = $order_data->id;
            $inventory['type'] = 3;
            $inventory['product_id'] = $get->id;
            $inventory['varient_id'] = 0;
            $inventory['quantity'] = $request->quantity;
            $inventory['created_by'] = auth()->user()->id;

            Inventory::create($inventory);

            $stock['product_id'] = $get->id;
            $stock['varient_id'] = 0;
            $stock['quantity'] = $request->quantity;
            Stock::create($stock);

            return redirect()->back()->with('success', 'Product Added');

        
        } else {
            abort(403);
        }
    }
    
    public function material_update(Request $request, $id)
    {
        $user = Auth::user();

        if(Gate::allows('edit_material_product',$user))
        {            
            $request->validate([
                'name' => 'required|unique:products,name,' . $id,
            ]);

            $data = $request->all();

            $product['name'] = $request->name;
            $product['quantity'] = $request->quantity ?? 0;

            unset($data['files']);
            if ($request->file('image')) {
                
                $path = $request->file('image')->store('/public/product');
                
                $path = Str::replace('public/product', '', $path);
                $product['image'] = Str::replace('/', '', $path);
            }

            $product['slug'] = Str::of($request->name)->slug('-');

            Product::where('id', $id)->update($product);

            $product_info['meta_title'] = $request->name ?? '';
            $product_info['product_id'] = $id;
            $product_info['meta_description'] = $request->description ?? '';
            $product_info['description'] = $request->description ?? '';

            ProductInfo::where('product_id', $id)->update($product_info);


            $get_order_detail = OrderDetail::where([
                'product_id' => $id,
            ])->with(['orderInfo' => function ($query) {
                $query->where('type', 3);
            }])->latest()->first();

            $order_data = $get_order_detail->orderInfo ?? '';

            if ($order_data) {
                $order_detail_data['quantity'] = $request->quantity;
                OrderDetail::where([
                    'order_id' => $order_data->id,
                    'product_id' => $id,
                ])->update($order_detail_data);

                
                $inventory['quantity'] = $request->quantity;

                Inventory::where([
                    'order_id' => $order_data->id,
                    'type' => 3,
                    'product_id' => 3,
                    'varient_id' => 0,
                ])->update($inventory);


                if ($get_order_detail->quantity > $request->quantity) {
                                
                    Stock::where([
                        'product_id' => $id,
                        'varient_id' => 0
                    ])->decrement('quantity', ($get_order_detail->quantity - $request->quantity));
                } else if($get_order_detail->quantity < $request->quantity) {
                    
                    Stock::where([
                        'product_id' => $id,
                        'varient_id' => 0
                    ])->increment('quantity', ($request->quantity - $get_order_detail->quantity));
                }


            }



            return redirect()->back()->with('success', 'Product Updated');

        
        } else {
            abort(403);
        }
    }


    
    public function material_stock(Request $request)
    {
        if (isset($request->complete) and $request->complete == 1) {
            return redirect()->route('admin.product.stock')->with('success', 'Product Stock Added Successfull');
        }
        menuSubmenu('inventory_management', 'material_product_stock');
        

        $user = Auth::user();

        if (Gate::allows('product_stock', $user)) 
        {
            $products = Product::withSum('productStock', 'quantity')->where([
                'status' => 1,
                'type' => 2,
            ])->latest()->with('productSingleStock','productStock')->paginate(20);
            return view('backend.admin.product.material_stock', compact('products'));
        } else {
            abort(403);
        }
    }

    public function material_add_stock(Request $request)
    {
        menuSubmenu('inventory_management', 'product_add_stock');

        $user = Auth::user();

        if (Gate::allows('product_add_stock', $user)) 
        {
            $categories = Category::where([
                'parent_id' => 0,
                'status' => 1,
            ])->get();
            
            $brands = Brand::where([
                'status' => 1,
            ])->get();

            
            $query = Product::withSum('productStock', 'quantity')->where([
                'status' => 1,
                'type' => 2,
            ]);
            

            if ($request->name and $request->name != '') {
                $query->where('name','like', '%'.$request->name.'%');
            }
            
            $products = $query->latest()->with('productSingleStock','productStock')->get();
            
            return view('backend.admin.product.material_add_stock', compact('products','categories','brands'));
        } else {
            abort(403);
        }
    }
    
    public function store_material_inventory(Request $request)
    {
        
            $order['type'] = 3;
            $order['user_id'] = auth()->user()->id;
            $order['delivery_status'] = 1;
            $order_data = Order::create($order);


            foreach ($request->product_id as $key => $product_id) {
                $order_detail['order_id'] = $order_data->id;
                $order_detail['product_id'] = $product_id;
                $order_detail['quantity'] = $request->quantity[$key];
                $order_detail_data = OrderDetail::create($order_detail);

                $inventory['order_id'] = $order_data->id;
                $inventory['type'] = 3;
                $inventory['product_id'] = $product_id;
                $inventory['varient_id'] = 0;
                $inventory['quantity'] = $request->quantity[$key];
                $inventory['created_by'] = auth()->user()->id;
                Inventory::create($inventory);


                
                $check_stock = Stock::where([
                    'product_id' => $product_id,
                    'varient_id' => 0,
                ])->latest()->first();

                if ($check_stock) {
                    Stock::where([
                        'product_id' => $product_id,
                        'varient_id' => 0,
                    ])->increment('quantity', $request->quantity[$key]);
                } else {
                    $stock['product_id'] = $product_id;
                    $stock['varient_id'] = 0;
                    $stock['quantity'] = $request->quantity[$key];
                    Stock::create($stock);
                }
            }

            if($request->ajax()){
                return response()->json(['success' => 'Product Stock Added'], 200);
            }

            return redirect()->route('admin.product.index')->with('success', 'Product Added');
        
    }
}
