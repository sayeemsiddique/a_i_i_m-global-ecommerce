<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (Gate::allows('inventory_management', $user))
        {
            if(Gate::allows('all_brand',$user))
            {
                menuSubmenu('product_setting', 'all_brand');
                $query = Brand::latest();

                if (isset($request->name) and $request->name != '') {
                    $query->where('name', 'like', '%'.$request->name.'%');
                }

                $brands = $query->paginate(20);

                return view('backend.admin.brand.index',[
                    'brands' => $brands
                ]);

            } else {
                abort(403);
            }
        } else {
            abort(403);
        }
    }

    public function create()
    {
        $user = Auth::user();

        if (Gate::allows('inventory_management', $user))
        {
            if(Gate::allows('add_brand',$user))
            {
                menuSubmenu('product_setting', 'add_brand');
                return view('backend.admin.brand.create');

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

        if (Gate::allows('inventory_management', $user))
        {
            if(Gate::allows('add_brand',$user))
            {
                $request->validate([
                    'name' => 'required|unique:brands',
                ]);

                $data = $request->all();
                unset($data['files']);
                if ($request->file('image')) {

                    $path = $request->file('image')->store('/public/brand');

                    $path = Str::replace('public/brand', '', $path);
                    $data['image'] = Str::replace('/', '', $path);
                }

                if ($request->file('banner')) {

                    $path = $request->file('banner')->store('/public/brand');

                    $path = Str::replace('public/brand', '', $path);
                    $data['banner'] = Str::replace('/', '', $path);
                }

                $data['slug'] = Str::of($request->name)->slug('-');
                $data['created_by'] = auth()->user()->id;
                $data['meta_title'] = $request->name ?? '';
                $data['meta_description'] = $request->description ?? '';


                Brand::create($data);
                return redirect()->route('admin.brand.index')->with('success', 'Brand Added');

            } else {
                abort(403);
            }
        } else {
            abort(403);
        }
    }

    public function edit($id)
    {
        $user = Auth::user();

        if (Gate::allows('inventory_management', $user))
        {
            if(Gate::allows('edit_brand',$user))
            {
                $brand = Brand::findOrFail($id);
                return view('backend.admin.brand.edit', compact('brand'));
            }
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,' . $id,
        ]);

        $data = $request->all();

        unset($data['files']);

        $brand = Brand::findOrFail($id);

        if ($request->file('image')) {

            if ($brand->image && Storage::exists('public/brand/' . $brand->image)) {
                Storage::delete('public/brand/' . $brand->image);
            }

            $path = $request->file('image')->store('/public/brand');

            $path = Str::replace('public/brand', '', $path);
            $data['image'] = Str::replace('/', '', $path);
        }

        if ($request->file('banner')) {
            if ($brand->banner && Storage::exists('public/brand/' . $brand->banner)) {
                Storage::delete('public/brand/' . $brand->banner);
            }

            $path = $request->file('banner')->store('/public/brand');

            $path = Str::replace('public/brand', '', $path);
            $data['banner'] = Str::replace('/', '', $path);
        }

        $data['slug'] = Str::of($request->name)->slug('-');
        $data['update_by'] = auth()->user()->id;
        $data['meta_title'] = $request->name ?? '';
        if (isset($request->description) and $request->description != '') {
            $data['meta_description'] = $request->description ?? '';
        }


        Brand::findOrFail($id)->update($data);
        return redirect()->route('admin.brand.index')->with('success', 'Brand Updated');
    }

    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.admin.brand.show', compact('brand'));
    }

    public function destroy($id)
    {
        Brand::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Brand Deleted');
    }
}
