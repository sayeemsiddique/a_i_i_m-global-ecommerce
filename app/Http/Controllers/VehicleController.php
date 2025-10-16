<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/* included models */
use App\Models\Vehicle;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if(Gate::allows('all_vehicles', $user))
        {
            menuSubmenuSubsubmeny('settings', 'org_setting', 'all_vehicles');

            $vehicles = Vehicle::latest()->paginate(20);

            return view('backend.admin.vehicle.index', compact('vehicles'));

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

        if(Gate::allows('add_vehicle', $user))
        {
            menuSubmenuSubsubmeny('settings', 'org_setting', 'all_vehicles');

            return view('backend.admin.vehicle.create');

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
            'type'          => 'required',
            'name'          => 'required|max:255',
            'vehicle_no'    => 'required',
            'weight'        => 'required',
        ]);

        $vehicle = new Vehicle;

        $vehicle->type          = $request->type;
        $vehicle->name          = $request->name;
        $vehicle->vehicle_no    = $request->vehicle_no;
        $vehicle->weight        = $request->weight;
        $vehicle->license_no    = $request->license_no;
        $vehicle->created_by    = Auth::id();

        $vehicle->save();

        if($request->hasFile('license'))
        {
            $cp = $request->file('license');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $vehicle->id.'license'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('license/'.$randomFileName, File::get($cp));

            $vehicle->license = $randomFileName;
            $vehicle->save();
      	}

        return redirect()->route('admin.vehicle.index')->with('success','Vehicle Added Successfully.');
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

        if (Gate::allows('manage_vehicle', $user))
        {
            if(Gate::allows('view_vehicle',$user))
            {
                $vehicle = Vehicle::with('user', 'user_update')
                                    ->where('id', $id)
                                    ->first();

                return view('backend.admin.vehicle.show', compact('vehicle'));

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

        if (Gate::allows('manage_vehicle', $user))
        {
            if(Gate::allows('edit_vehicle',$user))
            {
                $vehicle = Vehicle::where('id', $id)->first();

                return view('backend.admin.vehicle.edit', compact('vehicle'));

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
    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'type'          => 'required',
            'name'          => 'required|max:255',
            'vehicle_no'    => 'required',
            'weight'        => 'required',
        ]);

        $vehicle->type          = $request->type;
        $vehicle->name          = $request->name;
        $vehicle->vehicle_no    = $request->vehicle_no;
        $vehicle->weight        = $request->weight;
        $vehicle->license_no    = $request->license_no;
        $vehicle->status        = $request->status;
        $vehicle->updated_by    = Auth::id();

        $vehicle->save();

        if($request->hasFile('new_license'))
        {
            $cp = $request->file('new_license');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = $vehicle->id.'license'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            #delete old rows of profilepic
            Storage::disk('public')->put('license/'.$randomFileName, File::get($cp));

            if($vehicle->license)
            {
                $f = 'license/'.$vehicle->license;

                if(Storage::disk('public')->exists($f))
                {
                    Storage::disk('public')->delete($f);
                }
            }

            $vehicle->license = $randomFileName;
            $vehicle->save();
      	} else {
            $vehicle->license = $request->license;
            $vehicle->save();
        }

        return redirect()->route('admin.vehicle.index')->with('success','Vehicle Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Vehicle::find($id)->delete();

        return redirect()->back()->with('success', 'Vehicle Deleted Successfully');
    }


    /**
     * Change status of the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Vehicle $vehicle)
    {
        $user = Auth::user();

        if (Gate::allows('manage_vehicle', $user))
        {
            if(Gate::allows('delete_vehicle',$user))
            {
                if ($vehicle->status == 0) {
                    $vehicle->status       = 1;
                    $vehicle->updated_by   = Auth::id();
                }
                else if ($vehicle->status == 1) {
                    $vehicle->status       = 0;
                    $vehicle->updated_by   = Auth::id();
                }

                $vehicle->save();

                return redirect()->route('admin.vehicle.index')->with('success', 'Vehicle Status Changed Successfully.');

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
