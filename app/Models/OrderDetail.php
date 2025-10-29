<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orderInfo()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function productInfo()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function varientDataInfo()
    {
        return $this->belongsTo(VarientData::class, 'varient_id', 'varient_id');
    }

    public function varientData()
    {
        return $this->hasMany(VarientData::class, 'varient_id', 'varient_id');
    }

    public function returnOrderDetailsInfo()
    {
        return $this->hasMany(OrderReturnDetail::class, 'order_detail_id', 'id');
    }

    public function returnOrderInfo()
    {
        return $this->hasMany(OrderReturn::class, 'order_id', 'order_id');
    }

}
