<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Setup</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5" style="max-width: 600px;">
    <h2 class="text-center mb-4">Enter Company Details</h2>

    <form action="{{ route('company.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Company Name</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Company Email</label>
            <input type="email" name="company_email" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Save Company Details</button>
    </form>
</div>

</body>
</html>
