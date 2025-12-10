<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campaignProductInfo()
    {
        return $this->hasMany(CampaignProduct::class, 'campaign_id', 'id');
    }
}
