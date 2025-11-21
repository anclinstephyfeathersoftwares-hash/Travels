<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
  'schedule_id','passenger_name','passenger_phone','seat_no','fare','booking_reference',
  'passenger_age','passenger_gender','boarding_point','dropping_point','payment_mode','qr_code','status'
];
public function schedule(){ return $this->belongsTo(BusSchedule::class,'schedule_id'); }

}
