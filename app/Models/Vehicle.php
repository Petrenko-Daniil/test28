<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public function model(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(VehicleModel::class);
    }
}
