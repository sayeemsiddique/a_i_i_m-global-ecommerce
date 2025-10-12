<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

/* included models */
use App\Models\Department;
use App\Models\Level;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // if (Gate::allows('manage_department', $user)) 
        // {
            if(Gate::allows('all_department',$user))
            {            
                menuSubmenu('roles', 'all_department');

                $departments = Department::latest()->paginate(25);

                return view('backend.admin.department.index',[
                    'departments' => $departments
                ]);
                
            }
            else
            {
                abort(403);
            }
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

        // if (Gate::allows('manage_department', $user)) 
        // {
        //     if(Gate::allows('add_department',$user))
        //     {            
                menuSubmenu('department', 'add_department');

                // $levels = Level::get();

                return view('backend.admin.department.create');
                
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|max:255',
        ]);

        $department = new Department;

        $department->name       = $request->name;
        $department->created_by     = Auth::id();

        $department->save();

        return redirect()->route('admin.department.index')->with('success','Department Created Successfully.');
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

        // if (Gate::allows('manage_department', $user)) 
        // {
        //     if(Gate::allows('view_department',$user))
        //     {            
                $department = Department::with('user', 'user_update')
                                ->where('id', $id)
                                ->first();

                return view('backend.admin.department.show', compact('department'));
                
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        // if (Gate::allows('manage_department', $user)) 
        // {
        //     if(Gate::allows('edit_department',$user))
        //     {            
                // $levels = Level::get();

                $department = Department::where('id', $id)->first();

                return view('backend.admin.department.edit', compact('department'));
                
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
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name'      => 'required|max:255',
        ]);

        $department->name        = $request->name;
        $department->status         = $request->status;
        $department->updated_by     = Auth::id();

        $department->save();

        return redirect()->route('admin.department.index')->with('success', 'Department Updated Successfully.');
    }


    /**
     * Change status of the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Department $department)
    {
        $user = Auth::user();

        // if (Gate::allows('manage_department', $user)) 
        // {
        //     if(Gate::allows('delete_department',$user))
        //     {            
                if ($department->status == 0) {
                    $department->status       = 1;
                    $department->updated_by   = Auth::id();
                }
                else if ($department->status == 1) {
                    $department->status       = 0;
                    $department->updated_by   = Auth::id();
                }
        
                $department->save();
        
                return redirect()->route('admin.department.index')->with('success', 'department Status Changed Successfully.');
                
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
        Department::find($id)->delete();
        return redirect()->back()->with('success', 'Department Deleted Successfully');
    }
}
