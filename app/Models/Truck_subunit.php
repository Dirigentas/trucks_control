<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Truck_subunit extends Model
{
    use HasFactory;

    public function trucks(): BelongsTo
    {
        return $this->belongsTo(Truck::class, 'main_truck_id', 'id');
    }
}
