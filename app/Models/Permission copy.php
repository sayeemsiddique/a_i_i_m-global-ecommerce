<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    
    public function user()
    {
        return $this->belongsTo('App\Models\User','created_by');
    }

    public function rolePerm()
    {
        return $this->belongsTo('App\Models\RolePermission','id','permission_id');
    }

    public function roleId($id)
    {
        if($this->rolePerm()->where('role_id',$id)->first())
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
}
