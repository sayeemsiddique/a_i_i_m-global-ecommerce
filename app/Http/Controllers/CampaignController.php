<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CampaignController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if(Gate::allows('all_campaign', $user))
        {
            menuSubmenu('settings', 'all_campaign');

            $campaigns = Campaign::latest()->paginate(10);
            return view('backend.admin.campaign.index', compact('campaigns'));

        }
        else
        {
            abort(403);
        }
    }

    public function create()
    {
        $user = Auth::user();

        if(Gate::allows('add_campaign', $user))
        {
            $products = Product::whereNotIn('status', [2,0])
            ->where('type', 1)
            ->with([
                'productVarient' => function($q) {
                    $q->where('status', 1)
                    ->select('id', 'product_id', 'price', 'discount_price');
                },
                'productVarient.productVarientData'
            ])
            ->select('id', 'name', 'price', 'discount_price','has_varient')
            ->latest()
            ->get();
            return view('backend.admin.campaign.create', compact('products'));
        }
        else
        {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:campaigns,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
        ]);
        $user = Auth::user();

        if(Gate::allows('add_campaign', $user))
        {
            Campaign::create($request->all());
            return redirect()->route('admin.campaign.index')->with('success', 'Campaign created successfully!');
        }
        else
        {
            abort(403);
        }

    }

    public function edit(Campaign $campaign)
    {
        $user = Auth::user();
        if(Gate::allows('edit_campaign', $user))
        {
            return view('backend.admin.campaign.edit', compact('campaign'));
        }
        else
        {
            abort(403);
        }
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'type' => 'in:fixed,percent',
            'value' => 'numeric|min:0',
        ]);

        $user = Auth::user();

        if(Gate::allows('edit_campaign', $user))
        {
            $campaign->update($request->all());
            return redirect()->route('admin.campaign.index')->with('success', 'Campaign updated successfully!');
        }
        else
        {
            abort(403);
        }
    }

    public function destroy(Campaign $campaign)
    {
        $user = Auth::user();
        if(Gate::allows('delete_campaign', $user))
        {
            $campaign->delete();
            return back()->with('success', 'Campaign deleted successfully!');
        }
        else
        {
            abort(403);
        }
    }
}
