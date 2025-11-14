@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<style>
    body {
        display: block !important;
        height: auto !important;
        overflow-x: hidden;
        background: none !important;
        margin: 0;
        padding-top: 70px;
    }

    .dropdown-menu {
        position: absolute !important;
    }
</style>

<body>

    <!--  Navbar -->
    <nav class="navbar px-4 py-2 shadow-sm fixed-top d-flex align-items-center"
        style="background: transparent !important;">

        <!-- Search -->
        <div class="flex-grow-1" style="margin-left: 250px;">
            <input type="text" class="form-control" placeholder="Search..."
                style="max-width: 350px; border: 1px solid #000; color: #000;">
        </div>

        <!-- Icons -->
        <ul class="navbar-nav ms-auto flex-row align-items-center">

            <!-- Notification -->
            <li class="nav-item me-3 position-relative">
                <a class="nav-link" href="#">
                    <i class="bi bi-bell fs-5" style="color: #000;"></i>
                    <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle p-1"></span>
                </a>
            </li>

            <!-- Messages -->
            <li class="nav-item me-3 position-relative">
                <a class="nav-link" href="#">
                    <i class="bi bi-envelope fs-5" style="color: #000;"></i>
                    <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle p-1"></span>
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center"
                    data-bs-toggle="dropdown" href="#" style="color: #000;">
                    <img src="https://via.placeholder.com/35" class="rounded-circle me-2">
                    <span style="color: #000;">Profile</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">My Account</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </li>

        </ul>
    </nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>