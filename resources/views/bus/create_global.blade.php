@extends('layouts.app')

@section('title', 'Add Passenger (Global)')

@section('content')

<style>
.form-card{
    background:#fff;border-radius:12px;padding:20px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}
.seat-grid{
    display:grid;
    grid-template-columns: repeat(6, 1fr);
    gap:10px;
    margin-top:10px;
}
.seat{
    padding:10px;
    border-radius:6px;
    text-align:center;
    cursor:pointer;
    font-weight:bold;
}
.seat.available{background:#28a745;color:white;}
.seat.booked{background:#dc3545;color:white;cursor:not-allowed;}
.seat.selected{border:3px solid #0d6efd;}
</style>

<div class="form-card mb-4">
    <h4>Add Passenger (Global)</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('passenger.store') }}" method="POST">
        @csrf

        <div class="row g-3 mt-2">

            {{-- ================= SCHEDULE SELECT ================= --}}
            <div class="col-md-6">
                <label class="form-label">Select Bus Schedule</label>
                <select id="scheduleSelect" class="form-select" required>
                    <option value="">-- Select Schedule --</option>
                    @foreach($schedules as $s)
                        <option value="{{ $s->id }}"
                            {{ isset($selectedScheduleId) && $selectedScheduleId == $s->id ? 'selected' : '' }}
                            data-travel-date="{{ $s->travel_date }}"
                            data-fare="{{ $s->route->base_fare }}"
                            data-booked='@json($s->tickets->pluck("seat_no"))'>
                            {{ $s->bus->name ?? $s->bus->bus_number }}
                            | {{ $s->route->from }} → {{ $s->route->to }}
                            | {{ $s->travel_date }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ================= PASSENGER ================= --}}
            <div class="col-md-6">
                <label class="form-label">Passenger Name</label>
                <input type="text" name="passenger_name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <input type="text" name="passenger_phone" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" class="form-select" required>
                    <option value="Cash">Cash</option>
                    <option value="Online">Online</option>
                    <option value="Card">Card</option>
                </select>
            </div>

        </div>

        {{-- ================= HIDDEN INPUTS ================= --}}
        <input type="hidden" name="schedule_id" id="schedule_id">
        <input type="hidden" name="seat_no" id="seat_no">
        <input type="hidden" name="fare" id="fare">
        <input type="hidden" name="travel_date" id="travel_date">

        {{-- ================= SEAT LAYOUT ================= --}}
        <h5 class="mt-4">Select Seat</h5>
        <div id="seatLayout" class="seat-grid"></div>

        <div class="mt-4 d-flex justify-content-end">
            <button class="btn btn-success btn-lg">Save Passenger</button>
        </div>
    </form>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
const scheduleSelect = document.getElementById('scheduleSelect');
const seatLayout = document.getElementById('seatLayout');
const scheduleInput = document.getElementById('schedule_id');
const seatInput = document.getElementById('seat_no');
const fareInput = document.getElementById('fare');
const dateInput = document.getElementById('travel_date');

scheduleSelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];

    if(!selectedOption.value){
        seatLayout.innerHTML = '';
        scheduleInput.value = '';
        fareInput.value = '';
        dateInput.value = '';
        seatInput.value = '';
        return;
    }

    const bookedSeats = JSON.parse(selectedOption.dataset.booked || '[]');
    const fare = selectedOption.dataset.fare;
    const travelDate = selectedOption.dataset.travelDate;
    const scheduleId = selectedOption.value;

    scheduleInput.value = scheduleId;
    fareInput.value = fare;
    dateInput.value = travelDate;

    let html = '';
    for(let i = 1; i <= 30; i++){
        let type = i <= 15 ? 'Sleeper' : 'Seater';
        let ac = i % 2 === 0 ? 'AC' : 'Non-AC';
        let seatId = type[0] + ac[0] + i;

        let booked = bookedSeats.includes(seatId);

        html += `
            <div class="seat ${booked ? 'booked' : 'available'}"
                 data-seat="${seatId}">
                ${i}<br>${type}<br>${ac}
            </div>
        `;
    }

    seatLayout.innerHTML = html;

    document.querySelectorAll('.seat.available').forEach(seat => {
        seat.addEventListener('click', () => {
            document.querySelectorAll('.seat.selected')
                .forEach(s => s.classList.remove('selected'));

            seat.classList.add('selected');
            seatInput.value = seat.dataset.seat;
        });
    });
});

/* 🔥 AUTO LOAD seats when coming from index page */
document.addEventListener('DOMContentLoaded', function () {
    if (scheduleSelect.value) {
        scheduleSelect.dispatchEvent(new Event('change'));
    }
});
</script>

@endsection
