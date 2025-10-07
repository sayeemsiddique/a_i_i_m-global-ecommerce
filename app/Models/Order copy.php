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


}
