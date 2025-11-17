<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #3a0ca3, #7209b7, #f72585);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        .login-card {
            width: 420px;
            padding: 40px;
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            transition: 0.3s ease-in-out;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 35px rgba(0,0,0,0.35);
        }

        h3 {
            text-align: center;
            color: #3a0ca3;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .form-control {
            border-radius: 12px;
            padding: 10px 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3a0ca3, #7209b7);
            border: none;
            padding: 10px;
            border-radius: 12px;
            transition: 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #560bad, #7209b7);
            transform: translateY(-2px);
        }

        a {
            text-decoration: none;
            color: #7209b7;
        }
        a:hover {
            color: #560bad;
        }
    </style>
</head>
<body>

    <div class="login-card">

        <h3>Sign In</h3>

        {{-- ❌ Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger text-center">
                @foreach ($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- ❌ Login Failed Message --}}
        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- ✅ Success Message --}}
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" 
                       name="email" 
                       class="form-control" 
                       required 
                       value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" 
                       name="password" 
                       class="form-control" 
                       required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-2">Login</button>
        </form>

        <p class="text-center mt-3">
            Don’t have an account?
            <a href="{{ route('register') }}">Sign up</a>
        </p>

    </div>

</body>
</html>
