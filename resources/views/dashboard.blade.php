<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #3a0ca3, #7209b7);
            color: white;
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
    <div class="container">
        <h1>Welcome to Your Dashboard System</h1>
        <p class="mt-3">Please login or register to continue.</p>
        <a href="{{ route('login') }}" class="btn btn-light me-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>
    </div>
</body>
</html>
