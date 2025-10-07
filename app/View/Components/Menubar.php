<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;
use App\Models\Cart;

class Menubar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $categories = Category::where([
            'parent_id' =>  0,
            'status' =>  1,
        ])->with('childTreeInfo')->get();

        if (auth()->check()) {
            $carts = Cart::where('user_id', auth()->user()->id)->with('productInfo','varientInfo')->latest()->get();
        } else {
            $carts = [];
        }

        return view('components.menubar', compact('categories','carts'));
    }
}
