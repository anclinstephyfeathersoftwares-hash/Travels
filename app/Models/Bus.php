<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $casts = ['seat_layout' => 'array'];


    public function schedules()
    {
        return $this->hasMany(BusSchedule::class);
    }
}
