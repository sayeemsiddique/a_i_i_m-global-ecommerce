<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
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
        //     if(Gate::allows('all_roles',$user))
        //     {
                menuSubmenu('roles','allRoles');
        
                $query = Role::latest();
                if(Auth::user()->role_id != 1){
                    $query = $query->where('id','!=',1);
                }
                $roles = $query->paginate(25);

                return view('backend.admin.role.index',[
                    'roles' => $roles
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
    public function create(Request $request)
    {
        
        $validation = Validator::make($request->all(),
        [ 
            'role_name' => ['required', 'string', 'max:255','min:3'],
            'display_name' => ['required']
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

        $role = new Role;

        $role->name = $request->role_name;
        $role->status = true;
        $role->ordering = 1;
        $role->created_by = Auth::id();
        $role->display_name = $request->display_name;
        $role->save();

        return back()->with('success','Role Added Successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validation = Validator::make($request->all(),
        [ 
            'role_name' => ['required', 'string', 'max:255','min:3'],
            'display_name' => ['required', 'string', 'max:255','min:3'],
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
        
        $role = Role::find($id);

        $role->name = $request->role_name;
        $role->status = true;
        $role->display_name = $request->display_name;
        $role->updated_by = Auth::id();
        $role->save();

        return back()->with('success','Role Updated Successfully.');

    }

    public function statusChange(Request $request,$id)
    {

        $user = Auth::user();

        // if (Gate::allows('user_management', $user)) 
        // {
        //     if(Gate::allows('delete_role',$user))
        //     {                
                
                
                $role = Role::find($id);
                if($role->status == false){
                    $role->status = true;
                } else {
                    $role->status = false;
                }
                
                $role->updated_by = Auth::id();
                $role->save();
                return back()->with('success','Role Disable Successfully.');
                
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
