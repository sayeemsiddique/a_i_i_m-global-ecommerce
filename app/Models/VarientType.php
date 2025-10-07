<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarientType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    
    
    public function varientValues()
    {
        return $this->hasMany(VarientValue::class, 'varient_type_id', 'id');
    }
    
    public function varientData()
    {
        return $this->hasMany(VarientData::class, 'varient_type_id', 'id');
    }
}
