@extends('layouts.app')

@section('title', 'Bus Ticket Search')

@section('content')

<style>
.small-card { border-radius:10px; padding:12px; background:#fff; border:1px solid #e7e7e7; }
.info-pill { background:#f1f7ff; border-left:4px solid #0d6efd; padding:8px 12px; border-radius:8px; }
.select-scroll { max-height:180px; overflow:auto; }

/* NEW LIVE DROPDOWN CSS */
.search-dropdown {
    position: relative;
}
.search-dropdown input {
    width: 100%;
    padding: 8px;
}
.search-dropdown ul {
    position: absolute;
    width: 100%;
    max-height: 180px;
    overflow-y: auto;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-top: 2px;
    display: none;
    z-index: 1000;
}
.search-dropdown ul li {
    padding: 8px;
    cursor: pointer;
}
.search-dropdown ul li:hover {
    background: #f2f2f2;
}
</style>

{{-- ========================================================= --}}
{{-- 🔥 NEW LIVE SEARCH (AJAX) AREA --}}
{{-- ========================================================= --}}
<div class="card p-3 mb-3 shadow-sm">
    <h5 class="mb-3">Live Bus Availability</h5>

    <div class="row g-2 align-items-end">

        {{-- =========== NEW FROM FIELD =========== --}}
        <div class="col-md-3">
            <label class="form-label">From</label>

            <div class="search-dropdown">
                <input type="text" id="from" class="form-control"
                       placeholder="Select Starting Point"
                       onkeyup="filterList('from')">

                <ul id="fromList">
                    @foreach($routes as $city)
                        <li onclick="selectCity('from','{{ $city }}')">{{ $city }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- =========== NEW TO FIELD =========== --}}
        <div class="col-md-3">
            <label class="form-label">To</label>

            <div class="search-dropdown">
                <input type="text" id="to" class="form-control"
                       placeholder="Select Destination"
                       onkeyup="filterList('to')">

                <ul id="toList">
                    @foreach($routes as $city)
                        <li onclick="selectCity('to','{{ $city }}')">{{ $city }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Date</label>
            <input id="date" type="date" class="form-control" onchange="fetchAvailable()">
        </div>

        <div class="col-md-2">
            <label class="form-label">Passengers</label>
            <select id="passengers" class="form-select">
                <option>1 Adult</option>
                <option>2 Adults</option>
                <option>3 Adults</option>
            </select>
        </div>

        <div class="col-md-1 text-end">
            <button class="btn btn-primary w-100" onclick="fetchAvailable()">Search</button>
        </div>
    </div>
</div>

{{-- Quick info row --}}
<div id="quickInfo" style="display:none;" class="mb-3">
    <div class="info-pill mb-2">
        <strong>Available Buses:</strong> <span id="busCount">0</span>
        &nbsp;&nbsp;|&nbsp;&nbsp; <strong>Date:</strong> <span id="selDate"></span>
    </div>
</div>

{{-- Results --}}
<div id="results"></div>
{{-- ========================================================= --}}
{{-- 🔥 Passenger Details (New – Inline, Not Popup) --}}
{{-- ========================================================= --}}

<div class="card p-4 shadow-sm mb-4">
    <h4 class="mb-3">Passenger Details</h4>

    <div class="row">
        <div class="col-md-4">
            <label>Name</label>
            <input class="form-control mb-3" placeholder="Full Name">
        </div>

        <div class="col-md-4">
            <label>Age / Gender</label>
            <input class="form-control mb-3" placeholder="23 / Male">
        </div>

        <div class="col-md-4">
            <label>Mobile Number</label>
            <input class="form-control mb-3" placeholder="9876543210">
        </div>

        <div class="col-md-4">
            <label>Boarding Point</label>
            <input class="form-control mb-3" placeholder="Pickup Location">
        </div>

        <div class="col-md-4">
            <label>Dropping Point</label>
            <input class="form-control mb-3" placeholder="Drop Location">
        </div>
{{-- ========================================================= --}}
{{-- 🔥 Route Details (OLD – unchanged) --}}
{{-- ========================================================= --}}
<div class="card p-4 shadow-sm mb-4">
    <h4 class="mb-3">Route Details</h4>

    <div class="row">
        <div class="col-md-4">
            <label>Select From</label>
            <input class="form-control" placeholder="From">
        </div>

        <div class="col-md-4">
            <label>Select To</label>
            <input class="form-control" placeholder="To">
        </div>

        <div class="col-md-4">
            <label>Select Bus</label>
            <input class="form-control" placeholder="Bus Name">
        </div>

        <div class="col-md-4 mt-3">
            <label>Departure Time</label>
            <input type="time" class="form-control">
        </div>

        <div class="col-md-4 mt-3">
            <label>Arrival Time</label>
            <input type="time" class="form-control">
        </div>
    </div>
</div>
       

{{-- ========================================================= --}}
{{-- 🔥 Bus Master Section (UPDATED) --}}
{{-- ========================================================= --}}
<div class="card p-4 shadow-sm mt-4 mb-4">
    <h4 class="mb-3">Bus Master</h4>

    <div class="row">

        {{-- Bus Number Dropdown --}}
        <div class="col-md-3">
            <label>Bus Number</label>
            <select class="form-select">
                <option selected disabled>Select Bus Number</option>

                {{-- Example Bus Numbers - You can replace with DB values --}}
                <option>TN-01-1234</option>
                <option>TN-02-5678</option>
                <option>TN-03-9999</option>
                <option>PY-05-4444</option>
                <option>KA-01-2266</option>

            </select>
        </div>

        {{-- Bus Type --}}
        <div class="col-md-3">
            <label>Bus Type</label>
            <select class="form-select">
                <option>AC</option>
                <option>Non-AC</option>
                <option>Sleeper</option>
                <option>Seater</option>
            </select>
        </div>

        {{-- ❌ Total Seats Removed --}}
        {{-- Removed as per your requirement --}}

        {{-- Seat Layout --}}
        <div class="col-md-3">
            <label>Seat Layout</label>
            <select class="form-select">
                <option>2 + 2</option>
                <option>2 + 1</option>
                <option>Sleeper</option>
            </select>
        </div>

    </div>
</div>


 <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary w-100">Save Passenger</button>
        </div>
    </div>
</div>




{{-- ========================================================= --}}
{{-- 🔥 New Scripts --}}
{{-- ========================================================= --}}
<script>

function filterList(type) {
    let input = document.getElementById(type).value.toLowerCase();
    let list = document.getElementById(type + "List");
    let items = list.getElementsByTagName("li");

    list.style.display = "block";

    for (let i = 0; i < items.length; i++) {
        let text = items[i].innerText.toLowerCase();
        items[i].style.display = text.includes(input) ? "" : "none";
    }
}

function selectCity(type, city) {
    document.getElementById(type).value = city;
    document.getElementById(type + "List").style.display = "none";
}

async function fetchAvailable(){
    const from = document.getElementById('from').value;
    const to = document.getElementById('to').value;
    const date = document.getElementById('date').value;

    if(!from || !to || !date){
        alert('Please select From, To and Date.');
        return;
    }

    document.getElementById('selDate').innerText = date;

    const url = `{{ route('bus.available') }}?from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}&date=${encodeURIComponent(date)}`;
    try {
        const res = await fetch(url, { headers: {'Accept':'application/json'} });
        if(!res.ok) throw new Error('Network error');
        const data = await res.json();

        document.getElementById('busCount').innerText = data.count;
        document.getElementById('quickInfo').style.display = 'block';

        const results = document.getElementById('results');
        let html = '';
        data.schedules.forEach(s => {
            html += `
            <div class="small-card mb-2">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <strong>${s.bus_name}</strong><br/>
                        <small>${s.bus_number ?? ''}</small>
                    </div>
                    <div class="col-md-3 text-center">
                        <div><small>Dep</small><div class="fw-bold">${s.departure_time || '-'}</div></div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div><small>Arr</small><div class="fw-bold">${s.arrival_time || '-'}</div></div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div><small>Available</small><div class="fw-bold text-success">${s.available}</div></div>
                    </div>
                    <div class="col-md-1 text-end">
                        <a href="/bus/schedule/${s.schedule_id}/book" class="btn btn-sm btn-primary">Book</a>
                    </div>
                </div>
            </div>`;
        });
        results.innerHTML = html;

    } catch (err) {
        alert('Unable to fetch buses');
        console.error(err);
    }
}

function openPassengerPopup() {
    document.getElementById("passengerPopup").style.display = "block";
}
function closePassengerPopup() {
    document.getElementById("passengerPopup").style.display = "none";
}

</script>

@endsection
