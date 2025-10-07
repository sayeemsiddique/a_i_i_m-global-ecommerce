<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarientData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productInfo()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    public function varientTypeInfo()
    {
        return $this->belongsTo(VarientType::class, 'varient_type_id', 'id');
    }

}
