@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Create New Cancel Request</h2>
    <form action="{{ route('cancel.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-3">
                <label>PNR</label>
                <input type="text" name="pnr" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label>Passenger Name</label>
                <input type="text" name="passenger_name" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label>Ticket Number</label>
                <input type="text" name="ticket_number" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label>Flight No</label>
                <input type="text" name="flight_no" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Cancel Reason</label>
                <select name="cancel_reason" class="form-control">
                    <option value="Schedule Conflict">Schedule Conflict</option>
                    <option value="Medical">Medical</option>
                    <option value="Personal">Personal</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Cancel Date</label>
                <input type="date" name="cancel_date" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label>Remarks</label>
                <input type="text" name="remarks" class="form-control">
            </div>
        </div>

        <button class="btn btn-primary">Submit Cancel Request</button>
    </form>


    <hr>

    <h3>Latest Cancel Request History</h3>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>PNR</th>
                <th>Name</th>
                <th>Reason</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($history as $h)
            <tr>
                <td>{{ $h->id }}</td>
                <td>{{ $h->pnr }}</td>
                <td>{{ $h->passenger_name }}</td>
                <td>{{ $h->cancel_reason }}</td>
                <td>{{ $h->cancel_date }}</td>
                <td>
                    <span class="badge bg-success">{{ $h->status }}</span>
                </td>

                <td>
                    <a href="{{ route('cancel.edit', $h->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('cancel.delete', $h->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this?')">Delete</button>
                    </form>

                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
