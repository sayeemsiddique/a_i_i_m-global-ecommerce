<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productInfo()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function varientInfo()
    {
        return $this->belongsTo(Varient::class, 'variation_id', 'id');
    }

    public static function stockInfo($product_id,$varient_id)
    {
        return Stock::where('product_id', $product_id)->where('varient_id', $varient_id)->latest()->first();
    }

    public function varientDataInfo()
    {
        return $this->hasMany(VarientData::class, 'varient_id', 'variation_id');
    }

    public function cartProductPrice()
    {
        $now = Carbon::now();
        $campaign_in_product = CampaignProduct::where([
                        'product_id' => $this->product_id,
                        'varient_id' => $this->variation_id,
                    ])->whereHas('campaignInfo', function ($query) use ($now) {
                        $query->where('start_date', '<=', $now)->where('end_date', '>=', $now)->where('status',1);
                    })->with('campaignInfo')->first();

        if ($campaign_in_product) {
            return round($campaign_in_product->price ?? 0);
        }

        if ($this->variation_id == 0) {
            return $this->productInfo->discount_price ?? 0;
        } else {
            return $this->varientInfo->discount_price ?? 0;
        }
    }

    public function getProductInCampaign()
    {
        $now = Carbon::now();
        $campaign_in_product = CampaignProduct::where([
                        'product_id' => $this->product_id,
                        'varient_id' => $this->variation_id,
                    ])->whereHas('campaignInfo', function ($query) use ($now) {
                        $query->where('start_date', '<=', $now)->where('end_date', '>=', $now)->where('status',1);
                    })->with('campaignInfo')->first();


        return $campaign_in_product;

    }

    public function cartProductPriceOnTime($time)
    {
        $now = $time;
        $campaign_in_product = CampaignProduct::where([
                        'product_id' => $this->product_id,
                        'varient_id' => $this->variation_id,
                    ])->whereHas('campaignInfo', function ($query) use ($now) {
                        $query->where('start_date', '<=', $now)->where('end_date', '>=', $now)->where('status',1);
                    })->with('campaignInfo')->first();

        if ($campaign_in_product) {
            return round($campaign_in_product->price ?? 0);
        }

        if ($this->variation_id == 0) {
            return $this->productInfo->discount_price ?? 0;
        } else {
            return $this->varientInfo->discount_price ?? 0;
        }
    }

    public function getProductInCampaignOnTime($time)
    {
        $now = $time;
        $campaign_in_product = CampaignProduct::where([
                        'product_id' => $this->product_id,
                        'varient_id' => $this->variation_id,
                    ])->whereHas('campaignInfo', function ($query) use ($now) {
                        $query->where('start_date', '<=', $now)->where('end_date', '>=', $now)->where('status',1);
                    })->with('campaignInfo')->first();


        return $campaign_in_product;

    }


}
