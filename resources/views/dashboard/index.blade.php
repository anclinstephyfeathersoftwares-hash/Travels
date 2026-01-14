@extends('layouts.app')

@section('content')

<style>
    body {
        background-color: #f5f7fb;
    }

    h2 {
        font-weight: 700;
        color: #2c3e50;
        letter-spacing: 0.5px;
    }

    .dashboard-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .charts-bottom {
        margin-top: auto;
    }

    /* Cards */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    .card h6 {
        font-size: 14px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .card h3 {
        font-size: 26px;
        font-weight: 700;
    }

    /* Chart Cards */
    .chart-box {
        height: 350px;
        background: #ffffff;
        border-radius: 12px;
    }

    .chart-box .card-header {
        font-weight: 600;
    }

    .chart-box canvas {
        width: 100% !important;
        height: 100% !important;
    }

    /* Soft Professional Colors */
    .bg-primary {
        background-color: #1f3c88 !important; /* Deep Blue */
    }

    .bg-success {
        background-color: #2e8b57 !important; /* Green */
    }

    .bg-warning {
        background-color: #f4a261 !important; /* Soft Orange */
        color: #000 !important;
    }

    .bg-secondary {
        background-color: #6c757d !important; /* Grey */
    }

    .bg-info {
        background-color: #457b9d !important; /* Blue-Grey */
    }
</style>

<h2 class="mb-4">Travel Management Dashboard</h2>

<!-- Summary Cards -->
<div class="row justify-content-between">

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h6>Total Trips</h6>
                <h3>{{ $totalTrips }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h6>Customers</h6>
                <h3>{{ $totalCustomers }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card bg-warning">
            <div class="card-body text-center">
                <h6>Total Revenue</h6>
                <h3>₹ {{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-white bg-secondary">
            <div class="card-body text-center">
                <h6>Cancel Requests</h6>
                <h3>{{ $totalCancels ?? 0 }}</h3>
            </div>
        </div>
    </div>

</div>

<div class="dashboard-wrapper">

    <div class="row mt-4 charts-bottom">

        <div class="col-md-6">
            <div class="card chart-box">
                <div class="card-header bg-info text-white">
                    Monthly Revenue
                </div>
                <div class="card-body">
                    <canvas id="monthlyRevenueChart"
                        data-revenue="{{ json_encode($monthlyRevenue) }}">
                    </canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card chart-box">
                <div class="card-header bg-success text-white">
                    Daily Revenue
                </div>
                <div class="card-body">
                    <canvas id="dailyRevenueChart"
                        data-revenue="{{ json_encode($dailyRevenue) }}">
                    </canvas>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const insideMessagePlugin = {
    id: 'insideMessagePlugin',
    afterDraw(chart) {
        const data = chart.data.datasets[0].data;

        if (!data || data.every(v => v === 0)) {
            const { ctx, chartArea } = chart;
            ctx.save();
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = 'bold 16px Arial';
            ctx.fillStyle = '#555';

            ctx.fillText(
                'This is a Bar Chart (No Data Available)',
                (chartArea.left + chartArea.right) / 2,
                (chartArea.top + chartArea.bottom) / 2
            );
            ctx.restore();
        }
    }
};

/* Monthly Chart */
const monthlyCanvas = document.getElementById('monthlyRevenueChart');
let monthlyRevenue = JSON.parse(monthlyCanvas.dataset.revenue);

if (!monthlyRevenue || monthlyRevenue.length === 0) {
    monthlyRevenue = Array(12).fill(0);
}

new Chart(monthlyCanvas, {
    type: 'bar',
    plugins: [insideMessagePlugin],
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            label: 'Monthly Revenue',
            data: monthlyRevenue,
            backgroundColor: '#457b9d',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

/* Daily Chart */
const dailyCanvas = document.getElementById('dailyRevenueChart');
let dailyRevenue = JSON.parse(dailyCanvas.dataset.revenue);

if (!dailyRevenue || dailyRevenue.length === 0) {
    dailyRevenue = [0];
}

new Chart(dailyCanvas, {
    type: 'bar',
    plugins: [insideMessagePlugin],
    data: {
        labels: ['Day 1'],
        datasets: [{
            label: 'Daily Revenue',
            data: dailyRevenue,
            backgroundColor: '#2e8b57',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endpush
