@extends('layouts.app')

@section('title', 'Select Seats')

@section('content')

<h3 class="mb-3">Select Seats – {{ $schedule->bus->name }}</h3>

{{-- Seat Legend --}}
<div class="mb-3 d-flex gap-3">
    <span class="badge bg-success p-2">Available</span>
    <span class="badge bg-danger p-2">Booked</span>
</div>

<div class="card p-4 shadow">

    <h5 class="mb-3">
        Seat Layout: <span class="text-primary">{{ $schedule->bus->seat_layout }}</span>
    </h5>

    {{-- Seat Layout Box --}}
    <div class="d-flex flex-wrap" style="max-width: 320px;">
        @for ($i = 1; $i <= $schedule->bus->total_seats; $i++)
            @php
                $booked = in_array($i, $takenSeats);
            @endphp

            <button
                class="btn btn-sm m-1 {{ $booked ? 'btn-danger' : 'btn-success' }}"
                style="width: 55px;"
                {{ $booked ? 'disabled' : '' }}
                onclick="openPassengerPopup('{{ $i }}')"
            >
                {{ $i }}
            </button>
        @endfor
    </div>

</div>


{{-- Passenger Popup --}}
<div id="popupOverlay" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
     background:rgba(0,0,0,0.45); z-index:998;">
</div>

<div id="passengerForm" class="card p-4 shadow-lg"
     style="display:none; width:350px; position:fixed; top:15%; left:50%; 
     transform:translateX(-50%); z-index:999; background:white;">

    <h4 class="mb-3">Passenger Details</h4>

    <h6 id="selectedSeatLabel" class="text-primary mb-3"></h6>

    <form action="{{ route('bus.storeBooking') }}" method="POST">
        @csrf

        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
        <input type="hidden" name="seat_no" id="seat_no">

        <label>Passenger Name</label>
        <input class="form-control mb-2" name="passenger_name" required>

        <label>Phone Number</label>
        <input class="form-control mb-2" name="passenger_phone" required>

        <button class="btn btn-primary w-100 mt-2">Confirm Booking</button>
        <button type="button" class="btn btn-secondary w-100 mt-2" onclick="closePassengerPopup()">Cancel</button>
    </form>
</div>

<script>
function openPassengerPopup(seat) {
    document.getElementById('seat_no').value = seat;
    document.getElementById('selectedSeatLabel').innerText = "Selected Seat: " + seat;
    document.getElementById('passengerForm').style.display = 'block';
    document.getElementById('popupOverlay').style.display = 'block';
}

function closePassengerPopup() {
    document.getElementById('passengerForm').style.display = 'none';
    document.getElementById('popupOverlay').style.display = 'none';
}

// Close popup when clicking outside the form
document.getElementById('popupOverlay').addEventListener('click', function() {
    closePassengerPopup();
});
</script>

@endsection
