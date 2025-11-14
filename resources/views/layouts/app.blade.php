<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            display: block;
        }

        .sidebar ul li:hover {
            background: rgba(255, 255, 255, 0.1);
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
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('commission.index') }}">Commission</a></li>
            <li><a href="#">Ticket Cancel</a></li>
            <li><a href="#">Bus Ticket</a></li>
            <li><a href="#">Air Ticket</a></li>
            <li><a href="#">Salary</a></li>
            <li><a href="#">Expenses</a></li>
            <li><a href="#">Staff</a></li>
            <li><a href="#">Staff Salary</a></li>
           <li><a href="#">Settings</a></li>


            <li class="mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-light btn-sm w-100">Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content-area">
        @yield('content')
    </div>

</body>
</html>
