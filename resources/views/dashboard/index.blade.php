@extends('layouts.app')

@section('content')
<h2 class="mb-4">Travel Management Dashboard</h2>

<!-- Summary Cards -->
<div class="row justify-content-between">

    <!-- Total Trips -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h6>Total Trips</h6>
                <h3>{{ $totalTrips }}</h3>
            </div>
        </div>
    </div>

    <!-- Total Customers -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h6>Customers</h6>
                <h3>{{ $totalCustomers }}</h3>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h6>Total Revenue</h6>
                <h3>₹ {{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Cancel Requests -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h6>Cancel Requests</h6>
                <h3>{{ $totalCancels ?? 0 }}</h3>
            </div>
        </div>
    </div>

</div>

<!-- Charts Row -->
<div class="row mt-4">

    <!-- Monthly Revenue Chart -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                Monthly Revenue
            </div>
            <div class="card-body">
                <canvas
                    id="monthlyRevenueChart"
                    height="120"
                    data-revenue="{{ json_encode($monthlyRevenue) }}">
                </canvas>
            </div>
        </div>
    </div>

    <!-- Daily Revenue Chart -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                Daily Revenue
            </div>
            <div class="card-body">
                <canvas
                    id="dailyRevenueChart"
                    height="120"
                    data-revenue="{{ json_encode($dailyRevenue) }}">
                </canvas>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    /* Monthly Revenue Bar Chart */
    const monthlyCanvas = document.getElementById('monthlyRevenueChart');
    const monthlyRevenue = JSON.parse(monthlyCanvas.dataset.revenue);

    new Chart(monthlyCanvas, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Monthly Revenue',
                data: monthlyRevenue,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    /* Daily Revenue Bar Chart */
    const dailyCanvas = document.getElementById('dailyRevenueChart');
    const dailyRevenue = JSON.parse(dailyCanvas.dataset.revenue);

    new Chart(dailyCanvas, {
        type: 'bar',
        data: {
            labels: Array.from({length: dailyRevenue.length}, (_, i) => `Day ${i+1}`),
            datasets: [{
                label: 'Daily Revenue',
                data: dailyRevenue,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
