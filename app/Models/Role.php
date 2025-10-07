<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User','created_by');
    }

    public function permissions()
    {        
        return $this->hasMany('App\Models\RolePermission','role_id','id');
    }
}
