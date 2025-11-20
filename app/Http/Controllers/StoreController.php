<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Upazila;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;

class StoreController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if(Gate::allows('all_store', $user))
        {
            menuSubmenu('settings', 'all_store');

            $upazilas = Upazila::where('status', 1)->get();

            $stores = Store::latest()->paginate(20);
            return view('backend.admin.store.index', compact('stores','upazilas'));

        }
        else
        {
            abort(403);
        }
    }

    public function create()
    {
        $user = Auth::user();

        if(Gate::allows('add_store', $user))
        {
            return view('admin.store.create');
        }
        else
        {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'status' => 'required',
        ]);
        $user = Auth::user();

        if(Gate::allows('add_store', $user))
        {
            $data = $request->all();
            unset($data['files']);
            if ($request->upazila_id) {
                $upazila = Upazila::find($request->upazila_id);
                if ($upazila) {
                    $data['district_id'] = $upazila->district_id;
                    if ($upazila->districtInfo) {
                        $data['division_id'] = $upazila->districtInfo->division_id ?? 0;
                    }
                }
            }
            Store::create($data);
            return redirect()->route('admin.store.index')->with('success', 'Store created successfully!');
        }
        else
        {
            abort(403);
        }

    }

    public function edit($id)
    {
        $user = Auth::user();
        if(Gate::allows('edit_store', $user))
        {
            $id = Crypt::decryptString($id);
            $store = Store::find($id);
            $upazilas = Upazila::where('status', 1)->get();
            return view('backend.admin.store.edit', compact('store','upazilas'));
        }
        else
        {
            abort(403);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'status' => 'required',
        ]);

        $user = Auth::user();

        if(Gate::allows('edit_store', $user))
        {

            $id = Crypt::decryptString($id);
            $data = $request->all();
            unset($data['files']);
            unset($data['_token']);
            unset($data['_method']);
            if ($request->upazila_id) {
                $upazila = Upazila::find($request->upazila_id);
                if ($upazila) {
                    $data['district_id'] = $upazila->district_id;
                    if ($upazila->districtInfo) {
                        $data['division_id'] = $upazila->districtInfo->division_id ?? 0;
                    }
                }
            }
            Store::where('id',$id)->update($data);
            return redirect()->route('admin.store.index')->with('success', 'Store updated successfully!');
        }
        else
        {
            abort(403);
        }
    }

    public function destroy(Store $store)
    {
        $user = Auth::user();
        if(Gate::allows('delete_store', $user))
        {
            $store->delete();
            return back()->with('success', 'Store deleted successfully!');
        }
        else
        {
            abort(403);
        }
    }
}
