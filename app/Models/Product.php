<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public $appends = array('custom_price');

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'update_by', 'id');
    }
    
    public function productInfo()
    {
        return $this->belongsTo(ProductInfo::class, 'id', 'product_id');
    }
    
    public function productGallery()
    {
        return $this->hasMany(Upload::class, 'service_id', 'id')->where('table', 'product');
    }
    
    public function productAllStock()
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }
    
    // product has varient
    public function productStock()
    {
        return $this->hasMany(Stock::class, 'product_id', 'id')->where('varient_id', '!=', 0);
    }
    
    // product with no varient
    public function productSingleStock()
    {
        return $this->belongsTo(Stock::class, 'id', 'product_id')->where('varient_id', 0);
    }
    
    public function productVarient()
    {
        return $this->hasMany(Varient::class, 'product_id', 'id');
    }
    
    public function productVarientData()
    {
        return $this->hasMany(VarientData::class, 'product_id', 'id');
    }
    
    public function productSubCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id', 'id');
    }
    
    public function productCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
    public function productBrand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function cheapVarient()
    {
        return $this->hasOne(Varient::class, 'product_id')->where('status',1)->orderBy('price', 'asc');
    }
    
    public function expensiveVarient()
    {
        return $this->hasOne(Varient::class, 'product_id')->where('status',1)->orderBy('price', 'desc');
    }


}
