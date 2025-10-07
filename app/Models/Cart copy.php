<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productInfo()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    public function varientInfo()
    {
        return $this->belongsTo(Varient::class, 'variation_id', 'id');
    }
    
    public static function stockInfo($product_id,$varient_id)
    {
        return Stock::where('product_id', $product_id)->where('varient_id', $varient_id)->latest()->first();
    }


}
