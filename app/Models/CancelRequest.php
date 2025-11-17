<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelRequest extends Model
{
    protected $fillable = [
        'request_type',
        'pnr',
        'passenger_name',
        'ticket_number',
        'cancel_reason',
        'cancel_date',
        'flight_no',
        'remarks',
        'status'
    ];
}
