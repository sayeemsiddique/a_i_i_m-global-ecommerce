<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // if (Gate::allows('user_management', $user))
        // {
        //     if(Gate::allows('all_permissions',$user))
        //     {


                menuSubmenu('roles','permissions');

                $query = Permission::where('status', 1);

                if ($request->searchText and !empty($request->searchText)) {
                    $query->where('name_en', 'like', '%' . $request->searchText . '%')
                          ->orWhere('name_bn', 'like', '%' . $request->searchText . '%');
                }

                $permissions = $query->latest()->paginate(20);

                return view('backend.admin.permission.index',[
                    'permissions' =>  $permissions
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
        // $validation = Validator::make($request->all(),
        // [
        //     // 'perm_name_bn' => ['required', 'string', 'max:255','min:3'],
        //     'perm_name_en' => ['required', 'string', 'max:255','min:3'],
        // ]);

        $validation = Validator::make($request->all(), [
            'perm_name_en' => [
                'required',
                'string',
                'max:255',
                'min:3',
                'unique:permissions,name_en',
            ],
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

        $permission = new Permission;

        $permission->name_en = $request->perm_name_en;
        $permission->name_bn = $request->perm_name_en;
        $permission->created_by = Auth::id();
        $permission->save();

        return back()->with('success','Permission Added Successfully.');
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
    public function edit($id)
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
    public function update(Request $request, $id)
    {

        $request->validate([
            'perm_name_en' => 'required|unique:permissions,name_en,' . $id,
        ]);
        $permission = Permission::find($id);
        $permission->name_en = $request->perm_name_en;
        $permission->name_bn = $request->perm_name_en;
        $permission->updated_by = Auth::id();
        $permission->save();

        return back()->with('success','Permission Updated Successfully.');
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
