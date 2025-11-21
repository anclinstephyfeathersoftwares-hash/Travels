@extends('layouts.app')

@section('title', 'Bus Results')

@section('content')

{{-- 🔹 SEARCH SUMMARY CARD --}}
<div class="card p-4 shadow mb-4">
    <div class="row text-center">
        <div class="col-md-3">
            <small class="text-muted">From</small>
            <p class="fw-bold">🚍 {{ $request->from }}</p>
        </div>
        <div class="col-md-3">
            <small class="text-muted">To</small>
            <p class="fw-bold">🚌 {{ $request->to }}</p>
        </div>
        <div class="col-md-3">
            <small class="text-muted">Date</small>
            <p class="fw-bold">📅 {{ $request->date }}</p>
        </div>
        <div class="col-md-3">
            <small class="text-muted">Passengers</small>
            <p class="fw-bold">🧍 {{ $request->passengers }}</p>
        </div>
    </div>
</div>

{{-- 🔹 IF NO BUSES --}}
@if($schedules->count() == 0)
    <div class="alert alert-danger text-center fw-bold p-3">
        ❌ No Buses Found for This Route!
    </div>
@endif

{{-- 🔹 LOOP ALL SCHEDULES --}}
@foreach ($schedules as $schedule)

<div class="card p-4 shadow mb-3">

    <div class="row">

        {{-- BUS DETAILS --}}
        <div class="col-md-3">
            <h5 class="fw-bold">{{ $schedule->bus->name }}</h5>
            <span class="badge bg-info">{{ $schedule->bus->type }}</span>

            <p class="mt-3 fs-4 fw-semibold">{{ $schedule->departure_time }}</p>
            <small class="text-muted">{{ $schedule->route->from }}</small>
        </div>

        {{-- DURATION --}}
        <div class="col-md-3 text-center">
            <p class="mt-4 fs-5 fw-bold">⏱ {{ $schedule->route->duration ?? '—' }}</p>
            <div class="fs-2 mt-1">➡</div>
        </div>

        {{-- DESTINATION TIME --}}
        <div class="col-md-3">
            <p class="mt-4 fs-4 fw-semibold">{{ $schedule->arrival_time }}</p>
            <small class="text-muted">{{ $schedule->route->to }}</small>
        </div>

        {{-- FARE + SEATS --}}
        <div class="col-md-3 text-end">

            <h4 class="fw-bold text-primary">₹{{ $schedule->route->base_fare }}</h4>

            <p class="text-success fw-bold">
                {{ $schedule->available_seats }} Seats Left
            </p>

            <a href="{{ route('bus.book', $schedule->id) }}" class="btn btn-primary btn-lg">
                Book Now
            </a>

        </div>

    </div>

</div>

@endforeach

@endsection
