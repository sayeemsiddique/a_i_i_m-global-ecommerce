<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function level_id()
    {
        return $this->belongsTo(Level::class, 'level', 'id');
    }
}
