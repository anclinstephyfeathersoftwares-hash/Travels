@extends('layouts.app')

@section('title', 'Bus Results')

@section('content')

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

@foreach ($schedules as $schedule)
<div class="card p-4 shadow mb-3">

    <div class="row">

        <div class="col-md-3">
            <h5 class="fw-bold">{{ $schedule->bus->name }}</h5>
            <small class="text-muted">{{ $schedule->bus->type }}</small>

            <p class="mt-2 fs-4 fw-semibold">{{ $schedule->route->from_time ?? '—' }}</p>
            <span class="text-muted">{{ $schedule->route->from }}</span>
        </div>

        <div class="col-md-3 text-center">
            <p class="fs-5 fw-bold">⏱ {{ $schedule->route->duration ?? '—' }}</p>
            <div class="mt-2">➡</div>
        </div>

        <div class="col-md-3">
            <p class="mt-4 fs-4 fw-semibold">{{ $schedule->route->to_time ?? '—' }}</p>
            <span class="text-muted">{{ $schedule->route->to }}</span>
        </div>

        <div class="col-md-3 text-end">
            <h4 class="fw-bold text-primary">₹{{ $schedule->route->base_fare }}</h4>

            <p class="text-success fw-semibold">
                {{ $schedule->available_seats }} Seats Left
            </p>

            <a href="{{ route('bus.book', $schedule->id) }}" class="btn btn-primary">
                Book Now
            </a>
        </div>

    </div>

</div>
@endforeach

@endsection
