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
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;

/* included models */
use App\Models\Division;
use App\Models\Designation;
use App\Models\User;
use App\Models\Role;
use App\Models\Level;
use App\Models\Countrie;
use App\Models\Subscriber;
use App\Models\Department;

// Mails
use App\Mail\ApproveUserMail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();

        if (Gate::allows('user_management', $user))
        {
            if(Gate::allows('all_users',$user))
            {
                menuSubmenu('roles', 'allUsers');

                $roles = Role::where('status', 1)->get();
                $departments = Department::where('status', 1)->get();
                $designations = Designation::where('status', 1)->get();

                $users = User::where('type', 0)->with('role', 'designation', 'department')->latest()->paginate(20);

                return view('backend.admin.user.index', compact('users', 'roles', 'designations', 'departments'));

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

    public function pending()
    {
        $user = Auth::user();

        if (Gate::allows('user_management', $user))
        {
            if(Gate::allows('all_pending_users', $user))
            {
                menuSubmenu('roles', 'allPendingUsers');

                $users = User::where('status', 3)
                                ->where(function ($query) {
                                    $query->where('type', 2)->orWhere('type', 3);
                                })
                                ->latest()
                                ->paginate(20);

                return view('backend.admin.user.pending', compact('users'));
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

    public function approved()
    {
        $user = Auth::user();

        if (Gate::allows('user_management', $user))
        {
            if(Gate::allows('all_approved_users', $user))
            {
                menuSubmenu('roles', 'allApprovedUsers');

                $users = User::where('status', 1)
                                ->where(function ($query) {
                                    $query->where('type', 2)->orWhere('type', 3);
                                })
                                ->latest()
                                ->paginate(20);

                return view('backend.admin.user.approved', compact('users'));
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
        $user = Auth::user();

        if (Gate::allows('user_management', $user))
        {
            if(Gate::allows('add_user',$user))
            {
                menuSubmenu('roles', 'addUser');

                $query = Role::where('status', 1);

                if(Auth::user()->role_id != 1){
                    $query = $query->where('id', '!=', 1);
                }
                $roles = $query->get();

                $designations = Designation::where('status', 1)->get();
                $departments = Department::where('status', 1)->get();

                return view('backend.admin.user.create', compact('roles', 'designations', 'departments'));

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
            'role_id'           => 'required',
            'department_id'     => 'required',
            'designation_id'    => 'required',
            'password'          => 'required|confirmed|min:8',
            'first_name'        => 'required|max:255',
            'last_name'         => 'required|max:255',
            'mobile'            => 'required|unique:users',
            'email'             => 'required|unique:users',
            // 'image'             => 'mimes:jpg,jpeg,png',
        ]);

        $user = new User;

        $user->role_id              = $request->role_id;
        $user->department_id        = $request->department_id;
        $user->designation_id       = $request->designation_id;
        $user->password             = bcrypt($request->password);
        $user->first_name           = $request->first_name;
        $user->last_name            = $request->last_name;
        $user->username             = Str::lower($request->first_name.$request->last_name);
        $user->present_address      = $request->present_address;
        $user->permanent_address    = $request->permanent_address;
        $user->mobile               = $request->mobile;
        $user->email                = $request->email;
        $user->status               = 1;
        $user->type                 = 0;
        $user->created_by           = Auth::id();

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

        return back()->with('success', 'User Created Successfully');
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

        if (Gate::allows('user_management', $userr))
        {
            if(Gate::allows('view_user',$userr))
            {

                $user = User::with('designation', 'user_create', 'user_update', 'department', 'role')
                            ->where('id', $id)
                            ->first();

                return view('backend.admin.user.show', compact('user'));

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

                return view('backend.admin.user.edit', compact('roles', 'designations', 'user', 'departments'));

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
    public function editProfile(Request $request,$username)
    {
        $userId = $request->user;
        $roles = Role::where('status', 1)->get();
        $designations = Designation::where('status', 1)->get();

        $user = User::find($userId);
        if(Auth::user()->id == $userId)
        {

            return view('backend.admin.user.editProfile', compact('roles', 'designations', 'user'));
        }
        else
        {
            abort(401);
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
                'role_id'           => 'required',
                'department_id'     => 'required',
                'designation_id'    => 'required',
                'password'          => 'required|confirmed|min:8',
                'first_name'        => 'required|max:255',
                'last_name'         => 'required|max:255',
                'mobile'            => 'required|unique:users,mobile,'.$user->id,
                'email'             => 'required|unique:users,email,'.$user->id,
                'image'             => 'mimes:jpg,jpeg,png',
            ]);
        } else {
            $request->validate([
                'role_id'           => 'required',
                'department_id'     => 'required',
                'designation_id'    => 'required',
                'first_name'        => 'required|max:255',
                'last_name'         => 'required|max:255',
                'mobile'            => 'required|unique:users,mobile,'.$user->id,
                'email'             => 'required|unique:users,email,'.$user->id,
                'image'             => 'mimes:jpg,jpeg,png',
            ]);
        }

        if ($request->role_id) {
            $user->role_id  = $request->role_id;
        }

        $user->first_name           = $request->first_name;
        $user->last_name            = $request->last_name;
        $user->department_id        = $request->department_id;
        $user->designation_id       = $request->designation_id;

        if ($request->password) {
            $user->password         = bcrypt($request->password);
        }

        $user->present_address      = $request->present_address;
        $user->permanent_address    = $request->permanent_address;
        $user->mobile               = $request->mobile;
        $user->email                = $request->email;
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

        return redirect()->route('admin.user.index')->with('success', 'User Information Updated Successfully');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $user)
    {
        // dd($request->all());
        $request->validate([
            'first_name'        => 'required|max:255',
            'last_name'         => 'required|max:255',
            'present_address'   => 'required',
            'permanent_address' => 'required',
            'mobile'            => 'required|unique:users,mobile,'.$user,
            'email'             => 'required|email|unique:users,email,'.$user,
        ]);

        $current_user = User::find($user);

        $current_user->first_name           = $request->first_name;
        $current_user->last_name            = $request->last_name;
        $current_user->present_address      = $request->present_address;
        $current_user->permanent_address    = $request->permanent_address;
        $current_user->mobile               = $request->mobile;
        $current_user->email                = $request->email;

        $current_user->updated_by           = Auth::id();

        if($request->hasFile('image'))
        {
            $cp = $request->file('image');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $current_user->id.'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            #delete old rows of profilepic
            Storage::disk('public')->put('users/'.$randomFileName, File::get($cp));

            if($current_user->image)
            {
                $f = 'users/'.$current_user->image;
                if(Storage::disk('public')->exists($f))
                {
                    Storage::disk('public')->delete($f);
                }
            }

            $current_user->image = $randomFileName;
            $current_user->save();
      	}

        $current_user->save();

        return back()->with('success', 'Profile Updated Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $user)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $old_password = User::where('id', $user)->first();
        if (!empty($old_password))
        {
            $password = Hash::check($request->current_password, $old_password->password);
            if ($password)
            {
                $current_user = User::find($user);
                $current_user->password = bcrypt($request->password);
                $current_user->updated_by = Auth::id();
                $current_user->save();

                return back()->with('success', 'Password Updated Successfully');

            } else {
                return back()->with('error', 'Password did not matched!');
            }
        } else {
            return back()->with('error', 'Password can not be empty');
        }
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

        if (Gate::allows('user_management', $userr))
        {
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

                return redirect()->route('admin.user.index')->with('success', 'User Blocked Successfully.');

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $userr = Auth::user();

        if (Gate::allows('user_management', $userr))
        {
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

                return redirect()->route('admin.user.index')->with('success', 'User Deleted Successfully.');

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

    public function approve(User $user)
    {
        $userr = Auth::user();

        if (Gate::allows('user_management', $userr))
        {
            if(Gate::allows('approve_user', $userr))
            {

                if ($user->status == 3) {
                    $user->status       = 1;
                    $user->updated_by   = Auth::id();
                }

                $user->save();

                // Send email notification
                Mail::to($user->email)->send(new ApproveUserMail($user));

                return redirect()->route('admin.user.approved')->with('success', 'User Approved Successfully.');

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
