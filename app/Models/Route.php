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

    public function showSearchForm()
{
    $routes = \App\Models\Route::all();   // <-- Add this

    return view('bus.search', compact('routes'));
}

}
