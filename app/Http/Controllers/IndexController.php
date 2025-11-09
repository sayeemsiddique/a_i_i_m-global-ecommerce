<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

/* included models */
use App\Models\User;

use App\Models\Division;
use App\Models\Role;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function adminDashboard()
    {
        menuSubmenu('dashboard', 'dashboard');

        // total pending order
        $total_pending_orders = Order::where('type',2)->whereHas('orderDetails', function ($new_query) {
            $new_query->whereHas('productInfo', function ($n_new_query) {
                $n_new_query->where('type', 1);
            });
        })->where('status',0)->select('id')->get()->count();


        $total_products = Product::where('status',1)->where('type',1)->select('id')->get()->count();

        $total_office_users = User::where('type',0)->get()->select('id')->count();

        $total_customers = User::where('type',1)->select('id')->get()->count();

        $low_stocks = Stock::whereHas('product', function ($query) {
            $query->where([
                'type' => 1,
                'status' => 1,
            ]);
        })->orderBy('quantity', 'asc')->limit(10)->with('product')->get();

        $last_5_months_sells = DB::table('orders as o')
            ->leftJoin('order_returns as r', function ($join) {
                $join->on('o.id', '=', 'r.order_id')
                    ->where('r.status', '=', 1);
            })
            ->select(
                DB::raw("DATE_FORMAT(o.created_at, '%M- %Y') as month"),
                DB::raw("SUM(o.grand_total_price) - COALESCE(SUM(r.grand_total_price), 0) as net_amount")
            )
            ->where('o.created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->where('o.status', 1)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();


        return view('backend.index', compact('total_pending_orders', 'total_products', 'total_office_users', 'total_customers','low_stocks','last_5_months_sells'));
    }
}
