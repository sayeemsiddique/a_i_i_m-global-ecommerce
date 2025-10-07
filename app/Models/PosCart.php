<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosCart extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id', 'id');
    }
    public function varientData()
    {
        return $this->belongsTo(VarientData::class,'varient_id', 'varient_id');
    }
}
