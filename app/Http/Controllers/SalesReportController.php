<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;
use DB;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Category;
use App\Models\Gatepass;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if(Gate::allows('report_management', $user))
        {
            menuSubmenu('report_management', 'sales_report');

            // $query = Order::whereIn('stage', [3,4]);
            $query = Order::whereIn('status', [1])->latest();

            $query->whereHas('orderDetails', function ($new_query) {
                $new_query->whereHas('productInfo', function ($n_new_query) {
                    $n_new_query->where('type', 1);
                });
            });

            if (isset($request->fromDate) and $request->fromDate != '') {
                $query->whereDate('created_at','>=',$request->fromDate);
            }

            if (isset($request->toDate) and $request->toDate != '') {
                $query->whereDate('created_at','<=',$request->toDate);
            }

            if (isset($request->orderId) and $request->orderId != '') {
                $query->where('tracking_code','like','%'.$request->orderId.'%');
            }

            if (isset($request->category) and $request->category != '') {
                $query->whereHas('orderDetails', function ($new_query) use ($request) {
                    $new_query->whereHas('productInfo', function ($n_new_query) use ($request) {
                        $n_new_query->where('category_id', $request->category);
                    });
                });
            }

            $orders = $query->with('orderDetails','orderUserInfo')->get();
            $categories = Category::all();


            // $product_datas = Product::where('status',1)->latest()->get();
            return view('backend.admin.report.salesReport.index', compact('orders','categories'));
        }else{
            abort(403);
        }
    }

    public function filter(Request $request)
    {
        menuSubmenu('report_management', 'sales_report');

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

        if($request->customerName){
            $customerId = User::where('first_name', 'like', "%".$request->customerName."%")->orWhere('last_name', 'like', "%".$request->customerName."%")->first();
        }
        else{
            $customerId = [];
        }

        if($request->category)
        {
            $cate = $request->category;
        }
        else{
            $cate = [];
        }

        if($request->orderId)
        {
            $orderId = $request->orderId;
        }
        else
        {
            $orderId = '';
        }

        if($request->product_id)
        {
            $product_id = $request->product_id;
        } else {
            $product_id = '';
        }
        $categories = Category::all();

        // $product_datas = Product::where('status',1)->latest()->get();


        $orders = Order::select('order_details.*', 'products.*', 'orders.*')
                ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->where('orders.stage',3)
                ->when($fromDate, function($query) use ($fromDate){
                    $query->whereDate('orders.created_at', '>=', $fromDate);
                })
                ->when($toDate, function($query) use ($toDate){
                    $query->whereDate('orders.created_at', '<=', $toDate);
                })
                ->when($orderId, function($query) use ($orderId){
                    $query->where('orders.tracking_code', $orderId);
                })
                ->when($cate, function($query) use ($cate){
                    $query->where('products.category_id', $cate);
                })->when($product_id, function($query) use ($product_id){
                    $query->where('products.id', $product_id);
                })
                ->groupBy('orders.id')
                ->get();

        return view('backend.admin.report.salesReport.filter', compact('orders','categories','cate','fromDate','toDate','orderId'));
    }

    public function dealerSalesReport()
    {
        $user = Auth::user();
        if(Gate::allows('report_management', $user))
        {
            menuSubmenu('report_management', 'dealer_sales_report');

            $dealers = User::where('type', 3)->get();
            $orders = Order::select( 'order_details.*', 'products.*', 'users.*','orders.*')
                            ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                            ->join('products', 'products.id', '=', 'order_details.product_id')
                            ->join('users', 'users.id','=','orders.user_id' )
                            ->where('users.type', 3)->groupBy('orders.id')
                            ->where('products.type',1)
                            ->whereIn('orders.stage', [3,4])->groupBy('orders.id')->get();

            return view('backend.admin.report.salesReport.dealerSalesReport', compact('dealers','orders'));
        }else{
            abort(403);
        }
    }


    public function dealerFilter(Request $request)
    {

        $user = Auth::user();
        if(Gate::allows('report_management', $user))
        {
            menuSubmenu('report_management', 'dealer_sales_report');

            if(empty($request->fromDate))
            {
                $fromDate = '';
            }
            else
            {
                $fromDate = $request->fromDate;
            }

            if(empty($request->toDate))
            {
                $toDate = '';
            }
            else
            {
                $toDate = $request->toDate;
            }

            if($request->orderId){
                $orderId = $request->orderId;
            }
            else
            {
                $orderId = '';
            }
            $dealer = User::where('type', 3)->where('id', $request->dealer)->first();

            $orders = Order::select('order_details.*', 'products.*', 'orders.*')
                ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where('users.type',3)
                ->whereIn('orders.stage',[3,4])->groupBy('orders.id')
                ->when($fromDate, function($query) use ($fromDate){
                    $query->whereDate('orders.created_at', '>=', $fromDate);
                })
                ->when($toDate, function($query) use ($toDate){
                    $query->whereDate('orders.created_at', '<=', $toDate);
                })
                ->when($dealer, function($query) use ($dealer){

                    $query->where('orders.user_id', $dealer->id);
                })
                ->when($orderId, function($query) use ($orderId){

                    $query->where('orders.tracking_code', $orderId);
                })
                ->groupBy('orders.id')
                ->get();

            $dealers = User::where('type', 3)->get();
            // dd($orders);

            return view('backend.admin.report.salesReport.dealerSalesReport',[
                'dealers'=>$dealers,
                'orders'=>$orders,
                'fromDate'=>$fromDate,
                'toDate'=>$toDate,
                'dealr'=>$dealer,
                'orderId' => $orderId
            ]);
        }else{
            abort(403);
        }
    }

    public function customerSales()
    {
        $user = Auth::user();
        if(Gate::allows('report_management', $user))
        {
            menuSubmenu('report_management', 'customer_sales_report');

            $customers = User::where('type','<>',3)->where('role_id',7)->get();

            $orders = Order::select('order_details.*', 'products.*', 'orders.*')
                ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where('users.type','<>',3)->where('users.role_id',7)
                ->where('products.type',1)
                ->whereIn('orders.stage',[3,4])->groupBy('orders.id')->get();

            return view('backend.admin.report.salesReport.customerSales', compact('customers','orders'));
        }else{
            abort(403);
        }
    }

    public function customerFilter(Request $request)
    {

        $user = Auth::user();
        if(Gate::allows('report_management', $user))
        {


            if(empty($request->fromDate))
            {
                $fromDate = '';
            }
            else
            {
                $fromDate = $request->fromDate;
            }

            if(empty($request->toDate))
            {
                $toDate = '';
            }
            else
            {
                $toDate = $request->toDate;
            }

            if($request->orderId){
                $orderId = $request->orderId;
            }
            else
            {
                $orderId = '';
            }

            $customer = User::where('type','<>',3)->where('id', $request->customer)->first();

            $orders = Order::select('order_details.*', 'products.*', 'orders.*')
                ->join('order_details', 'order_details.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->where('users.type','<>',3)->where('users.role_id',7)
                ->whereIn('orders.stage',[3,4])
                ->when($fromDate, function($query) use ($fromDate){
                    $query->whereDate('orders.created_at', '>=', $fromDate);
                })
                ->when($toDate, function($query) use ($toDate){
                    $query->whereDate('orders.created_at', '<=', $toDate);
                })
                ->when($customer, function($query) use ($customer){

                    $query->where('orders.user_id', $customer->id);
                })
                ->when($orderId, function($query) use ($orderId){

                    $query->where('orders.tracking_code', $orderId);
                })
                ->groupBy('orders.id')
                ->get();

            $customers = User::where('type','<>',3)->where('role_id',7)->get();
            // dd($orders);

            return view('backend.admin.report.salesReport.customerFilter',[
                'customers'=>$customers,
                'orders'=>$orders,
                'fromDate'=>$fromDate,
                'toDate'=>$toDate,
                'customer'=>$customer,
                'orderId' => $orderId
            ]);
        }else{
            abort(403);
        }
    }

    public function commission_report_dealer(Request $request)
    {
        menuSubmenu('report_management', 'dealer_commission_report');


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


        $users = User::where([
            'type' => 3,
            'status' => 1,
        ])->latest()->get();

        $orders = collect();
        $user_data = "";

        if ($request->user_id != '')  {
            $orders = Order::whereBetween('created_at', [$fromDate." "."00:00:00", $toDate." "."23:59:59"])->where([
                "user_id" => $request->user_id,
            ])->whereIn('stage', [3,4])->latest()->get();

            $user_data = User::where([
                'type' => 3,
                'id' => $request->user_id,
            ])->latest()->first();
        }

        return view('backend.admin.report.salesReport.dealer_commission', compact('users','orders','user_data'));
    }

    public function vat_sd_commision_report(Request $request)
    {
        menuSubmenu('report_management', 'vat_sd_commission_report');
        $users = User::where([
            // 'type' => 3,
            'status' => 1,
        ])->latest()->get();

        $orders = collect();
        $user_data = "";

        $order_query = Order::whereIn('stage', [3,4]);

        if ($request->type != '')  {
            $order_query->whereHas('orderUserInfo', function ($r) use ($request) {
                $r->where('type', $request->type);
            });
        }

        if ($request->user_id != '')  {

            $order_query->where('user_id',$request->user_id);

            $user_data = User::where([
                // 'type' => 3,
                'id' => $request->user_id,
            ])->latest()->first();
        }

        if ($request->fromDate != '')  {

            $order_query->whereDate('created_at','>=',$request->fromDate);

        }

        if ($request->toDate != '')  {

            $order_query->whereDate('created_at','<=',$request->toDate);

        }

        if ($request->order_id != '')  {

            $order_query->whereDate('tracking_code','like','%'.$request->order_id.'%');

        }

        $orders = $order_query->latest()->get();

        return view('backend.admin.report.salesReport.vat_sd_commision_report', compact('users','orders','user_data'));
    }

    public function daily(Request $request)
    {
        $user = Auth::user();
        if(Gate::allows('report_management', $user))
        {
            menuSubmenu('report_management', 'daily_sales_report');
            // dd($request->all());
            // dd(date('Y', strtotime($request->fromDate)));
            if (date('m', strtotime($request->fromDate)) >= 7) {
                $date_from = date('Y-07-01', strtotime($request->fromDate));
                $date_to = date('Y-06-30', strtotime('+1 years'));
            } else {
                $date_from = date('Y-07-01', strtotime('-1 years'));
                $date_to = date('Y-06-30', strtotime($request->fromDate));
            }
            // echo $date_from;
            // echo $date_to;
            // dd("fgfg");
            if (isset($request->fromDate) and $request->fromDate != '') {
                $categories = DB::table('categories')->where('status',1)->orderBy('sl','asc')->select('id','name')->get();

                foreach ($categories as $key => $category) {
                    $category->today_sale = 0;
                    $category->monthly_sale = 0;
                    $category->yearly_sale = 0;

                    $product_ids = DB::table('products')->where([
                        'status'=>1,
                        'type'=>1,
                        'category_id'=>$category->id,
                    ])->select(DB::raw('group_concat(id) as ids'))->first();
                    $category->product_ids = $product_ids->ids;
                    if ($product_ids->ids != '') {

                        $order_details = DB::table('order_details')->whereDate('created_at','>=',$date_from)->whereDate('created_at','<=',$date_to)->whereIn('product_id', explode(',',$category->product_ids))->select('weight','unit','created_at','quantity')->get();

                        // "2022-07-06"
                        foreach ($order_details as $key2 => $order_detail) {

                            $today_sale = 0;
                            $monthly_sale = 0;
                            if ($order_detail->weight and $order_detail->unit) {
                                if (date('d-m-Y', strtotime($order_detail->created_at)) == date('d-m-Y', strtotime($request->fromDate))) {
                                    if ($order_detail->unit == 1) {
                                        $today_sale = $order_detail->weight * $order_detail->quantity;
                                    } else if($order_detail->unit == 2) {
                                        $today_sale = (($order_detail->weight * 1000) * $order_detail->quantity);
                                    }
                                    $category->today_sale += $today_sale;
                                }

                                if (date('m-Y', strtotime($order_detail->created_at)) == date('m-Y', strtotime($request->fromDate))) {
                                    if ($order_detail->unit == 1) {
                                        $monthly_sale = $order_detail->weight * $order_detail->quantity;
                                    } else if ($order_detail->unit == 2) {
                                        $monthly_sale = ($order_detail->weight * 1000) * $order_detail->quantity;
                                    }
                                    $category->monthly_sale += $monthly_sale;
                                }

                                if ($order_detail->unit == 1) {
                                    $yearly_sale = $order_detail->weight * $order_detail->quantity;
                                } else if ($order_detail->unit == 2) {
                                    $yearly_sale = ($order_detail->weight * 1000) * $order_detail->quantity;
                                }
                                $category->yearly_sale += $yearly_sale;

                            }
                        }
                    }

                }
            } else {
                $categories = [];
            }
            return view('backend.admin.report.salesReport.daily', compact('categories'));
        }else{
            abort(403);
        }
    }

    public function inventory_report_product_wise(Request $request)
    {
        menuSubmenu('report_management', 'inventory_report_product_wise');

        $user = Auth::user();
        if(Gate::allows('report_management', $user))
        {
            $products = Product::where([
                'type'=>1,
                'status'=>1
            ])->select('id','name')->get();

            $order_data = [];
            if (isset($request->product_id) and $request->product_id != '') {
                foreach ($request->product_id as $key => $product_id) {
                    $product_data = DB::table('products')->where('id',$product_id)->select('name','code','unit')->latest()->first();
                    $order_details = DB::table('order_details')->where('product_id',$product_id)
                    ->join('orders', 'orders.id', '=', 'order_details.order_id')
                    ->select('unit','type','order_details.quantity','product_id')
                    ->addSelect(DB::raw('Date(order_details.created_at) as date_time'))
                    ->get()
                    ->groupBy('date_time');

                    $order_data[] = array(
                        'product_data' => $product_data,
                        'order_details_date_group' => $order_details,
                    );
                }
            }

            // dd($order_data);

            return view('backend.admin.report.salesReport.inventory_report_product_wise', compact('products','order_data'));

        }else{
            abort(403);
        }
    }
}
