<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
    
    public function parentInfo()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
    
    public function childTreeInfo()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->orderBy('sl','asc')->with('childTreeInfo');
    }
    
    public function SellProducts()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')->where('type',1)->where('status',1);
    }
    
    public function ChildSellProducts()
    {
        return $this->hasMany(Product::class, 'sub_category_id', 'id')->where('type',1)->where('status',1);
    }
}
