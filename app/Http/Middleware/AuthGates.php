<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use Symfony\Component\HttpFoundation\Response;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (auth()->user()->type != 0) {
        //     return redirect()->route('index')->with('error', 'You are not authorise.');
        // }
        // $roles = Role::count();
        // for($i=1 ; $i<=$roles ; $i++)
        // {
        //     if(auth()->user() == null)
        //     {
        //         return redirect()->route('index');
        //         break;

        //     }elseif(auth()->user()->status != 1) {
        //         Auth::logout();
        //         return redirect()->route('index')->with('error', 'Your account is not verified. Please verify your account first.');
        //         break;

        //     } elseif(auth()->user()->role_id == $i) {
        //         if ($roleId = Auth::user()->role_id) {
        //             Gate::before(function (User $user, $i) {
        //                     if ($user->role_id === $i) {
        //                         return true;
        //                     }
        //                 }
        //             );

        //             $role = Role::find($roleId);

        //             foreach ($role->permissions ?? [] as $permission) {
        //                 $perm = Permission::where('id',$permission->permission_id)->first();

        //                 if(isset($perm->name_en) and $perm->name_en!='') {
        //                     Gate::define($perm->name_en, function ($role) use ($perm) {
        //                         $rolePerms = RolePermission::where('role_id', $role->role_id)->get();

        //                         foreach($rolePerms as  $key => $rolePerm )
        //                         {
        //                             $a = array($perm->id);

        //                             if (in_array($rolePerm->permission_id, $a)) {
        //                                 return true;
        //                             }
        //                         }

        //                     });
        //                 }
        //             }

        //         }

        //         return $next($request);
        //     }
        //     else
        //     {
        //         $i+1;
        //     }
        // }

        if(auth()->user() == null)
        {
            return redirect()->route('login');
        }

        if (auth()->user()->type != 0) {
            return redirect()->route('index')->with('error', 'You are not authorise.');
        }

        if(auth()->user()->status != 1) {
            Auth::logout();
            return redirect()->route('index')->with('error', 'Your account is not verified. Please verify your account first.');
            // break;
        }

        // if ((auth()->user()->user_type ?? 0) == 4) { // trainee
        //     return redirect()->route('student.userDashboard');
        // }

        // if ((auth()->user()->user_type ?? 0) == 8) { // industry vendor
        //     return redirect()->route('industry.industryDashboard');
        // }

        $role = Role::where('id',(auth()->user()->role_id ?? 0))->where('status',1)->with('permissions')->first();


        if($role)
        {
            if(count($role->permissions ?? []) > 0) {
                $permission_ids = $role->permissions->pluck('permission_id')->toArray();
                $permissions = Permission::whereIn('id',$permission_ids)->get();
                foreach ($permissions as $key => $permission_data) {
                    Gate::define($permission_data->name_en, function ($role) use ($permission_data) {
                        return true;
                    });
                }

            } else {
                $permission_ids = [0];

            }

            return $next($request);
        } else
        {
            return redirect('/')->with('error', __('pages.Role Not Found'));
        }

    }

}
