<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function userInfo()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderReturnDetail::class, 'return_order_id', 'id');
    }

    public function mainOrderInfo()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
