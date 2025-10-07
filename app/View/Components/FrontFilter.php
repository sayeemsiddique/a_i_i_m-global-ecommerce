<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\VarientType;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class FrontFilter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request->all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $cat_query = Category::where([
            'parent_id' => 0,
            'status' => 1,
        ])->orderBy('sl', 'asc');

        // if (isset($this->request['category']) and $this->request['category'] !='') {
        //     $cat_query->whereIn('id', [$this->request['category']]);
        // }

        $main_categories = $cat_query->with('childTreeInfo')->withCount('SellProducts')->get();

        $brands = Brand::withCount('BrandProducts')->get();
        $varient_datas = VarientType::with('varientValues')->get();

        Product::whereNotIn('status', [2])->where([
            'type' => 1
        ])->latest();

        $product_min_price = DB::table('products')->whereNotIn('status', [2])->where([
            'type' => 1,
            'has_varient' => 0,
        ])->min('price');

        $product_max_price = DB::table('products')->whereNotIn('status', [2])->where([
            'type' => 1,
            'has_varient' => 0,
        ])->max('price');

        $varient_max_price = DB::table('varients')->where('status', 1)->max('price');
        $varient_min_price = DB::table('varients')->where('status', 1)->min('price');

        if ($varient_max_price > $product_max_price) {
            $product_max_price = $varient_max_price;
        }
        
        if ($varient_min_price < $product_min_price) {
            $product_min_price = $varient_min_price;
        }

        

        return view('components.front-filter', compact('main_categories','brands','varient_datas','product_min_price','product_max_price'));
    }
}
