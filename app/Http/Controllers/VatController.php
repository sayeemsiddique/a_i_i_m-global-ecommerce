<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Vat;

class VatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();


        if(Gate::allows('all_vat_type',$user))
        {
            menuSubmenu('product_setting', 'all_vat_type');

            $query = Vat::latest();

            if (isset($request->name) and $request->name != '') {
                $query->where('name', 'like', '%'.$request->name.'%');
            }

            $vats = $query->paginate(20);

            return view('backend.admin.vat.index',[
                'vats' => $vats
            ]);

        } else {
            abort(403);
        }

    }

    public function create()
    {
        $user = Auth::user();

        if(Gate::allows('add_vat_type',$user))
        {
            menuSubmenu('product_setting', 'add_vat_type');

            return view('backend.admin.vat.create');

        } else {
            abort(403);
        }

    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if(Gate::allows('add_vat_type',$user))
        {
            $request->validate([
                'name' => 'required|unique:vats',
                'type' => 'required',
                'value' => 'required',
            ]);

            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Vat::create($data);

            return redirect()->route('admin.vat.index')->with('success', 'Vat Added');

        } else {
            abort(403);
        }

    }

    public function edit($id)
    {
        $user = Auth::user();

        if(Gate::allows('edit_vat_type',$user))
        {
            menuSubmenuSubsubmeny('settings', 'product_setting', 'edit_vat_type');
            $vat = Vat::findOrFail($id);
            return view('backend.admin.vat.edit', compact('vat'));
        } else {
            abort(403);
        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:vats,name,' . $id,
            'type' => 'required',
            'value' => 'required',
        ]);

        $data = $request->all();
        $data['updated_by'] = auth()->user()->id;
        Vat::findOrFail($id)->update($data);

        return redirect()->route('admin.vat.index')->with('success', 'Vat Updated');
    }

    public function show($id)
    {
        $user = Auth::user();

        if(Gate::allows('view_vat_type',$user))
        {
            menuSubmenuSubsubmeny('settings', 'product_setting', 'view_vat_type');
            $vat = Vat::findOrFail($id);
            return view('backend.admin.vat.show', compact('vat'));
        } else {
            abort(403);
        }

    }

    public function destroy($id)
    {

        $user = Auth::user();

        if(Gate::allows('delete_vat_type',$user))
        {
            Vat::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'Vat Deleted');
        } else {
            abort(403);
        }

    }
}
