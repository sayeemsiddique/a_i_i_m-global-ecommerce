<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VarientType;
use Auth;
use Illuminate\Support\Facades\Gate;

class VarientTypeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('all_varient_type',$user))
        {
            menuSubmenu('product_setting', 'all_varient_type');
            $query = VarientType::latest();

            if (isset($request->name) and $request->name != '') {
                $query->where('name', 'like', '%'.$request->name.'%');
            }

            $varienttypes = $query->paginate(20);

            return view('backend.admin.varienttype.index',[
                'varienttypes' => $varienttypes
            ]);

        } else {
            abort(403);
        }

    }

    public function create()
    {
        $user = Auth::user();

        if (Gate::allows('inventory_management', $user))
        {
            if(Gate::allows('add_varient_type',$user))
            {
                menuSubmenu('product_setting', 'create_varient_type');

                return view('backend.admin.varienttype.create');

            } else {
                abort(403);
            }
        } else {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();


        if(Gate::allows('add_varient_type',$user))
        {
            $request->validate([
                'name' => 'required|unique:varient_types',
            ]);

            $data = $request->all();
            $data['created_by'] = auth()->user()->id;


            VarientType::create($data);
            return redirect()->route('admin.varienttype.index')->with('success', 'Varient type Added');

        } else {
            abort(403);
        }

    }

    public function edit($id)
    {
        $user = Auth::user();
        if(Gate::allows('edit_varient_type',$user))
        {
            menuSubmenuSubsubmeny('settings', 'product_setting', 'edit_varient_type');
            $varienttype = VarientType::findOrFail($id);
            return view('backend.admin.varienttype.edit', compact('varienttype'));
        } else {
            abort(403);
        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:varient_types,name,' . $id,
        ]);

        $data = $request->all();

        $data['updated_by'] = auth()->user()->id;


        VarientType::findOrFail($id)->update($data);
        return redirect()->route('admin.varienttype.index')->with('success', 'Varient type Updated');
    }

    public function show($id)
    {
        $user = Auth::user();
        if(Gate::allows('view_varient_type',$user))
        {
            menuSubmenuSubsubmeny('settings', 'product_setting', 'view_varient_type');
            $varienttype = VarientType::findOrFail($id);
            return view('backend.admin.varienttype.show', compact('varienttype'));
        } else {
            abort(403);
        }

    }

    public function destroy($id)
    {
        $user = Auth::user();
        if(Gate::allows('delete_varient_type',$user))
        {
            VarientType::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Varient type Deleted');
        } else {
            abort(403);
        }

    }
}
