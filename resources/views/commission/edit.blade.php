@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="fw-bold mb-4">Edit Commission</h3>

    <form method="POST" action="{{ route('commission.update', $commission->id) }}">
        @csrf

        <label>Receiver</label>
        <input type="text" name="receiver" value="{{ $commission->receiver }}" class="form-control mb-2" required>

        <label>Amount</label>
        <input type="number" name="amount" value="{{ $commission->amount }}" class="form-control mb-2" required>

        <label>Date</label>
        <input type="date" name="date" value="{{ $commission->date->format('Y-m-d') }}" class="form-control mb-2" required>

        <label>Status</label>
        <select name="status" class="form-control mb-3">
            <option value="Pending" {{ $commission->status=='Pending' ? 'selected':'' }}>Pending</option>
            <option value="Done" {{ $commission->status=='Done' ? 'selected':'' }}>Done</option>
        </select>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('commission.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>

@endsection
