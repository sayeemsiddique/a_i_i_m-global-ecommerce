<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productInfo()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function varientInfo()
    {
        return $this->belongsTo(Varient::class, 'varient_id', 'id');
    }

    public function campaignInfo()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }
}
