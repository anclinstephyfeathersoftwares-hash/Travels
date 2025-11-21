<?php

namespace App\Http\Controllers;

use App\Models\BusSchedule;
use App\Models\Ticket;
use App\Models\Route; // <-- IMPORTANT (Routes table/model)
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BusController extends Controller
{
    // ------------------------------------------------------
    // SHOW SEARCH FORM  (FIXED: now sends $routes)
    // ------------------------------------------------------
    public function showSearchForm()
    {
        $routes = Route::select('from', 'to')->distinct()->get();

        return view('bus.search', compact('routes'));
    }

    // ------------------------------------------------------
    // SEARCH RESULTS PAGE
    // ------------------------------------------------------
    public function search(Request $request)
    {
        $request->validate([
            'from'  => 'required',
            'to'    => 'required',
            'date'  => 'required|date'
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
            'request'   => $request
        ]);
    }

    // ------------------------------------------------------
    // AJAX: AVAILABLE BUSES BY DATE
    // ------------------------------------------------------
    public function availableByDate(Request $request): JsonResponse
    {
        $request->validate([
            'from'  => 'required|string',
            'to'    => 'required|string',
            'date'  => 'required|date',
        ]);

        $date = Carbon::parse($request->date)->toDateString();

        $schedules = BusSchedule::with('bus', 'route')
            ->whereDate('travel_date', $date)
            ->whereHas('route', function ($q) use ($request) {
                $q->where('from', $request->from)
                  ->where('to', $request->to);
            })
            ->get();

        $data = $schedules->map(function ($s) {

            $totalSeats = $s->bus->total_seats ?? 0;
            $booked = $s->tickets()->count();
            $available = max(0, $totalSeats - $booked);

            return [
                'schedule_id'    => $s->id,
                'bus_name'       => $s->bus->name ?? $s->bus->bus_number ?? 'Bus',
                'bus_number'     => $s->bus->bus_number ?? null,
                'departure_time' => $s->departure_time ?? ($s->route->from_time ?? null),
                'arrival_time'   => $s->arrival_time ?? ($s->route->to_time ?? null),
                'total_seats'    => $totalSeats,
                'booked'         => $booked,
                'available'      => $available,
                'fare'           => $s->route->base_fare ?? 0,
            ];
        });

        return response()->json([
            'count'     => $data->count(),
            'schedules' => $data,
        ]);
    }

    // ------------------------------------------------------
    // BOOK PAGE
    // ------------------------------------------------------
    public function book(BusSchedule $schedule)
    {
        $takenSeats = $schedule->tickets()->pluck('seat_no')->toArray();

        return view('bus.book', compact('schedule', 'takenSeats'));
    }

    // ------------------------------------------------------
    // STORE BOOKING
    // ------------------------------------------------------
    public function storeBooking(Request $request)
    {
        $request->validate([
            'schedule_id'      => 'required',
            'passenger_name'   => 'required',
            'passenger_phone'  => 'required',
            'seat_no'          => 'required|numeric'
        ]);

        $schedule = BusSchedule::findOrFail($request->schedule_id);

        if ($schedule->tickets()->where('seat_no', $request->seat_no)->exists()) {
            return back()->withErrors(['seat_no' => 'Seat already booked!']);
        }

        $ref = 'TKT-' . strtoupper(Str::random(8));
        $fare = $schedule->route->base_fare;

        Ticket::create([
            'schedule_id'       => $schedule->id,
            'passenger_name'    => $request->passenger_name,
            'passenger_phone'   => $request->passenger_phone,
            'seat_no'           => $request->seat_no,
            'fare'              => $fare,
            'booking_reference' => $ref
        ]);

        return redirect()->route('bus.ticket', $ref);
    }

    // ------------------------------------------------------
    // SHOW TICKET
    // ------------------------------------------------------
    public function ticket($ref)
    {
        $ticket = Ticket::with('schedule.bus', 'schedule.route')
            ->where('booking_reference', $ref)
            ->firstOrFail();

        return view('bus.ticket', compact('ticket'));
    }
    public function searchPage()
{
    // India cities list (static for now)
    $routes = [
        'Chennai', 'Bangalore', 'Hyderabad', 'Mumbai', 'Delhi',
        'Pune', 'Kolkata', 'Coimbatore', 'Madurai', 'Trichy'
    ];

    return view('bus.search', compact('routes'));
}

}
