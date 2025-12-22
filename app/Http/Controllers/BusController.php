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
    // INDEX PAGE (Live Search + Booked Tickets + Add Passenger)
    // ------------------------------------------------------
    public function index()
    {
        $routes = Route::select('from')->distinct()->pluck('from')->toArray();
        $tickets = Ticket::with('schedule.bus', 'schedule.route')->latest()->get();

        return view('bus.index', compact('routes', 'tickets'));
    }

    // ------------------------------------------------------
    // CREATE PASSENGER FORM FOR SPECIFIC SCHEDULE
    // ------------------------------------------------------
    public function createPassenger($scheduleId)
    {
        $schedule = BusSchedule::with('bus', 'route', 'tickets')->findOrFail($scheduleId);

        // Generate 30 seats with AC/Non-AC and Sleeper/Seater
        $seats = [];
        for ($i = 1; $i <= 30; $i++) {
            $type = $i <= 15 ? 'Sleeper' : 'Seater';
            $ac   = $i % 2 == 0 ? 'AC' : 'Non-AC';
            $uniqueId = $type[0] . $ac[0] . $i; // SAN1, SNN2, SEA16, SEN17
            $seats[] = [
                'id'     => $uniqueId,
                'number' => $i,
                'type'   => $type,
                'ac'     => $ac,
                'booked' => in_array($uniqueId, $schedule->tickets->pluck('seat_no')->toArray()),
            ];
        }

        return view('bus.passenger.create', compact('schedule', 'seats'));
    }

    // ------------------------------------------------------
    // CREATE PASSENGER FORM (Global - list all schedules)
    // ------------------------------------------------------
    public function createPassengerGlobal()
    {
        $schedules = BusSchedule::with(['bus', 'route', 'tickets'])->get();
        return view('bus.create_global', compact('schedules'));
    }

    // ------------------------------------------------------
    // AJAX: AVAILABLE BUSES BY DATE
    // ------------------------------------------------------
    public function availableByDate(Request $request): JsonResponse
    {
        $request->validate([
            'from' => 'required|string',
            'to'   => 'required|string',
            'date' => 'required|date',
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
    // STORE PASSENGER (from create form)
    // ------------------------------------------------------
    public function storePassenger(Request $request)
    {
        $request->validate([
            'passenger_name'  => 'required|string|max:255',
            'passenger_phone' => 'required|string|max:20',
            'seat_no'         => 'required|string|max:20',
            'fare'            => 'required|numeric',
            'travel_date'     => 'required|date',
            'payment_method'  => 'required|string',
            'schedule_id'     => 'required|exists:bus_schedules,id',
        ]);

        Ticket::create([
            'passenger_name'   => $request->passenger_name,
            'passenger_phone'  => $request->passenger_phone,
            'seat_no'          => $request->seat_no,
            'schedule_id'      => $request->schedule_id,
            'fare'             => $request->fare,
            'booking_reference'=> 'TKT-' . strtoupper(Str::random(8)),
            'travel_date'      => $request->travel_date,
            'payment_method'   => $request->payment_method,
        ]);

        return redirect()->back()->with('success', 'Passenger details saved successfully!');
    }

    // ------------------------------------------------------
    // SEARCH BUS FORM PAGE
    // ------------------------------------------------------
    public function searchPage() 
    {
        $routes = Route::select('from')->distinct()->pluck('from')->toArray();
        return view('bus.search', compact('routes'));
    }

    // ------------------------------------------------------
    // SEARCH BUSES
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
    // VIEW TICKET
    // ------------------------------------------------------
    public function ticket($ref)
    {
        $ticket = Ticket::with('schedule.bus', 'schedule.route')
            ->where('booking_reference', $ref)
            ->firstOrFail();

        return view('bus.ticket', compact('ticket'));
    }
}
