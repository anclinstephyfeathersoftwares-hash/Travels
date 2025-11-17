<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Role</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container text-center mt-5">
        <h2>Select Login Type</h2>

        <a href="{{ route('login') }}?role=admin" class="btn btn-danger btn-lg mt-4 w-50">
            Login as Admin
        </a>

        <a href="{{ route('login') }}?role=staff" class="btn btn-primary btn-lg mt-4 w-50">
            Login as Staff
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
