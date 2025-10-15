<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\ShippingAddress;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;

class ShippingAddressController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // if (Gate::allows('shipping_management', $user)) {
            // if (Gate::allows('all_shipping_address', $user)) {
                menuSubmenu('shipping_setting', 'all_shipping_address');

                $query = ShippingAddress::where('user_id', $user->id)->latest();

                if ($request->recipient_name) {
                    $query->where('recipient_name', 'like', '%' . $request->recipient_name . '%');
                }

                $shippingAddresses = $query->paginate(20);

                return view('customer.shipping_address.index', [
                    'shippingAddresses' => $shippingAddresses
                ]);
            // } else {
            //     abort(403);
            // }
        // } else {
        //     abort(403);
        // }
    }

    public function create()
    {
        $user = Auth::user();

        // if (Gate::allows('shipping_management', $user)) {
            // if (Gate::allows('add_shipping_address', $user)) {
                $divisions = Division::orderBy('name')->where('status',1)->get();
                menuSubmenu('shipping_setting', 'add_shipping_address');
                return view('customer.shipping_address.create', [
                    'divisions' => $divisions
                ]);
        //     } else {
        //         abort(403);
        //     }
        // } else {
        //     abort(403);
        // }
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // if (Gate::allows('shipping_management', $user)) {
        //     if (Gate::allows('add_shipping_address', $user)) {
                $request->validate([
                    'recipient_name'   => 'required|string|max:255',
                    'phone_no'         => 'required|string|max:20',
                    'division_id'      => 'required|integer',
                    'district_id'      => 'required|integer',
                    'upazila_id'       => 'required|integer',
                    'address'          => 'required|string',
                    'address_catagory' => 'required|in:1,2',
                ]);

                $data = $request->all();
                unset($data['cart_id']);
                $data['user_id'] = $user->id;

                // If default shipping is checked, reset others
                if ($request->default_shipping == 1) {
                    ShippingAddress::where('user_id', $user->id)
                        ->update(['default_shipping' => 0]);
                }

                // If default billing is checked, reset others
                if ($request->default_billing == 1) {
                    ShippingAddress::where('user_id', $user->id)
                        ->update(['default_billing' => 0]);
                }

                ShippingAddress::create($data);

                if ($request->cart_id and $request->cart_id != '') {
                    return redirect()->route('checkout', ['transition' => 1, 'buy_now' => 1, 'cart_id' => $request->cart_id]);
                }

                return redirect()->route('shipping_address.index')
                                 ->with('success', 'Shipping Address Added');
        //     } else {
        //         abort(403);
        //     }
        // } else {
        //     abort(403);
        // }
    }

    public function edit($id)
    {
        $user = Auth::user();
        $id = Crypt::decryptString($id);

        // if (Gate::allows('shipping_management', $user)) {
        //     if (Gate::allows('edit_shipping_address', $user)) {
                $divisions = Division::orderBy('name')->where('status',1)->get();
                $shippingAddress = ShippingAddress::where('user_id', $user->id)
                                                  ->findOrFail($id);
                $districts = District::orderBy('name')->where('division_id', ($shippingAddress->division_id ?? 0))->where('status',1)->get();
                $upazilas = Upazila::orderBy('name')->where('district_id', ($shippingAddress->district_id ?? 0))->where('status',1)->get();

                return view('customer.shipping_address.edit', compact('shippingAddress','divisions','districts','upazilas'));
        //     } else {
        //         abort(403);
        //     }
        // } else {
        //     abort(403);
        // }
    }

    public function update(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        // if (Gate::allows('edit_shipping_address', $user)) {
            $user = Auth::user();

            $request->validate([
                'recipient_name'   => 'required|string|max:255',
                'phone_no'         => 'required|string|max:20',
                'division_id'      => 'required|integer',
                'district_id'      => 'required|integer',
                'upazila_id'       => 'required|integer',
                'address'          => 'required|string',
                'address_catagory' => 'required|in:1,2',
            ]);

            $shippingAddress = ShippingAddress::where('user_id', $user->id)->findOrFail($id);

            $data = $request->all();

            if ($request->default_shipping == 1) {
                ShippingAddress::where('user_id', $user->id)
                    ->update(['default_shipping' => 0]);
            }

            if ($request->default_billing == 1) {
                ShippingAddress::where('user_id', $user->id)
                    ->update(['default_billing' => 0]);
            }

            $shippingAddress->update($data);

            return redirect()->route('shipping_address.index')
                            ->with('success', 'Shipping Address Updated');
        // } else {
        //     abort(403);
        // }

    }

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $user = Auth::user();
        $shippingAddress = ShippingAddress::where('user_id', $user->id)->findOrFail($id);

        return view('customer.shipping_address.show', compact('shippingAddress'));
    }

    public function destroy($id)
    {
        $id = Crypt::decryptString($id);
        $user = Auth::user();
        $shippingAddress = ShippingAddress::where('user_id', $user->id)->findOrFail($id);

        $shippingAddress->delete();

        return redirect()->route('shipping_address.index')->with('success', 'Shipping Address Deleted');
    }
}
