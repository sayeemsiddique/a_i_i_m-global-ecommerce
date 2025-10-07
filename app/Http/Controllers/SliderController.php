<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        menuSubmenu('settings', 'manage_slider');

        $user = Auth::user();

        if (Gate::allows('manage_slider', $user)) 
        {
            if (Gate::allows('all_slider', $user)) 
            {
                $query = Slider::latest();

                if($request->name and $request->name != ''){
                    $query = $query->where('title', 'like', '%'.$request->name.'%');
                }

                $sliders = $query->paginate(25)->withQueryString();

                return view('backend.admin.slider.index', compact('sliders'));
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        menuSubmenu('settings', 'manage_slider');

        $user = Auth::user();

        if (Gate::allows('manage_slider', $user)) 
        {
            if (Gate::allows('add_slider', $user)) 
            {
                return view('backend.admin.slider.create');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|max:255',
            'image'      => 'required',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {

            $cp = $request->file('image');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = 'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('slider/'.$randomFileName, File::get($cp));

            $data['image'] = $randomFileName;
        }
        
        $data['created_by'] = Auth::id();

        Slider::create($data);

        return redirect()->route('admin.slider.index')->with('success','Slider Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        menuSubmenu('settings', 'manage_slider');

        $user = Auth::user();

        if (Gate::allows('manage_slider', $user))
        {
            if (Gate::allows('view_slider', $user))
            {
                $slider = Slider::with('createdBy', 'updatedBy')->where('id', $id)->first();

                return view('backend.admin.slider.view', compact('slider'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        menuSubmenu('settings', 'manage_slider');

        $userr = Auth::user();
    
        if(Gate::allows('manage_slider', $userr))
        {
            if(Gate::allows('edit_slider',$userr))
            {
                $slider = Slider::where('id', $id)->first();

                return view('backend.admin.slider.edit', compact('slider'));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        
        unset($data['_token']);
        unset($data['_method']);

        if(!$request->has('status')){
            $data['status'] = 0;
        }
        if ($request->hasFile('image')) {
            $slides = Slider::find($id);

            if($slides->image !=''){
                $image_path = storage_path().'/app/public/'.$slides->image;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
                
            }

            $cp = $request->file('image');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = 'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('slider/'.$randomFileName, File::get($cp));

            $data['image'] = $randomFileName;

        }

        $data['updated_by'] = Auth::user()->id;
        
        Slider::where('id', $id)->update($data);
        return back()->with('success', 'Slider Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        //
    }

    public function delete($id)
    {
        $slider = Slider::findOrFail($id);
        if($slider->image !=''){
            $image_path = storage_path().'/app/public/'.$slider->image;
            if(file_exists($image_path)){
                unlink($image_path);
            }
        }
        $slider->delete();

        return back()->with('success', 'Slider Deleted Successfully');
    }
}
