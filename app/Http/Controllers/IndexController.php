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
        })->where('status',0)->get()->count();
        
        // total complete order
        $total_complete_orders = Order::where('type',2)->whereHas('orderDetails', function ($new_query) {
            $new_query->whereHas('productInfo', function ($n_new_query) {
                $n_new_query->where('type', 1);
            });
        })->where('stage',4)->get()->count();
        
        // total pos order
        // $total_pos_orders = Order::where('type',4)->where('status',1)->get()->count();
        
        // total finish product
        $total_products = Product::where('status',1)->where('type',1)->get()->count();

        // total office users
        $total_office_users = User::where('type',0)->get()->count();

        // total dealers users
        // $total_dealers = User::where('role_id',7)->where('type',3)->get()->count();

        // total corporate consumers
        // $total_corporate_consumers = User::where('role_id',7)->where('type',2)->get()->count();

        // total customers
        $total_customers = User::where('role_id',7)->where('type',1)->get()->count();
        
        //online sale money
        $totalOnlineMoney = Order::where('type', 2)->whereDate('delivery_date', '=', date('Y-m-d').' 00:00:00')->whereIn('stage',[3,4])->sum('grand_total_price') - (Order::where('type', 2)->whereDate('delivery_date', '=', date('Y-m-d').' 00:00:00')->whereIn('stage',[3,4])->sum('return_amount') - Order::where('type', 2)->whereDate('delivery_date', '>=', date('Y-m-d').' 00:00:00')->whereIn('stage',[3,4])->sum('paid_from_walet'));

        // total pos money
        // $totalPosMoney = Order::where('type', 4)->whereDate('created_at', '=', date('Y-m-d').' 00:00:00')->where('stage', 4)->sum('grand_total_price');

        return view('backend.index', compact('total_pending_orders', 'total_complete_orders', 'total_products', 'total_office_users', 'total_customers', 'totalOnlineMoney'));
    }
}
