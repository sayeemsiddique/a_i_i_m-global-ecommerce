<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\Category;
use App\Models\Page;


class FrontFooter extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $main_categories = Category::withCount('SellProducts')
                        ->where([
                            'parent_id' => 0,
                            'status' => 1,
                        ])->orderBy('sl', 'asc')
                        ->limit(4)->get();
        $pages = Page::where([
            'status' => 1,
            'type' => 2,
        ])->orderBy('sl', 'asc')->select('id','slug','title')->get();
        return view('components.front-footer', compact('main_categories','pages'));
    }
}
