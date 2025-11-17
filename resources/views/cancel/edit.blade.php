@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Edit Cancel Request</h2>

    <form action="{{ route('cancel.update', $cancel->id) }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-3">
                <label>PNR</label>
                <input type="text" name="pnr" class="form-control" value="{{ $cancel->pnr }}">
            </div>

            <div class="col-md-3">
                <label>Passenger Name</label>
                <input type="text" name="passenger_name" class="form-control" value="{{ $cancel->passenger_name }}">
            </div>

            <div class="col-md-3">
                <label>Ticket Number</label>
                <input type="text" name="ticket_number" class="form-control" value="{{ $cancel->ticket_number }}">
            </div>

            <div class="col-md-3">
                <label>Flight No</label>
                <input type="text" name="flight_no" class="form-control" value="{{ $cancel->flight_no }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label>Cancel Reason</label>
                <input type="text" name="cancel_reason" class="form-control" value="{{ $cancel->cancel_reason }}">
            </div>

            <div class="col-md-3">
                <label>Cancel Date</label>
                <input type="date" name="cancel_date" class="form-control" value="{{ $cancel->cancel_date }}">
            </div>

            <div class="col-md-6">
                <label>Remarks</label>
                <input type="text" name="remarks" class="form-control" value="{{ $cancel->remarks }}">
            </div>
        </div>

        <button class="btn btn-success">Update</button>
    </form>

</div>

@endsection
