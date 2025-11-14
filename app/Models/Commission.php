<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    // If your table name is "commissions", you can remove this.
    protected $table = 'commissions';

    // Allow mass assignment
    protected $fillable = [
        'receiver',
        'type',
        'status',
        'date',
        'amount',
    ];

    // Cast fields to correct data types
    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    // Default values (optional)
    protected $attributes = [
        'type'   => 'Commission',
        'status' => 'Pending',
    ];
}
