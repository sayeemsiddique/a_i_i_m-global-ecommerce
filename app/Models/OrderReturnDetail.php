<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReturnDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productInfo()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function orderReturnInfo()
    {
        return $this->belongsTo(Product::class, 'return_order_id', 'id');
    }

    public function varientDataInfo()
    {
        return $this->hasMany(VarientData::class, 'varient_id', 'varient_id');
    }
}
