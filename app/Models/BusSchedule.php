<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusSchedule extends Model
{
   protected $casts = [
  'boarding_points' => 'array',
  'dropping_points' => 'array',
  'travel_date' => 'date',
];
public function tickets(){ return $this->hasMany(Ticket::class,'schedule_id'); }
public function bus(){ return $this->belongsTo(Bus::class); }
public function route(){ return $this->belongsTo(Route::class); }

}
