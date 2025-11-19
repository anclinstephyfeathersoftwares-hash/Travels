<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusSchedule extends Model
{
    protected $fillable = [
        'bus_id',
        'route_id',
        'travel_date',
        'departure_time',
        'arrival_time'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'schedule_id');
    }
}
