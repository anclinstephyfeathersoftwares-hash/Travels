<?php

namespace App\Http\Controllers;

use App\Models\BusSchedule;
use App\Models\Ticket;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BusController extends Controller
{
    // ------------------------------------------------------
    // INDEX PAGE (Live Search + Booked Tickets + Create Passenger)
    // ------------------------------------------------------
    public function index()
    {
        // Fetch distinct routes from DB or fallback static cities
        $routes = Route::select('from')->distinct()->pluck('from')->toArray();

        // Fetch latest tickets for table display
        $tickets = Ticket::with('schedule.bus', 'schedule.route')->latest()->get();

        return view('bus.index', compact('routes', 'tickets'));
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
    // BOOK PAGE (Detailed Seat Selection)
    // ------------------------------------------------------
    public function book(BusSchedule $schedule)
    {
        $takenSeats = $schedule->tickets()->pluck('seat_no')->toArray();
        return view('bus.book', compact('schedule', 'takenSeats'));
    }

    // ------------------------------------------------------
    // STORE PASSENGER DETAILS (Inline Form)
    // ------------------------------------------------------
    public function storePassenger(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'age_gender'=> 'nullable|string|max:50',
            'mobile'    => 'required|string|max:20',
            'boarding'  => 'required|string|max:255',
            'dropping'  => 'required|string|max:255',
        ]);

        // Save passenger as ticket (schedule & seat can be assigned later)
        $ticket = Ticket::create([
            'passenger_name' => $request->name,
            'passenger_phone'=> $request->mobile,
            'seat_no'        => null,
            'schedule_id'    => null,
            'fare'           => 0,
            'booking_reference' => 'TKT-' . strtoupper(Str::random(8)),
            'boarding_point' => $request->boarding,
            'dropping_point' => $request->dropping,
        ]);

        return redirect()->back()->with('success', 'Passenger details saved successfully!');
    }

    // ------------------------------------------------------
    // SEARCH FORM (Optional if needed for separate search page)
    // ------------------------------------------------------
    public function searchPage()
    {
        // Static cities for live search dropdown
        $routes = [
            'Chennai', 'Bangalore', 'Hyderabad', 'Mumbai', 'Delhi',
            'Pune', 'Kolkata', 'Coimbatore', 'Madurai', 'Trichy'
        ];

        return view('bus.create', compact('routes'));
    }

    // ------------------------------------------------------
    // SEARCH RESULTS PAGE (Form submission)
    // ------------------------------------------------------
    public function search(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to'   => 'required',
            'date' => 'required|date',
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
            'request'   => $request,
        ]);
    }

    // ------------------------------------------------------
    // SHOW TICKET BY REFERENCE
    // ------------------------------------------------------
    public function ticket($ref)
    {
        $ticket = Ticket::with('schedule.bus', 'schedule.route')
            ->where('booking_reference', $ref)
            ->firstOrFail();

        return view('bus.ticket', compact('ticket'));
    }
}
