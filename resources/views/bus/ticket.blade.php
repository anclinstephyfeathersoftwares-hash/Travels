@extends('layouts.app')

@section('title', 'Bus Ticket')

@section('content')

<style>
    .ticket-box {
        border: 2px dashed #6c757d;
        border-radius: 10px;
        padding: 20px;
        background: #fdfdfd;
    }
    .qr-box {
        padding: 20px;
        border: 2px solid #000;
        display: inline-block;
        font-size: 18px;
        letter-spacing: 3px;
        background: #fff;
    }
</style>

<div class="ticket-box shadow">

    {{-- ⭐ Your Original Code (NOT Modified) --}}
    <h2 class="text-center mb-4">🚌 Bus Ticket</h2>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Passenger Name:</strong> {{ $ticket->passenger_name }}</p>
            <p><strong>Phone:</strong> {{ $ticket->passenger_phone }}</p>
            <p><strong>Seat No:</strong> {{ $ticket->seat_no }}</p>
            <p><strong>Ticket No:</strong> {{ $ticket->booking_reference }}</p>
        </div>

        <div class="col-md-6">
            <p><strong>Bus:</strong> {{ $ticket->schedule->bus->name }}</p>
            <p><strong>Type:</strong> {{ $ticket->schedule->bus->type }}</p>
            <p><strong>Route:</strong> {{ $ticket->schedule->route->from }} → {{ $ticket->schedule->route->to }}</p>
            <p><strong>Fare:</strong> ₹{{ $ticket->fare }}</p>
        </div>
    </div>

    <hr>

    <div class="row text-center">
        <div class="col-md-6">
            <strong>Departure:</strong>
            <p>{{ $ticket->schedule->departure_time }}</p>
        </div>

        <div class="col-md-6">
            <strong>Arrival:</strong>
            <p>{{ $ticket->schedule->arrival_time }}</p>
        </div>
    </div>

    {{-- ⭐ ADDED QR STYLE BOOKING BLOCK --}}
    <div class="text-center mt-4">
        <div class="qr-box">
            <strong>{{ $ticket->booking_reference }}</strong>
        </div>
        <p class="mt-2 text-muted">Show this code during boarding</p>
    </div>

    {{-- ⭐ Your original print button kept same --}}
    <div class="text-center mt-4">
        <button onclick="window.print()" class="btn btn-primary">
            🖨 Print Ticket
        </button>
        <p class="mt-2 text-muted">Press <strong>CTRL + P</strong> to print</p>
    </div>

</div>

@endsection
