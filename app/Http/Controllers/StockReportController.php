<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\OrderDetail;
use App\Models\Category;

class StockReportController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('report_management', $user))
        {
            menuSubmenu('report_management', 'stock_report');

            $query = Product::where([
                'type' => 1,
                'status' => 1,
            ])->whereNotIn('status', [2]);

            if (isset($request->product_id) and $request->product_id != '') {
                $query->where('id',$request->product_id);
            }

            if(isset($request->category_id) and $request->category_id != '')
            {
                $query->where('category_id', $request->category_id);
            }

            if (isset($request->fromDate) and $request->fromDate != '') {
                $query->where(function ($new_query) use ($request) {
                    $new_query->with('orderDetailsInfo', function ($new_new_query) use ($request) {
                        $new_new_query->whereDate('created_at','>=',$request->fromDate);
                    });
                });

                $query->where(function ($new_query) use ($request) {
                    $new_query->with('productVarient', function ($new_new_query) use ($request) {
                        $new_new_query->with('orderDetailsVarientInfo', function ($n_new_new_query) use ($request) {
                            $n_new_new_query->whereDate('created_at','>=',$request->fromDate);
                        });
                    });
                });
            }

            // if (isset($request->toDate) and $request->toDate != '') {
            //     $query->where(function ($new_query) use ($request) {
            //         $new_query->with('orderDetailsInfo', function ($new_new_query) use ($request) {
            //             $new_new_query->whereDate('created_at','<=',$request->toDate);
            //         });
            //     });

            //     $query->where(function ($new_query) use ($request) {
            //         $new_query->with('productVarient', function ($new_new_query) use ($request) {
            //             $new_new_query->with('orderDetailsVarientInfo', function ($n_new_new_query) use ($request) {
            //                 $n_new_new_query->whereDate('created_at','<=',$request->fromDate);
            //             });
            //         });
            //     });
            // }

            $products = $query->latest()->get();
            $product_datas = Product::where('status',1)->where('type',1)->select('id','name','code')->latest()->get();
            $type = 1;
            $product_category = Category::where('status', 1)->select('name','id')->get();

            // dd($products->first());

            return view('backend.admin.report.stockReport.index', compact('products','type','product_datas','product_category'));

        }
        else
        {
            abort(403);
        }
    }

    public function storeStock(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('report_management', $user))
        {
            menuSubmenu('report_management', 'store_stock_report');

            $query = Product::where('type', 2)->latest();

            if (isset($request->product_id) and $request->product_id !='') {
                $query->where('id',$request->product_id);
            }

            if (isset($request->category_id) and $request->category_id !='') {
                $query->where('category_id',$request->category_id);
            }

            $products = $query->get();
            $product_datas = Product::where('type', 2)->select('name','id')->get();

            $type = 2;

            return view('backend.admin.report.stockReport.store_index', compact('products','type','product_datas'));

        }
        else
        {
            abort(403);
        }
    }

    public function stock_in_report_by_product(Request $request)
    {
        menuSubmenu('report_management', 'stock_in_report_by_product');

        if(empty($request->fromDate)){
            $fromDate = '2022-01-01';
        }else{
            $fromDate = $request->fromDate;
        }

        if(empty($request->toDate)){
            $toDate = date('Y-m-d');
        }else{
            $toDate = $request->toDate;
        }

        // if(empty($request->stockType)){
        //     $inventories = Inventory::whereBetween('created_at', [$fromDate." "."00:00:00", $toDate." "."23:59:59"])->latest()->get();

        // }else{
        //     $inventories = Inventory::when(!empty($request->stockType), function($query) use ($request){
        //         $query->where('type', $request->stockType);
        //         $query->where('product_id', $request->product_id);
        //     })
        //     ->whereBetween('created_at', [$fromDate." "."00:00:00", $toDate." "."23:59:59"])->latest()->get();
        // }

        if($request->product_id)
        {
            $productId =$request->product_id;
        }
        else{
            $productId = '';
        }

        if($request->stockType)
        {
            $stockType = $request->stockType;
        }
        else{
            $stockType = '';
        }

        $type = $request->type;

        $products = Product::where('status',1)->where('type',1)->get();

        // $inventories = Inventory::select('inventories.*')
        //         ->when($fromDate, function($query) use ($fromDate){
        //             $query->whereDate('inventories.created_at', '>=', $fromDate);
        //         })
        //         ->when($toDate, function($query) use ($toDate){
        //             $query->whereDate('inventories.created_at', '<=', $toDate);
        //         })
        //         ->when($productId, function($query) use ($productId){
        //             $query->where('inventories.product_id', $productId);
        //         })
        //         ->when($stockType, function($query) use ($stockType){

        //             $query->where('type', $stockType);

        //         })->get();

        $query = OrderDetail::latest();

        $query->whereHas('productInfo', function ($new_query) use ($request) {
            $new_query->whereIn('type', [1]);
        });

        if(isset($request->product_id) and $request->product_id != '')
        {
            $query->where('product_id',$request->product_id);
        }

        if(isset($request->fromDate) and $request->fromDate != '')
        {
            $query->whereDate('created_at','>=',$request->fromDate);
        }

        if(isset($request->category_id) and $request->category_id != '')
        {
            $query->whereHas('product', function ($new_query) use ($request) {
                $new_query->where('category_id', $request->category_id);
            });
        }


        if(isset($request->toDate) and $request->toDate != '')
        {
            $query->whereDate('created_at','<=',$request->toDate);
        }

        if(isset($request->stockType) and $request->stockType != '')
        {
            if ($request->stockType == 1) {
                $query->whereHas('orderInfo', function ($new_query) use ($request) {
                    $new_query->whereIn('type', [1,3]);
                });
            }

            if ($request->stockType == 2) {
                $query->whereHas('orderInfo', function ($new_query) use ($request) {
                    $new_query->whereIn('type', [2,4,5]);
                });
            }
        }

        $order_details = $query->get();
        $product_category = Category::where('status', 1)->select('name','id')->get();

        return view('backend.admin.report.stockReport.stock_in_report_by_product', compact('order_details','products','product_category'));
    }

    public function store_product_report_by_product(Request $request)
    {
        menuSubmenu('report_management', 'store_product_report_by_product');

        if(empty($request->fromDate)){
            $fromDate = '2022-01-01';
        }else{
            $fromDate = $request->fromDate;
        }

        if(empty($request->toDate)){
            $toDate = date('Y-m-d');
        }else{
            $toDate = $request->toDate;
        }

        // if(empty($request->stockType)){
        //     $inventories = Inventory::whereBetween('created_at', [$fromDate." "."00:00:00", $toDate." "."23:59:59"])->latest()->get();

        // }else{
        //     $inventories = Inventory::when(!empty($request->stockType), function($query) use ($request){
        //         $query->where('type', $request->stockType);
        //         $query->where('product_id', $request->product_id);
        //     })
        //     ->whereBetween('created_at', [$fromDate." "."00:00:00", $toDate." "."23:59:59"])->latest()->get();
        // }

        if($request->product_id)
        {
            $productId =$request->product_id;
        }
        else{
            $productId = '';
        }

        if($request->stockType)
        {
            $stockType = $request->stockType;
        }
        else{
            $stockType = '';
        }

        $type = $request->type;

        $products = Product::where('status',1)->where('type',2)->get();

        // $inventories = Inventory::select('inventories.*')
        //         ->when($fromDate, function($query) use ($fromDate){
        //             $query->whereDate('inventories.created_at', '>=', $fromDate);
        //         })
        //         ->when($toDate, function($query) use ($toDate){
        //             $query->whereDate('inventories.created_at', '<=', $toDate);
        //         })
        //         ->when($productId, function($query) use ($productId){
        //             $query->where('inventories.product_id', $productId);
        //         })
        //         ->when($stockType, function($query) use ($stockType){

        //             $query->where('type', $stockType);

        //         })->get();

        $query = OrderDetail::latest();

        $query->whereHas('productInfo', function ($new_query) use ($request) {
            $new_query->whereIn('type', [2]);
        });

        if(isset($request->product_id) and $request->product_id != '')
        {
            $query->where('product_id',$request->product_id);
        }

        if(isset($request->fromDate) and $request->fromDate != '')
        {
            $query->whereDate('created_at','>=',$request->fromDate);
        }

        if(isset($request->toDate) and $request->toDate != '')
        {
            $query->whereDate('created_at','<=',$request->toDate);
        }

        if(isset($request->stockType) and $request->stockType != '')
        {
            if ($request->stockType == 1) {
                $query->whereHas('orderInfo', function ($new_query) use ($request) {
                    $new_query->whereIn('type', [1,3]);
                });
            }

            if ($request->stockType == 2) {
                $query->whereHas('orderInfo', function ($new_query) use ($request) {
                    $new_query->whereIn('type', [2,4,5]);
                });
            }
        }

        $order_details = $query->get();




        return view('backend.admin.report.stockReport.store_product_report_by_product', compact('order_details','products'));
    }

    public function filter(Request $request)
    {
        // menuSubmenu('report_management', 'stock_report');

        if(empty($request->fromDate)){
            $fromDate = '2022-01-01';
        }else{
            $fromDate = $request->fromDate;
        }

        if(empty($request->toDate)){
            $toDate = date('Y-m-d');
        }else{
            $toDate = $request->toDate;
        }

        if($request->product_id)
        {
            $productId =$request->product_id;
        }
        else{
            $productId = '';
        }
        if($request->stockType)
        {
            $stockType = $request->stockType;
        }
        else{
            $stockType = '';
        }
        $type = $request->type;

        $products = Product::with('stock')->where('type', $type)->get();

        $inventories = Inventory::select('inventories.*')
                ->when($fromDate, function($query) use ($fromDate){
                    $query->whereDate('inventories.created_at', '>=', $fromDate);
                })
                ->when($toDate, function($query) use ($toDate){
                    $query->whereDate('inventories.created_at', '<=', $toDate);
                })
                ->when($productId, function($query) use ($productId){
                    $query->where('inventories.product_id', $productId);
                })
                ->when($stockType, function($query) use ($stockType){
                    $query->where('type', $stockType);
                })->get();


        return view('backend.admin.report.stockReport.filter', compact('inventories','products','fromDate','toDate','stockType','productId','type'));
    }

}
