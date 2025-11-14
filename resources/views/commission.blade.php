@extends('layouts.app')

@section('content')

<style>
.status-done {
    background: #4caf50;
    padding: 5px 12px;
    border-radius: 50px;
    color: white;
}
.status-pending {
    background: #f44336;
    padding: 5px 12px;
    border-radius: 50px;
    color: white;
}
.table td, .table th {
    vertical-align: middle;
}
</style>

<div class="container-fluid">

    <h3 class="mb-4 fw-bold">Commission</h3>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Search + Filter + Add Button -->
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex" method="GET">
            <input type="text" name="search" value="{{ $search }}" class="form-control me-2" placeholder="Search receiver or type...">

            <select name="status" class="form-control me-2">
                <option value="">All Status</option>
                <option value="Done" {{ $status=='Done' ? 'selected' : '' }}>Done</option>
                <option value="Pending" {{ $status=='Pending' ? 'selected' : '' }}>Pending</option>
            </select>

            <button class="btn btn-primary">Filter</button>
        </form>

        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
            + Add Commission
        </button>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Receiver</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Edit</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($commissions as $item)
                    <tr>
                        <td class="d-flex align-items-center">
                            <img src="https://i.pravatar.cc/40" class="rounded-circle me-2">
                            {{ $item->receiver }}
                        </td>

                        <td>{{ $item->type }}</td>

                        <td>
                            @if($item->status == 'Done')
                                <span class="status-done">Done</span>
                            @else
                                <span class="status-pending">Pending</span>
                            @endif
                        </td>

                        <td>{{ $item->date->format('M jS, Y') }}</td>
                        <td>${{ number_format($item->amount, 2) }}</td>

                        <td>
                            <!-- Edit -->
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $item->id }}">
                                Edit
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('commission.delete', $item->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this commission?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $item->id }}">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('commission.update', $item->id) }}" class="modal-content">
                                @csrf
                                <div class="modal-header bg-primary text-white">
                                    <h5>Edit Commission</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <label>Receiver</label>
                                    <input type="text" name="receiver" value="{{ $item->receiver }}" class="form-control mb-2" required>

                                    <label>Amount</label>
                                    <input type="number" name="amount" value="{{ $item->amount }}" class="form-control mb-2" required>

                                    <label>Date</label>
                                    <input type="date" name="date" value="{{ $item->date->format('Y-m-d') }}" class="form-control mb-2" required>

                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Pending" {{ $item->status=='Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Done" {{ $item->status=='Done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $commissions->links() }}
    </div>

</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('commission.store') }}" class="modal-content">
            @csrf

            <div class="modal-header bg-success text-white">
                <h5>Add Commission</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label>Receiver</label>
                <input type="text" name="receiver" class="form-control mb-2" required>

                <label>Amount</label>
                <input type="number" name="amount" class="form-control mb-2" required>

                <label>Date</label>
                <input type="date" name="date" class="form-control mb-2" required>

                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Pending">Pending</option>
                    <option value="Done">Done</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success">Add</button>
            </div>
        </form>
    </div>
</div>

@endsection
