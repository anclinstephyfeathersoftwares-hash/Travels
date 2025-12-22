@extends('layouts.app')

@section('title', 'Bus Ticket Search & Bookings')

@section('content')

<style>
.search-card {
    background: #fff;border-radius: 12px;padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.search-dropdown{position:relative;}
.search-dropdown input {width:100%;padding:8px;}
.search-dropdown ul {
    position:absolute;width:100%;max-height:180px;overflow-y:auto;
    background:white;border:1px solid #ddd;border-radius:4px;
    margin-top:2px;display:none;z-index:9999;
}
.search-dropdown ul li{padding:8px;cursor:pointer;}
.search-dropdown ul li:hover{background:#f7f7f7;}
.bus-card {
    border:1px solid #e9e9e9;background:#ffffff;border-radius:10px;
    padding:15px;box-shadow:0 3px 8px rgba(0,0,0,0.05);
}
.info-pill{background:#eef5ff;border-left:4px solid #0d6efd;
    padding:10px 14px;border-radius:8px;}
</style>

{{-- ================== SEARCH BOX ================== --}}
<div class="search-card mb-4">
    <h4 class="mb-3">Search Buses</h4>

    <div class="row g-3">

        <div class="col-md-3">
            <label class="form-label">From</label>
            <div class="search-dropdown">
                <input type="text" id="from" class="form-control" placeholder="Enter Starting Point" onkeyup="filterList('from')">
                <ul id="fromList">
                    @foreach($routes as $city)
                        <li onclick="selectCity('from','{{ $city }}')">{{ $city }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">To</label>
            <div class="search-dropdown">
                <input type="text" id="to" class="form-control" placeholder="Enter Destination" onkeyup="filterList('to')">
                <ul id="toList">
                    @foreach($routes as $city)
                        <li onclick="selectCity('to','{{ $city }}')">{{ $city }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">Journey Date</label>
            <input type="date" id="date" class="form-control">
        </div>

        <div class="col-md-2">
            <label class="form-label">Passengers</label>
            <select id="passengers" class="form-select">
                <option>1 Adult</option>
                <option>2 Adults</option>
                <option>3 Adults</option>
            </select>
        </div>

        <div class="col-md-1 d-grid">
            <button class="btn btn-primary" onclick="fetchAvailable()">Search</button>
        </div>

    </div>
</div>
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


// ================== FETCH AVAILABLE ==================
async function fetchAvailable() {

    const from = document.getElementById('from').value;
    const to = document.getElementById('to').value;
    const date = document.getElementById('date').value;

    if(!from || !to || !date){
        alert("Please select From, To, and Date.");
        return;
    }

    document.getElementById('selDate').innerText = date;

    const url = `{{ route('bus.available') }}?from=${from}&to=${to}&date=${date}`;

    try {
        const res = await fetch(url, { headers:{'Accept':'application/json'} });
        const data = await res.json();

        document.getElementById('busCount').innerText = data.count;
        document.getElementById('quickInfo').style.display = "block";

        let html = "";
        data.schedules.forEach(s => {
            html += `
                <div class="bus-card mb-2">
                    <div class="row align-items-center">

                        <div class="col-md-4">
                            <strong>${s.bus_name}</strong><br>
                            <small>${s.bus_number ?? ""}</small>
                        </div>

                        <div class="col-md-2 text-center">
                            <small>Departure</small>
                            <div class="fw-bold">${s.departure_time}</div>
                        </div>

                        <div class="col-md-2 text-center">
                            <small>Arrival</small>
                            <div class="fw-bold">${s.arrival_time}</div>
                        </div>

                        <div class="col-md-2 text-center">
                            <small>Available Seats</small>
                            <div class="fw-bold text-success">${s.available}</div>
                        </div>

                        <div class="col-md-2 text-end">
                            <a href="/bus/schedule/${s.schedule_id}/book" 
                               class="btn btn-sm btn-primary me-2">Book</a>

                            <a href="/bus/schedule/${s.schedule_id}/passenger/add"
                               class="btn btn-sm btn-success">Add Passenger</a>
                        </div>

                    </div>
                </div>`;
        });

        document.getElementById('results').innerHTML = html;

    } catch (err) {
        console.error(err);
        alert("Error fetching buses.");
    }
}
</script>
{{-- ================== QUICK INFO ================== --}}
<div id="quickInfo" style="display:none;" class="mb-3">
    <div class="info-pill">
        <strong>Available Buses:</strong> <span id="busCount">0</span>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <strong>Date:</strong> <span id="selDate"></span>
    </div>
</div>

{{-- ================== BUS RESULTS ================== --}}
<div id="results"></div>




{{-- ================== NEW ALWAYS VISIBLE BUTTON ================== --}}
<div class="mt-3 d-flex justify-content-end">
    <a href="/bus/add" class="btn btn-success btn-lg">
        ➕ Add Passenger
    </a>
</div>




{{-- ================== BOOKED TICKETS ================== --}}
<div class="card p-3 mt-4 shadow-sm">
    <h5 class="mb-3">Booked Tickets</h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Passenger Name</th>
                <th>Phone</th>
                <th>Bus</th>
                <th>From</th>
                <th>To</th>
                <th>Seat No</th>
                <th>Seat Type</th>
                <th>Travel Date</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Ticket::with('schedule.bus','schedule.route')->latest()->get() as $ticket)
            <tr>
                <td>{{ $ticket->passenger_name }}</td>
                <td>{{ $ticket->passenger_phone }}</td>
                <td>{{ $ticket->schedule->bus->name ?? $ticket->schedule->bus->bus_number }}</td>
                <td>{{ $ticket->schedule->route->from ?? '-' }}</td>
                <td>{{ $ticket->schedule->route->to ?? '-' }}</td>
                <td>{{ $ticket->seat_no }}</td>
                <td>₹{{ $ticket->fare }}</td>
                <td>{{ $ticket->booking_reference }}</td>
                <td>
                    <a href="{{ route('passenger.create.global') }}" class="btn btn-success btn-lg">
                       class="btn btn-sm btn-success">Add Passenger</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection
