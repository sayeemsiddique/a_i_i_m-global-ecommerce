<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Gate;

use App\Models\Page;

class PageController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('manage_page', $user))
        {
            menuSubmenu('manage_page', 'manage_page');

            $query = Page::latest();
            if ($request->name and $request->name != '') {
                $query->where('title', 'like', '%'.$request->name.'%');
            }
            $pages = $query->paginate(20);

            return view('backend.admin.page.index', compact('pages'));

        }
        else
        {
            abort(403);
        }
    }

    public function create()
    {
        $user = Auth::user();

        if(Gate::allows('add_page', $user))
        {
            menuSubmenu('manage_page', 'add_page');


            return view('backend.admin.page.create');

        }
        else
        {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('add_page', $user))
        {
            $request->validate([
                'title' => 'required|string',
                'description_en' => 'required|string',
                // 'meta_title' => 'nullable|string|max:255',
                // 'meta_description' => 'nullable|string',
                // 'type' => 'required|integer|in:1,2',
                // 'status' => 'required|integer|in:0,1',
            ]);

            $slug = $this->generateUniqueSlug($request->title);

            $page = new Page();
            $page->title = $request->title;
            $page->meta_title = $request->meta_title;
            $page->sl = $request->sl;
            $page->content = $request->description_en;
            $page->type = $request->type;
            $page->status = $request->status;
            $page->slug = $slug;
            $page->save();

            return redirect()->route('admin.page.index')->with('success', 'Page created successfully...!');

        }
        else
        {
            abort(403);
        }
    }

    public function show($id)
    {
        $user = Auth::user();

        if(Gate::allows('view_page', $user))
        {
            menuSubmenu('manage_page', 'manage_page');

            $page = Page::findOrFail($id);

            return view('backend.admin.page.show', compact('page'));

        }
        else
        {
            abort(403);
        }
    }

    public function edit($id)
    {
        $user = Auth::user();

        if(Gate::allows('edit_page', $user))
        {
            menuSubmenu('manage_page', 'manage_page');

            $page = Page::findOrFail($id);

            return view('backend.admin.page.edit', compact('page'));

        }
        else
        {
            abort(403);
        }
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if(Gate::allows('edit_page', $user))
        {
            $request->validate([
                'title' => 'required|string',
                'description_en' => 'required|string',
                // 'meta_title' => 'nullable|string|max:255',
                // 'meta_description' => 'nullable|string',
                // 'status' => 'required|integer|in:0,1',
            ]);

            $slug = $this->generateUniqueSlug($request->title);

            $page = Page::findOrFail($id);
            $page->title = $request->title;
            $page->sl = $request->sl;
            $page->meta_title = $request->meta_title;
            $page->content = $request->description_en;
            $page->status = $request->status;
            $page->type = $request->type;
            $page->slug = $slug;
            $page->save();

            return redirect()->route('admin.page.index')->with('success', 'Page updated successfully...!');

        }
        else
        {
            abort(403);
        }
    }
    //About us page backend
    public function aboutus()
    {
        $user = Auth::user();

        if (Gate::allows('manage_page', $user))
        {
            if(Gate::allows('edit_page',$user))
            {
                menuSubmenu('manage_page', 'about_us');

                $page = Page::where('type', 1)->first();
                return view('backend.admin.page.aboutus', compact('page'));

            }
            else
            {
                abort(403);
            }
        }
        else
        {
            abort(403);
        }
    }

    // update aboutus
    public function updateAboutus(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('manage_page', $user))
        {
            if(Gate::allows('edit_page', $user))
            {

                $aboutus = Page::where('type', 1)->first();
                $aboutus->title = $request->title;
                $aboutus->meta_title = $request->tagline;
                $aboutus->meta_description = $request->description;
                $aboutus->save();
                return back()->with('success', 'About-Us page updated successfully...!');

            }else{
                abort(403);
            }
        }else{
            abort(403);
        }

    }

    // Contact us page backend
    public function contactus()
    {
        $user = Auth::user();

        if (Gate::allows('manage_page', $user))
        {
            if(Gate::allows('edit_page',$user))
            {
                menuSubmenu('manage_page', 'contact_us');

                $page = Page::where('type', 2)->first();
                return view('backend.admin.page.contactus', compact('page'));

            }
            else
            {
                abort(403);
            }
        }
        else
        {
            abort(403);
        }
    }

    // Update contactus
    public function updateContactus(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('manage_page', $user))
        {
            if(Gate::allows('edit_page', $user))
            {

                $contactus = Page::where('type', 2)->first();
                $contactus->meta_description = $request->description;
                $contactus->save();
                return back()->with('success', 'Contact-Us page updated successfully...!');

            }else{
                abort(403);
            }
        }else{
            abort(403);
        }

    }

    public function delete($id)
    {
        $user = Auth::user();

        if(Gate::allows('delete_page', $user))
        {

            $contactus = Page::where('id', $id)->delete();

            return back()->with('success', 'Contact-Us page deleted successfully...!');

        }else{
            abort(403);
        }

    }

    public function pageDetail($type)
    {
        $user = Auth::user();

        if (Gate::allows('manage_page', $user))
        {
            if(Gate::allows('edit_page',$user))
            {
                menuSubmenu('manage_page', 'pageDetail');

                $page = Page::where('type', $type)->first();

                return view('backend.admin.page.page', compact('page'));
            }
            else
            {
                abort(403);
            }
        }
        else
        {
            abort(403);
        }
    }

    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;

        $count = 1;
        while (
            Page::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
