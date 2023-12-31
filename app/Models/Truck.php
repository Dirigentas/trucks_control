<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Truck extends Model
{
    use HasFactory;

    public function subunits(): HasMany
    {
        return $this->hasMany(Truck_subunit::class, 'main_truck_id', 'id');
    }
}
