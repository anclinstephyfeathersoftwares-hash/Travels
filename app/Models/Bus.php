<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'bus_name',
        'bus_number',
        'total_seats'
    ];

    public function schedules()
    {
        return $this->hasMany(BusSchedule::class);
    }
}
