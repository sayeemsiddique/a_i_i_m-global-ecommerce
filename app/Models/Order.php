<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class,'order_id', 'id');
    }

    public function orderUserInfo()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function paymentInfo()
    {
        return $this->belongsTo(Payment::class, 'id', 'order_id');
    }

    public function shippingAddressInfo()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address', 'id');
    }

    public function salePaymentInfo()
    {
        return $this->belongsTo(Payment::class, 'id', 'order_id')->where('type', 1);
    }

    public function inventoryDetails()
    {
        return $this->hasMany(Inventory::class, 'order_id', 'id');
    }

    public function orderReturnInfos()
    {
        return $this->hasMany(OrderReturn::class, 'order_id', 'id');
    }

    public function storeInfo()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }


}
