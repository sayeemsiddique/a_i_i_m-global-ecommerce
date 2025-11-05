<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use DB;
use Validator;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();

        // if (Gate::allows('user_management', $user))
        // {
        //     if(Gate::allows('assign_permission_list',$user))
        //     {
                menuSubmenu('roles','assignPerm');

                // $rolePerms = RolePermission::where('role_id','<>',1)->groupBy('role_id')->latest()->paginate(20);
                $query = Role::latest();

                if (auth()->user()->id != 1) {
                    $query = $query->where('id','!=', 1);
                }

                $rolePerms = $query->paginate(20);


                return view('backend.admin.rolePermission.index',[
                    'rolePerms' => $rolePerms
                ]);

        //     }
        //     else
        //     {
        //         abort(403);
        //     }
        // }
        // else
        // {
        //     abort(403);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        // if (Gate::allows('user_management', $user))
        // {
        //     if(Gate::allows('assign_permission',$user))
        //     {

                menuSubmenu('roles','assignPerm');

                $permissions = Permission::where('status', 1)->get();
                $roles = Role::where('status',true)->get();

                return view('backend.admin.rolePermission.create',[
                    'roles' => $roles,
                    'permissions' => $permissions
                ]);

        //     }
        //     else
        //     {
        //         abort(403);
        //     }
        // }
        // else
        // {
        //     abort(403);
        // }

    }

    public function selectNewRole(Request $request)
    {
        $users = User::where('email', 'like', '%'.$request->q.'%')
        ->orWhere('username', 'like', '%'.$request->q.'%')
        ->orWhere('mobile', 'like', '%'.$request->q.'%')
        ->select(['id','mobile', 'email','username'])->take(30)->get();
        if($users->count())
        {
            if ($request->ajax())
            {
                return $users;
            }
        }
        else
        {
            if ($request->ajax())
            {
                return $users;
            }
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

        $validation = Validator::make($request->all(),
        [
            'role' => ['required'],
            'permission' => ['required'],
        ]);

        if($validation->fails())
        {

            if($request->ajax())
            {
                return Response()->json(array(
                    'success' => false,
                    'errors' => $validation->errors()->toArray(),
                    'sessionMessage' => 'Please, fillup the form correctly and try again.'
                ));
            }

            return back()
            ->withInput()
            ->withErrors($validation);
        }

        $perms = $request->permission;
        foreach($perms as $perm)
        {

            $rolePerm = new RolePermission;

            // $rolePerm->user_id = $request->user;
            $rolePerm->permission_id = $perm;
            $rolePerm->role_id = $request->role;
            $rolePerm->created_by = Auth::id();

            $rolePerm->save();
        }

        return redirect()->route('admin.rolePermission.index')->with('success','Role Permission Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $user = Auth::user();

        // if (Gate::allows('user_management', $user))
        // {
        //     if(Gate::allows('edit_assign_permission',$user))
        //     {


                $perms = RolePermission::where('role_id',$id)->pluck('permission_id','permission_id')->toArray();

                $permissions = Permission::where('status', 1)->get();
                $roles = Role::where('status',true)->get();
                $role_info = Role::where('id',$id)->first();

                return view('backend.admin.rolePermission.edit',[
                    'roles' => $roles,
                    'permissions' => $permissions,
                    'perms' => $perms,
                    'role_info' => $role_info,
                ]);

        //     }
        //     else
        //     {
        //         abort(403);
        //     }
        // }
        // else
        // {
        //     abort(403);
        // }


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validation = Validator::make($request->all(),
        [
            'permission' => ['required'],
        ]);

        if($validation->fails())
        {

            if($request->ajax())
            {
                return Response()->json(array(
                    'success' => false,
                    'errors' => $validation->errors()->toArray(),
                    'sessionMessage' => 'Please, fillup the form correctly and try again.'
                ));
            }

            return back()
            ->withInput()
            ->withErrors($validation);
        }


        RolePermission::where('role_id',$id)->delete();
        $userId = auth()->user()->id;

        $perms = $request->permission;
        foreach ($perms as $perm) {
            $data[] = [
                'permission_id' => $perm,
                'role_id'       => $id,
                'created_by'    => $userId,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        }

        RolePermission::insert($data);
        // foreach($perms as $perm)
        // {

        //     $rolePerm = new RolePermission;

        //     $rolePerm->permission_id = $perm;
        //     $rolePerm->role_id = $id;
        //     $rolePerm->created_by = Auth::id();

        //     $rolePerm->save();
        // }

        return redirect()->route('admin.rolePermission.index')->with('success','Role Permission Updated Successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RolePermission $rolePermission)
    {

    }
}
