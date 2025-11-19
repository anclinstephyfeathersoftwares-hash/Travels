@extends('layouts.app')

@section('title', 'Bus Ticket Search')

@section('content')

<div class="card p-4 shadow">
    <h4 class="mb-3">Search Bus Tickets</h4>

   <form action="{{ route('bus.search.results') }}" method="POST">

        @csrf

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">From</label>
                <input type="text" name="from" class="form-control" value="Chennai (MAA)" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">To</label>
                <input type="text" name="to" class="form-control" value="Bangalore (BLR)" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Passengers</label>
                <select name="passengers" class="form-select">
                    <option>1 Adult</option>
                    <option>2 Adults</option>
                    <option>3 Adults</option>
                </select>
            </div>
        </div>

        <button class="btn btn-primary w-100">Search</button>
    </form>
</div>

@endsection
