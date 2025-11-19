<?php

namespace App\Http\Controllers;

use App\Models\BusSchedule;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusController extends Controller
{
    // Search Form Submit
    public function search(Request $request)
{
    $request->validate([
        'from' => 'required',
        'to' => 'required',
        'date' => 'required|date'
    ]);

    $schedules = BusSchedule::with(['bus', 'route'])
        ->whereDate('travel_date', $request->date)
        ->whereHas('route', function ($q) use ($request) {
            $q->where('from', $request->from)
              ->where('to', $request->to);
        })
        ->get();

    return view('bus.result', [
        'schedules' => $schedules,
        'request' => $request
    ]);
}

    // Seat selection page
    public function book(BusSchedule $schedule)
    {
        $takenSeats = $schedule->tickets()->pluck('seat_no')->toArray();

        return view('bus.book', compact('schedule', 'takenSeats'));
    }

    // Store booking
    public function storeBooking(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required',
            'passenger_name' => 'required',
            'passenger_phone' => 'required',
            'seat_no' => 'required|numeric'
        ]);

        $schedule = BusSchedule::findOrFail($request->schedule_id);

        // Seat duplicate check
        if ($schedule->tickets()->where('seat_no', $request->seat_no)->exists()) {
            return back()->withErrors(['seat_no' => 'Seat already booked!']);
        }

        $fare = $schedule->route->base_fare;

        // Reference ID
        $ref = 'TKT-' . strtoupper(Str::random(8));

        // Create Ticket
        $ticket = Ticket::create([
            'schedule_id' => $schedule->id,
            'passenger_name' => $request->passenger_name,
            'passenger_phone' => $request->passenger_phone,
            'seat_no' => $request->seat_no,
            'fare' => $fare,
            'booking_reference' => $ref
        ]);

        return redirect()->route('bus.ticket', $ref);
    }

    // Show ticket
    public function ticket($ref)
    {
        $ticket = Ticket::with('schedule.bus', 'schedule.route')
            ->where('booking_reference', $ref)
            ->firstOrFail();

        return view('bus.ticket', compact('ticket'));
    }
    public function showSearchForm()
{
    return view('bus.search');
}

}
