<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function varientDataInfo()
    {
        return $this->hasMany(VarientData::class, 'varient_id', 'varient_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productVarient($value)
    {
        if($value == 0)
        {
            return "-";
        }
        else 
        {
            $data = VarientData::where('varient_id',$value)->first();
            
            return $data;
        }
    }

    public function varient()
    {
        return $this->belongsTo(Varient::class, 'varient_id', 'id');
    }
}
