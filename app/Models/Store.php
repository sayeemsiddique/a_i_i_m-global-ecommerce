<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $guarded = [];

    public function divisionInfo()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function districtInfo()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function upazilaInfo()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id', 'id');
    }

}
