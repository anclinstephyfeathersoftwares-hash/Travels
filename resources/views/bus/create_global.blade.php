@extends('layouts.app')

@section('title','Add Passenger')

@section('content')
<div class="card shadow">
    <div class="card-header bg-success">
        <h5>Add Passenger</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('passenger.store') }}" method="POST">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" name="passenger_name"
                           class="form-control"
                           value="{{ old('passenger_name') }}" required>
                </div>

                <div class="col-md-6">
                    <label>Phone</label>
                    <input type="text" name="passenger_phone"
                           class="form-control"
                           value="{{ old('passenger_phone') }}" required>
                </div>

                <div class="col-md-3">
                    <label>Age</label>
                    <input type="number" name="age"
                           class="form-control"
                           value="{{ old('age') }}">
                </div>

                <div class="col-md-3">
                    <label>Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>ID Proof</label>
                    <input type="text" name="id_proof"
                           class="form-control"
                           value="{{ old('id_proof') }}">
                </div>

                <div class="col-md-12">
                    <label>Address</label>
                    <textarea name="address" class="form-control"
                              rows="2">{{ old('address') }}</textarea>
                </div>

            </div>

            <div class="mt-4 text-end">
                <button class="btn btn-success">Save Passenger</button>
            </div>
        </form>
    </div>
</div>
@endsection
