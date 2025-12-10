<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Product;
use App\Models\Varient;
use App\Models\CampaignProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if(Gate::allows('all_campaign', $user))
        {
            menuSubmenu('settings', 'all_campaign');

            $campaigns = Campaign::withCount('campaignProductInfo')->latest()->paginate(10);
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
        // dd($request->all());
        $request->validate([
            'title' => 'required|unique:campaigns,title',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $user = Auth::user();

        if(Gate::allows('add_campaign', $user))
        {

            DB::transaction(function () use ($request,$user) {

                if ($request->file('image')) {
                    $cp = $request->file('image');
                    $extension = strtolower($cp->getClientOriginalExtension());
                    $randomFileName = 'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

                    Storage::disk('public')->put('campaign/'.$randomFileName, File::get($cp));

                    $campaign['image'] = $randomFileName;
                }

                $campaign['title'] = $request->title;
                $campaign['start_date'] = $request->start_date;
                $campaign['end_date'] = $request->end_date;
                $campaign['status'] = $request->status ?? 0;
                $campaign['featured'] = $request->featured ?? 0;
                $campaign['slug'] = Str::of($request->title)->slug('-');
                $campaign['discount'] = $request->campaign_product_discount;
                $campaign['discount_type'] = $request->campaign_discount_type;
                $campaign['created_by'] = $user->id;

                $campaign = Campaign::create($campaign);

                foreach ($request->product_id as $key => $productid) {

                    $product_id = explode('-',$productid)[0] ?? 0;
                    $varient_id = explode('-',$productid)[1] ?? 0;

                    $price = 0;
                    if ($varient_id > 0) {
                        $product_info = Varient::where([
                            'product_id' => $product_id,
                            'id' => $varient_id
                        ])->first();
                    } else {
                        $product_info = Product::where('id', $product_id)->first();
                    }

                    if (($request->discount_type[$key] ?? 0) == 1) {

                        if ($product_info) {
                            $price = $product_info->price - ($request->product_discount[$key] ?? 0);
                        }

                        if ($price < 0) {
                            $price = 0;
                        }

                    } else if(($request->discount_type[$key] ?? 0) == 2) {
                        if ($product_info) {
                            $price = $product_info->price - (($product_info->price * ($request->product_discount[$key] ?? 0)) / 100);
                        }

                        if ($price < 0) {
                            $price = 0;
                        }
                    }

                    $data['campaign_id'] = $campaign->id;
                    $data['product_id'] = $product_id;
                    $data['varient_id'] = $varient_id;
                    $data['discount'] = $request->product_discount[$key] ?? 0;
                    $data['discount_type'] = $request->discount_type[$key] ?? 0;
                    $data['price'] = round($price ?? 0);
                    $data['created_by'] = $user->id;

                    CampaignProduct::create($data);
                }

            });

            if($request->ajax()){
                return response()->json(['success' => 'Campaign Added'], 200);
            }
            return redirect()->route('admin.campaign.index')->with('success', 'Campaign created successfully!');
        }
        else
        {
            abort(403);
        }

    }

    public function edit($id)
    {
        $user = Auth::user();
        if(Gate::allows('edit_campaign', $user))
        {
            $campaign = Campaign::where('id',$id)->with('campaignProductInfo')->first();

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
            return view('backend.admin.campaign.edit', compact('campaign','products'));
        }
        else
        {
            abort(403);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:campaigns,title,' . $id,
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $user = Auth::user();

        if(Gate::allows('edit_campaign', $user))
        {
            DB::transaction(function () use ($request,$user,$id) {

                $campaign = Campaign::find($id);

                if ($request->file('image')) {
                    $cp = $request->file('image');
                    $extension = strtolower($cp->getClientOriginalExtension());
                    $randomFileName = 'image'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

                    Storage::disk('public')->put('campaign/'.$randomFileName, File::get($cp));

                    $campaign['image'] = $randomFileName;
                }

                $campaign->title = $request->title;
                $campaign->start_date = $request->start_date;
                $campaign->end_date = $request->end_date;
                $campaign->status = $request->status ?? 0;
                $campaign->featured = $request->featured ?? 0;
                $campaign->slug = Str::of($request->title)->slug('-');
                $campaign->discount = $request->campaign_product_discount;
                $campaign->discount_type = $request->campaign_discount_type;
                $campaign->updated_by = $user->id;

                $campaign->save();

                // if (count($request->campaign_product_table_id ?? []) > 0) {
                    // CampaignProduct::whereNotIn('id', $request->campaign_product_table_id ?? [])->delete();
                // }

                foreach ($request->product_id as $key => $productid) {

                    $product_id = explode('-',$productid)[0] ?? 0;
                    $varient_id = explode('-',$productid)[1] ?? 0;

                    $price = 0;
                    if ($varient_id > 0) {
                        $product_info = Varient::where([
                            'product_id' => $product_id,
                            'id' => $varient_id
                        ])->first();
                    } else {
                        $product_info = Product::where('id', $product_id)->first();
                    }

                    if (($request->discount_type[$key] ?? 0) == 1) {

                        if ($product_info) {
                            $price = $product_info->price - ($request->product_discount[$key] ?? 0);
                        }

                        if ($price < 0) {
                            $price = 0;
                        }

                    } else if(($request->discount_type[$key] ?? 0) == 2) {
                        if ($product_info) {
                            $price = $product_info->price - (($product_info->price * ($request->product_discount[$key] ?? 0)) / 100);
                        }

                        if ($price < 0) {
                            $price = 0;
                        }
                    }

                    // $data['campaign_id'] = $campaign->id;
                    // $data['product_id'] = $product_id;
                    // $data['varient_id'] = $varient_id;
                    $data['discount'] = $request->product_discount[$key] ?? 0;
                    $data['discount_type'] = $request->discount_type[$key] ?? 0;
                    $data['price'] = round($price ?? 0);
                    $data['created_by'] = $user->id;
                    $data['updated_by'] = $user->id;

                    CampaignProduct::updateOrCreate(
                        ['campaign_id' => $campaign->id, 'product_id' => $product_id, 'varient_id' => $varient_id],
                        $data
                    );
                }

            });

            if($request->ajax()){
                return response()->json(['success' => 'Campaign Added'], 200);
            }
            return redirect()->route('admin.campaign.index')->with('success', 'Campaign created successfully!');
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
