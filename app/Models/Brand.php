<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'update_by', 'id');
    }

    public function BrandProducts()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id')->where('type',1)->where('status',1);
    }
}
