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

        $main_categories = $cat_query->select('id', 'name', 'sl', 'parent_id')
        ->with([
            'childTreeInfo' => function ($query) {
                $query->select('id', 'name', 'parent_id', 'sl')
                    ->withCount([
                        'SellProducts as sell_products_count' => function ($q) {
                            $q->where([
                                'status' => 1,
                                'type' => 1,
                            ]);
                        }
                    ]);
            }
        ])
        ->withCount([
            'SellProducts as sell_products_count' => function ($q) {
                $q->where([
                    'status' => 1,
                    'type' => 1,
                ]);
            }
        ])
        ->get();

        $brands = Brand::select('id','name')->withCount([
            'BrandProducts as brand_products_count' => function ($q) {
                $q->where('status', 1)->where('type', 1);
            }
        ])->get();

        $varient_datas = VarientType::with('varientValues')->get();

        $product_min_price = DB::table('products')->whereNotIn('status', [2])->where([
            'type' => 1,
            'status' => 1,
        ])->select('id','sl_price')->min('sl_price');

        $product_max_price = DB::table('products')->whereNotIn('status', [2])->where([
            'type' => 1,
            'status' => 1,
        ])->select('id','sl_price')->max('sl_price');

        $varient_max_price = DB::table('varients')->where('status', 1)->select('price')->max('price');
        $varient_min_price = DB::table('varients')->where('status', 1)->select('price')->min('price');

        if ($varient_max_price > $product_max_price) {
            $product_max_price = $varient_max_price;
        }

        if ($varient_min_price < $product_min_price) {
            $product_min_price = $varient_min_price;
        }

        return view('components.front-filter', compact('main_categories','brands','varient_datas','product_min_price','product_max_price'));
    }
}
