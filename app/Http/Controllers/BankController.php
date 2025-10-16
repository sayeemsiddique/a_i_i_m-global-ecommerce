<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/* included models */
use App\Models\Bank;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if(Gate::allows('all_banks', $user))
        {
            menuSubmenu('manage_bank', 'all_banks');

            $banks = Bank::latest()->paginate(20);

            return view('backend.admin.bank.index', compact('banks'));

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

        if(Gate::allows('add_bank', $user))
        {
            menuSubmenu('manage_bank', 'add_bank');

            return view('backend.admin.bank.create');

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
            'account_no'    => 'required',
            'name'          => 'required|max:255',
            'branch_name'   => 'required|max:255',
            'routing_no'    => 'required',
        ]);

        $bank = new Bank;

        $bank->name         = $request->name;
        $bank->branch_name  = $request->branch_name;
        $bank->account_no   = $request->account_no;
        $bank->routing_no   = $request->routing_no;
        $bank->created_by   = Auth::id();

        $bank->save();

        return redirect()->route('admin.bank.index')->with('success', 'Bank Account Added Successfully.');
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

        if (Gate::allows('manage_bank', $user))
        {
            if(Gate::allows('view_bank', $user))
            {
                $bank = Bank::with('user', 'user_update')
                                    ->where('id', $id)
                                    ->first();

                return view('backend.admin.bank.show', compact('bank'));

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

        if (Gate::allows('manage_bank', $user))
        {
            if(Gate::allows('edit_bank', $user))
            {
                $bank = Bank::where('id', $id)->first();

                return view('backend.admin.bank.edit', compact('bank'));

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
    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'account_no'    => 'required',
            'name'          => 'required|max:255',
            'branch_name'   => 'required|max:255',
            'routing_no'    => 'required',
        ]);

        $bank->name         = $request->name;
        $bank->branch_name  = $request->branch_name;
        $bank->account_no   = $request->account_no;
        $bank->routing_no   = $request->routing_no;
        $bank->status       = $request->status;
        $bank->updated_by   = Auth::id();

        $bank->save();

        return redirect()->route('admin.bank.index')->with('success','Bank Account Info Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bank::find($id)->delete();

        return redirect()->back()->with('success', 'Bank Account Deleted Successfully');
    }

    /**
     * Change status of the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Bank $bank)
    {
        $user = Auth::user();

        if (Gate::allows('manage_bank', $user))
        {
            if(Gate::allows('delete_bank', $user))
            {
                if ($bank->status == 0) {
                    $bank->status       = 1;
                    $bank->updated_by   = Auth::id();
                }
                else if ($bank->status == 1) {
                    $bank->status       = 0;
                    $bank->updated_by   = Auth::id();
                }

                $bank->save();

                return redirect()->route('admin.bank.index')->with('success', 'Bank Account Status Changed Successfully.');
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
