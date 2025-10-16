<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/* included models */
use App\Models\Division;
use App\Models\Designation;
use App\Models\User;
use App\Models\Role;
use App\Models\Level;
use App\Models\Countrie;
use App\Models\Subscriber;
use App\Models\Department;

use App\Mail\ApproveUserMail;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function all_customer()
    {
        $user = Auth::user();

        if(Gate::allows('all_customers', $user))
        {
            menuSubmenuSubsubmeny('settings', 'customer_setting', 'all_customers');

            $users = User::where('type', 1)->where('status', '!=', 2)->latest()->paginate(20);

            return view('backend.admin.customer.index', compact('users'));

        }
        else
        {
            abort(403);
        }
    }
    public function all_corporate()
    {
        $user = Auth::user();

        if(Gate::allows('all_corporates', $user))
        {
            menuSubmenuSubsubmeny('settings', 'corporate_setting', 'all_corporates');

            $users = User::where('type', 2)->where('status', '!=', 2)->latest()->paginate(20);

            return view('backend.admin.customer.index', compact('users'));

        }
        else
        {
            abort(403);
        }
    }
    public function all_dealer()
    {
        $user = Auth::user();

        if(Gate::allows('all_dealers', $user))
        {
            menuSubmenuSubsubmeny('settings', 'dealer_setting', 'all_dealers');

            $users = User::where('type', 3)->where('status', '!=', 2)->latest()->paginate(20);

            return view('backend.admin.customer.index', compact('users'));

        }
        else
        {
            abort(403);
        }
    }

    public function pending_corporate()
    {
        $user = Auth::user();

        if(Gate::allows('pending_corporate', $user))
        {
            menuSubmenuSubsubmeny('settings', 'corporate_setting', 'pending_corporate');

            $users = User::where('status', 3)
                            ->where(function ($query) {
                                $query->where('type', 2);
                            })
                            ->latest()
                            ->paginate(20);

            return view('backend.admin.customer.pending', compact('users'));
        }
        else
        {
            abort(403);
        }
    }
    public function pending_dealer()
    {
        $user = Auth::user();

        if(Gate::allows('pending_dealer', $user))
        {
            menuSubmenuSubsubmeny('settings', 'dealer_setting', 'pending_dealer');

            $users = User::where('status', 3)
                            ->where(function ($query) {
                                $query->where('type', 3);
                            })
                            ->latest()
                            ->paginate(20);

            return view('backend.admin.customer.pending', compact('users'));
        }
        else
        {
            abort(403);
        }
    }

    public function approved_corporate()
    {
        $user = Auth::user();

        if(Gate::allows('approved_corporate', $user))
        {
            menuSubmenuSubsubmeny('settings', 'corporate_setting', 'approved_corporate');

            $users = User::where('status', 1)
                            ->where(function ($query) {
                                $query->where('type', 2);
                            })
                            ->latest()
                            ->paginate(20);

            return view('backend.admin.customer.pending', compact('users'));
        }
        else
        {
            abort(403);
        }
    }
    public function approved_dealer()
    {
        $user = Auth::user();

        if(Gate::allows('approved_dealer', $user))
        {
            menuSubmenuSubsubmeny('settings', 'dealer_setting', 'approved_dealer');

            $users = User::where('status', 1)
                            ->where(function ($query) {
                                $query->where('type', 3);
                            })
                            ->latest()
                            ->paginate(20);

            return view('backend.admin.customer.pending', compact('users'));
        }
        else
        {
            abort(403);
        }
    }

    public function blocked_customer()
    {
        $user = Auth::user();

        if(Gate::allows('blocked_customer', $user))
        {
            menuSubmenuSubsubmeny('settings', 'customer_setting', 'blocked_customer');

            $users = User::where('status', 0)
                            ->where(function ($query) {
                                $query->where('type', 1);
                            })
                            ->latest()
                            ->paginate(20);

            return view('backend.admin.customer.blocked', compact('users'));
        }
        else
        {
            abort(403);
        }
    }
    public function blocked_corporate()
    {
        $user = Auth::user();

        if(Gate::allows('blocked_corporate', $user))
        {
            menuSubmenuSubsubmeny('settings', 'corporate_setting', 'blocked_corporate');

            $users = User::where('status', 0)
                            ->where(function ($query) {
                                $query->where('type', 2);
                            })
                            ->latest()
                            ->paginate(20);

            return view('backend.admin.customer.blocked', compact('users'));
        }
        else
        {
            abort(403);
        }
    }
    public function blocked_dealer()
    {
        $user = Auth::user();

        if(Gate::allows('blocked_dealer', $user))
        {
            menuSubmenuSubsubmeny('settings', 'dealer_setting', 'blocked_dealer');

            $users = User::where('status', 0)
                            ->where(function ($query) {
                                $query->where('type', 3);
                            })
                            ->latest()
                            ->paginate(20);

            return view('backend.admin.customer.blocked', compact('users'));
        }
        else
        {
            abort(403);
        }
    }

    public function declined_corporate()
    {
        $user = Auth::user();

        if(Gate::allows('declined_corporate', $user))
        {
            menuSubmenuSubsubmeny('settings', 'corporate_setting', 'declined_corporate');

            $users = User::where('status', 2)
                            ->where(function ($query) {
                                $query->where('type', 2);
                            })
                            ->latest()
                            ->paginate(20);

            return view('backend.admin.customer.declined', compact('users'));
        }
        else
        {
            abort(403);
        }
    }
    public function declined_dealer()
    {
        $user = Auth::user();

        if(Gate::allows('declined_dealer', $user))
        {
            menuSubmenuSubsubmeny('settings', 'dealer_setting', 'declined_dealer');

            $users = User::where('status', 2)
                            ->where(function ($query) {
                                $query->where('type', 3);
                            })
                            ->latest()
                            ->paginate(20);

            return view('backend.admin.customer.declined', compact('users'));
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
    public function create_customer()
    {
        $user = Auth::user();

        if(Gate::allows('add_customer', $user))
        {
            menuSubmenuSubsubmeny('settings', 'customer_setting', 'add_customer');

            return view('backend.admin.customer.createCustomer');
        }
        else
        {
            abort(403);
        }
    }

    public function create_corporate()
    {
        $user = Auth::user();

        if(Gate::allows('add_corporate', $user))
        {
            menuSubmenuSubsubmeny('settings', 'corporate_setting', 'add_corporate');

            return view('backend.admin.customer.createCorporate');
        }
        else
        {
            abort(403);
        }
    }

    public function create_dealer()
    {
        $user = Auth::user();

        if(Gate::allows('add_dealer', $user))
        {
            menuSubmenuSubsubmeny('settings', 'dealer_setting', 'add_dealer');

            return view('backend.admin.customer.createDealer');
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
        if ($request->type == 1) {
            $request->validate([
                'password'          => 'required|confirmed|min:8',
                'first_name'        => 'required|max:255',
                'last_name'         => 'required|max:255',
                'mobile'            => 'required|unique:users',
                'image'             => 'mimes:jpg,jpeg,png',
            ]);
        } elseif ($request->type == 2 || $request->type == 3) {
            $request->validate([
                'password'          => 'required|confirmed|min:8',
                'first_name'        => 'required|max:255',
                'last_name'         => 'required|max:255',
                'mobile'            => 'required|unique:users',
                'image'             => 'mimes:jpg,jpeg,png',
                'nid_no'            => 'required',
                'nid'               => 'mimes:jpg,jpeg,png',
                'bin_no'            => 'required',
                'bin'               => 'mimes:jpg,jpeg,png',
                'tin_no'            => 'required',
                'tin'               => 'mimes:jpg,jpeg,png',
            ]);
        }

        $user = new User;

        $user->role_id              = 7;
        $user->password             = bcrypt($request->password);
        $user->first_name           = $request->first_name;
        $user->last_name            = $request->last_name;
        $user->present_address      = $request->present_address;
        $user->mobile               = $request->mobile;
        $user->email                = $request->email;
        $user->nid_no               = $request->nid_no;
        $user->bin_no               = $request->bin_no;
        $user->tin_no               = $request->tin_no;

        $user->status               = 1;
        $user->type                 = $request->type;
        $user->created_by           = Auth::id();

        $user->save();

        $user->username             = Str::lower($request->first_name.$request->last_name.$user->id);
        $user->save();

        if($request->hasFile('image'))
        {
            $cp = $request->file('image');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('users/'.$randomFileName, File::get($cp));

            $user->image = $randomFileName;
            $user->save();
      	}
        if($request->hasFile('nid'))
        {
            $cp = $request->file('nid');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'nid'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('nid/'.$randomFileName, File::get($cp));

            $user->nid = $randomFileName;
            $user->save();
        }
        if($request->hasFile('bin'))
        {
            $cp = $request->file('bin');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'bin'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('bin/'.$randomFileName, File::get($cp));

            $user->bin = $randomFileName;
            $user->save();
        }
        if($request->hasFile('tin'))
        {
            $cp = $request->file('tin');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'tin'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('tin/'.$randomFileName, File::get($cp));

            $user->tin = $randomFileName;
            $user->save();
        }

        return back()->with('success', 'Account Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userr = Auth::user();

        if(Gate::allows('view_user', $userr))
        {
            $user = User::with('user_create', 'user_update')
                        ->where('id', $id)
                        ->first();

            return view('backend.admin.customer.show', compact('user'));
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
        $userr = Auth::user();

        if (Gate::allows('user_management', $userr))
        {
            if(Gate::allows('edit_user',$userr))
            {
                $query = Role::where('status', 1);

                if(Auth::user()->role_id != 1){
                    $query = $query->where('id', '!=', 1);
                }

                $roles = $query->get();
                $designations = Designation::where('status', 1)->get();
                $departments = Department::where('status', 1)->get();

                $user = User::where('id', $id)->first();

                return view('backend.admin.customer.edit', compact('roles', 'designations', 'user', 'departments'));

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
    public function update(Request $request, User $user)
    {
        if ($request->password) {
            $request->validate([
                'password'          => 'required|confirmed|min:8',
                'first_name'        => 'required|max:255',
                'last_name'         => 'required|max:255',
                'mobile'            => 'required|unique:users,mobile,'.$user->id,
                'email'             => 'required|unique:users,email,'.$user->id,
            ]);
        } else {
            $request->validate([
                'first_name'        => 'required|max:255',
                'last_name'         => 'required|max:255',
                'mobile'            => 'required|unique:users,mobile,'.$user->id,
                'email'             => 'required|unique:users,email,'.$user->id,
                'image'             => 'mimes:jpg,jpeg,png',
            ]);
        }

        $user->first_name           = $request->first_name;
        $user->last_name            = $request->last_name;

        if ($request->password) {
            $user->password         = bcrypt($request->password);
        }

        $user->present_address      = $request->present_address;
        $user->mobile               = $request->mobile;
        $user->email                = $request->email;
        $user->nid_no               = $request->nid_no;
        $user->tin_no               = $request->tin_no;
        $user->bin_no               = $request->bin_no;
        $user->status               = $request->status;
        $user->updated_by           = Auth::id();

        $user->save();

        if($request->hasFile('image'))
        {
            $cp = $request->file('image');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            #delete old rows of profilepic
            Storage::disk('public')->put('users/'.$randomFileName, File::get($cp));

            if($user->image)
            {
                $f = 'users/'.$user->image;
                if(Storage::disk('public')->exists($f))
                {
                    Storage::disk('public')->delete($f);
                }
            }

            $user->image = $randomFileName;
            $user->save();
      	}
        if($request->hasFile('nid'))
        {
            $cp = $request->file('nid');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'nid'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            #delete old rows of profilepic
            Storage::disk('public')->put('nid/'.$randomFileName, File::get($cp));

            if($user->nid)
            {
                $f = 'nid/'.$user->nid;
                if(Storage::disk('public')->exists($f))
                {
                    Storage::disk('public')->delete($f);
                }
            }

            $user->nid = $randomFileName;
            $user->save();
      	}
        if($request->hasFile('tin'))
        {
            $cp = $request->file('tin');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'tin'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            #delete old rows of profilepic
            Storage::disk('public')->put('tin/'.$randomFileName, File::get($cp));

            if($user->tin)
            {
                $f = 'tin/'.$user->tin;
                if(Storage::disk('public')->exists($f))
                {
                    Storage::disk('public')->delete($f);
                }
            }

            $user->tin = $randomFileName;
            $user->save();
      	}
        if($request->hasFile('bin'))
        {
            $cp = $request->file('bin');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $user->id.'bin'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            #delete old rows of profilepic
            Storage::disk('public')->put('bin/'.$randomFileName, File::get($cp));

            if($user->bin)
            {
                $f = 'bin/'.$user->bin;
                if(Storage::disk('public')->exists($f))
                {
                    Storage::disk('public')->delete($f);
                }
            }

            $user->bin = $randomFileName;
            $user->save();
        }

        return redirect()->back()->with('success', 'User Information Updated Successfully');
    }

    /**
     * Change status of the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block(User $user)
    {
        $userr = Auth::user();

        if(Gate::allows('block_user',$userr))
        {

            if ($user->status == 0) {
                $user->status       = 1;
                $user->updated_by   = Auth::id();
            }
            else if ($user->status == 1) {
                $user->status       = 0;
                $user->updated_by   = Auth::id();
            }

            $user->save();

            return redirect()->back()->with('success', 'User Blocked Successfully.');

        }
        else
        {
            abort(403);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $userr = Auth::user();

        if(Gate::allows('delete_user',$userr))
        {

            if ($user->status == 2) {
                $user->status       = 1;
                $user->updated_by   = Auth::id();
            }
            else if ($user->status == 0 || $user->status == 1) {
                $user->status       = 2;
                $user->updated_by   = Auth::id();
            }

            $user->save();

            return redirect()->back()->with('success', 'User Deleted Successfully.');

        }
        else
        {
            abort(403);
        }
    }

    public function approve(User $user)
    {
        $userr = Auth::user();

        if(Gate::allows('approve_user', $userr))
        {

            if ($user->status == 3) {
                $user->status       = 1;
                $user->updated_by   = Auth::id();
            }

            $user->save();

            // Send email notification
            Mail::to($user->email)->send(new ApproveUserMail($user));

            return redirect()->back()->with('success', 'User Approved Successfully.');
        }
        else
        {
            abort(403);
        }
    }
}
