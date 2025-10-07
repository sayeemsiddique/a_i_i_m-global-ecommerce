<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Varient extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productVarientData()
    {
        return $this->hasMany(VarientData::class, 'varient_id', 'id');
    }

    public function productStock()
    {
        return $this->belongsTo(Stock::class, 'id', 'varient_id');
    }

    public function productInfo()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
