@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #3a0ca3, #7209b7);
            color: white;
             padding-top: 70px; 

        }
        .container {
            text-align: center;
        }
        .btn {
            border-radius: 10px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark px-4 py-2 shadow-sm fixed-top d-flex align-items-center">

    <!-- Search -->
    <div class="flex-grow-1">
        <input type="text" class="form-control" placeholder="Search..." style="max-width: 350px;">
    </div>

    <!-- Icons -->
    <ul class="navbar-nav ms-auto flex-row align-items-center">

        <!-- Notification -->
        <li class="nav-item me-3 position-relative">
            <a class="nav-link text-white" href="#">
                <i class="bi bi-bell fs-5"></i>
                <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle p-1"></span>
            </a>
        </li>

        <!-- Messages -->
        <li class="nav-item me-3 position-relative">
            <a class="nav-link text-white" href="#">
                <i class="bi bi-envelope fs-5"></i>
                <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle p-1"></span>
            </a>
        </li>

        <!-- Profile -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white d-flex align-items-center"
               data-bs-toggle="dropdown" href="#">
                <img src="https://via.placeholder.com/35" class="rounded-circle me-2">
                <span>Profile</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">My Account</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </li>

    </ul>
</nav>
</body>
</html>
