<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VoucherController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if(Gate::allows('all_voucher', $user))
        {
            menuSubmenu('settings', 'all_voucher');

            $vouchers = Voucher::latest()->paginate(10);
            return view('backend.admin.voucher.index', compact('vouchers'));

        }
        else
        {
            abort(403);
        }
    }

    public function create()
    {
        $user = Auth::user();

        if(Gate::allows('add_voucher', $user))
        {
            return view('admin.voucher.create');
        }
        else
        {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
        ]);
        $user = Auth::user();

        if(Gate::allows('add_voucher', $user))
        {
            Voucher::create($request->all());
            return redirect()->route('admin.voucher.index')->with('success', 'Voucher created successfully!');
        }
        else
        {
            abort(403);
        }

    }

    public function edit(Voucher $voucher)
    {
        if(Gate::allows('edit_voucher', $user))
        {
            return view('backend.admin.voucher.edit', compact('voucher'));
        }
        else
        {
            abort(403);
        }
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'type' => 'in:fixed,percent',
            'value' => 'numeric|min:0',
        ]);

        $user = Auth::user();

        if(Gate::allows('edit_voucher', $user))
        {
            $voucher->update($request->all());
            return redirect()->route('admin.voucher.index')->with('success', 'Voucher updated successfully!');
        }
        else
        {
            abort(403);
        }
    }

    public function destroy(Voucher $voucher)
    {
        $user = Auth::user();
        if(Gate::allows('delete_voucher', $user))
        {
            $voucher->delete();
            return back()->with('success', 'Voucher deleted successfully!');
        }
        else
        {
            abort(403);
        }
    }
}
