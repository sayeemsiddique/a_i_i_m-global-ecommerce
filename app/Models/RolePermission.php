<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User','created_by');

    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function permission()
	{        
		return $this->belongsTo('App\Models\Permission');
	}

    public function perms($user)
    {
        return $this->where('user_id',$user)->get();
    }

    public function permissions($role)
    {        
		return $this->where('role_id',$role)->get();        
    }
}
