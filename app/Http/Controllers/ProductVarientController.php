<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Varient;
use App\Models\VarientData;
use App\Models\Stock;

class ProductVarientController extends Controller
{
    public function destroy($id, Request $request)
    {
        $varient = Varient::find($id);

        if ($varient) {
            VarientData::where('varient_id', $id)->delete();
            Stock::where('varient_id', $id)->delete();
            $varient->delete();
        }

        if($request->ajax()){
            return response()->json(['success' => 'Product Varient Removed'], 200);
        }

        return redirect()->back()->with('success', 'Product Varient Removed');

    } 
}
