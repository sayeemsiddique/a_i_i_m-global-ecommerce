<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $guarded = [];

    public function isValid($orderTotal)
    {
        $today = Carbon::today();
        if ($this->status != 1) return false;
        if ($this->start_date && $today->lt(Carbon::parse($this->start_date))) return false;
        if ($this->end_date && $today->gt(Carbon::parse($this->end_date))) return false;
        if ($this->max_uses > 0 && $this->used_count >= $this->max_uses) return false;
        if ($this->min_order_amount && $orderTotal < $this->min_order_amount) return false;

        return true;
    }

    public function applyDiscount($orderTotal)
    {
        if ($this->type === 'percent') {
            return $orderTotal * ($this->value / 100);
        }
        return $this->value;
    }
}
