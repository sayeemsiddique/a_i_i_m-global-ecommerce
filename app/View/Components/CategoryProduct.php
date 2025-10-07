<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;

class CategoryProduct extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $products = Product::where([
            'category_id' => $this->data->id,
            'status' => 1,
            'type' => 1,
        ])->limit(10)->get();
        $category = $this->data;
        return view('components.category-product', compact('products','category'));
    }
}
