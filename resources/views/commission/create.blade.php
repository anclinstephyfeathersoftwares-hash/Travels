@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="fw-bold mb-4">Add Commission</h3>

    <form method="POST" action="{{ route('commission.store') }}">
        @csrf

        <label>Receiver</label>
        <input type="text" name="receiver" class="form-control mb-2" required>

        <label>Amount</label>
        <input type="number" name="amount" class="form-control mb-2" required>

        <label>Date</label>
        <input type="date" name="date" class="form-control mb-2" required>

        <label>Status</label>
        <select name="status" class="form-control mb-3">
            <option value="Pending">Pending</option>
            <option value="Done">Done</option>
        </select>

        <button class="btn btn-success">Add</button>
        <a href="{{ route('commission.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>

@endsection
