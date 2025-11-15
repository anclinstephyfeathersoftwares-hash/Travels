<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #3a0ca3, #7209b7);
            color: #fff;
            padding-top: 30px;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 12px 25px;
            transition: 0.3s ease;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Icon Animation */
        .sidebar ul li i {
            font-size: 18px;
            transition: transform 0.3s ease, color 0.3s ease, text-shadow 0.3s ease;
        }

        .sidebar ul li:hover i {
            transform: scale(1.4) rotate(15deg);
            color: #ffea00;
            text-shadow: 0 0 10px #ffea00, 0 0 20px #ffea00;
            animation: pulseGlow 0.6s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            0% { transform: scale(1.3) rotate(10deg); }
            100% { transform: scale(1.5) rotate(18deg); }
        }

        /* Row hover effect */
        .sidebar ul li:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateX(5px);
        }

        .content-area {
            margin-left: 250px;
            padding: 25px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h3>LOGO</h3>
        </div>

        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="bi bi-speedometer"></i> Dashboard</a></li>
            <li><a href="{{ route('commission.index') }}"><i class="bi bi-cash-coin"></i> Commission</a></li>
            <li><a href="#"><i class="bi bi-x-octagon"></i> Ticket Cancel</a></li>
            <li><a href="#"><i class="bi bi-bus-front-fill"></i> Bus Ticket</a></li>
            <li><a href="#"><i class="bi bi-airplane-engines"></i> Air Ticket</a></li>
            <li><a href="#"><i class="bi bi-wallet-fill"></i> Salary</a></li>
            <li><a href="#"><i class="bi bi-receipt-cutoff"></i> Expenses</a></li>
            <li><a href="#"><i class="bi bi-people-fill"></i> Staff</a></li>
            <li><a href="#"><i class="bi bi-cash-stack"></i> Staff Salary</a></li>
            <li><a href="#"><i class="bi bi-gear-fill"></i> Settings</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content-area">
        @yield('content')
    </div>

</body>
</html>
