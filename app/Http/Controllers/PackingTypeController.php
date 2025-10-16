<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/* included models */
use App\Models\PackingType;
use App\Models\Category;

class PackingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if(Gate::allows('all_packing_types', $user))
        {
            menuSubmenu('manage_packing_type', 'all_packing_types');

            $packing_types = PackingType::latest()->paginate(20);

            return view('backend.admin.packingType.index', compact('packing_types'));

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
        $user = Auth::user();

        if(Gate::allows('add_packing_type', $user))
        {
            menuSubmenu('manage_packing_type', 'add_packing_type');

            $categories = Category::where('status', 1)->get();

            return view('backend.admin.packingType.create', compact('categories'));

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
            'name'          => 'required|max:255',
            'category_id'   => 'required',
            'weight'        => 'required|max:255',
            'charge'        => 'required',
        ]);

        $packing_type = new PackingType;

        $packing_type->name         = $request->name;
        $packing_type->category_id  = implode(',', $request->category_id);
        $packing_type->weight       = $request->weight;
        $packing_type->charge       = $request->charge;
        $packing_type->created_by   = Auth::id();

        $packing_type->save();

        return redirect()->route('admin.packing_type.index')->with('success', 'Packing Type Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        if (Gate::allows('manage_packing_type', $user))
        {
            if(Gate::allows('view_packing_type', $user))
            {
                $packing_type = PackingType::with('user', 'user_update')
                                    ->where('id', $id)
                                    ->first();

                return view('backend.admin.packingType.show', compact('packing_type'));

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        if (Gate::allows('manage_packing_type', $user))
        {
            if(Gate::allows('edit_packing_type', $user))
            {
                $packing_type = PackingType::where('id', $id)->first();

                return view('backend.admin.packingType.edit', compact('packing_type'));

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PackingType $packing_type)
    {
        $request->validate([
            'name'          => 'required|max:255',
            'category_id'   => 'required',
            'weight'        => 'required|max:255',
            'charge'        => 'required',
        ]);

        $packing_type->name         = $request->name;
        $packing_type->category_id  = implode(',', $request->category_id);
        $packing_type->weight       = $request->weight;
        $packing_type->charge       = $request->charge;
        $packing_type->updated_by   = Auth::id();

        $packing_type->save();

        return redirect()->route('admin.packing_type.index')->with('success', 'Packing Type Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PackingType::find($id)->delete();

        return redirect()->back()->with('success', 'Packing Type Deleted Successfully');
    }

    /**
     * Change status of the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statusChange(PackingType $packing_type)
    {
        $user = Auth::user();

        if (Gate::allows('manage_packing_type', $user))
        {
            if(Gate::allows('delete_packing_type', $user))
            {
                if ($packing_type->status == 0) {
                    $packing_type->status       = 1;
                    $packing_type->updated_by   = Auth::id();
                }
                else if ($packing_type->status == 1) {
                    $packing_type->status       = 0;
                    $packing_type->updated_by   = Auth::id();
                }

                $packing_type->save();

                return redirect()->route('admin.packing_type.index')->with('success', 'Packing Type Status Changed Successfully.');
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
