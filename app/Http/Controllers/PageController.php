<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Gate;

use App\Models\Page;

class PageController extends Controller
{
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
}
