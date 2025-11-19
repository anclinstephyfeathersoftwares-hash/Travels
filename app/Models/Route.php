<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'from',
        'to',
        'base_fare'
    ];

    public function schedules()
    {
        return $this->hasMany(BusSchedule::class);
    }
}
