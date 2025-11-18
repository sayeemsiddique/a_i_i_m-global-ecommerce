<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function districtInfo()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
