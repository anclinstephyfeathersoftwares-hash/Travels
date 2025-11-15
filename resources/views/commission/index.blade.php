@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4 fw-bold">Commission List</h3>

    <a href="{{ route('commission.create') }}" class="btn btn-success mb-3">+ Add Commission</a>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Receiver</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($commissions as $item)
            <tr>
                <td>{{ $item->receiver }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->date }}</td>
                <td>${{ number_format($item->amount,2) }}</td>

                <td>
                    <a href="{{ route('commission.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('commission.delete', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $commissions->links() }}
</div>

@endsection
