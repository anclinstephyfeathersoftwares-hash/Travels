<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up - Billing Software</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      height: 100vh;
      background: linear-gradient(135deg, #bfaee9ff, #d2b9e0ff);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
      color: #333;
    }

    .signup-container {
      display: flex;
      background: #fff;
      width: 900px;
      height: 560px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .signup-image {
      flex: 1;
      position: relative;
    }

    .signup-image-text {
      position: absolute;
      top: 30px;
      left: 50%;
      transform: translateX(-50%);
      text-align: center;
      color: #000;
      z-index: 2;
      width: 85%;
    }

    .signup-form {
      flex: 1;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .signup-form h4 {
      text-align: center;
      color: #3a0ca3;
      font-weight: 700;
      margin-bottom: 25px;
    }

    .form-control {
      border-radius: 10px;
      padding: 10px 14px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #59418dff, #ad5de2ff);
      border: none;
      border-radius: 10px;
      padding: 10px;
      transition: 0.3s;
    }

    .btn-primary:hover {
      transform: translateY(-1px);
    }

    .valid { color: green; }
    .invalid { color: red; }
    #password-rules { display: none; }

  </style>
</head>
<body>

<div class="signup-container">

  <!-- Left Side Image -->
  <div class="signup-image position-relative">
    <img src="images/b1.jpg" alt="Billing Dashboard" class="w-100 h-100 object-fit-cover">
    <div class="signup-image-text position-absolute p-4">
      <h3>Welcome to Smart Billing</h3>
      <p>Manage your invoices, clients, and reports all in one place.</p>
    </div>
  </div>

  <!-- Right Side Form -->
  <div class="signup-form">

    {{-- ✅ SUCCESS MESSAGE --}}
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    {{-- ❌ VALIDATION ERRORS --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <h4>Create Your Account</h4>

    <form action="{{ route('register.post') }}" method="POST" id="signupForm">
      @csrf
      <label class="form-label">
        <span style="color:red">*</span> Select Role
      </label>
      <select name="role" class="form-control mb-3" required>
        <option value="">Admin/Staff</option>
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
      </select>

      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>

        {{-- Password Rules --}}
        <ul id="password-rules" class="mt-2 mb-0 small">
          <li id="length" class="invalid">At least 5 characters</li>
          <li id="uppercase" class="invalid">At least one uppercase letter (A–Z)</li>
          <li id="symbol" class="invalid">At least one special symbol (!, @, #, $, etc.)</li>
        </ul>
      </div>

      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Sign Up</button>
    </form>

    <div class="text-center mt-3">
      Already have an account?
      <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const password = document.getElementById('password');
  const nameField = document.getElementById('name');
  const rulesBox = document.getElementById('password-rules');

  const rules = {
    length: document.getElementById('length'),
    uppercase: document.getElementById('uppercase'),
    symbol: document.getElementById('symbol'),
  };

  password.addEventListener('input', validatePassword);
  nameField.addEventListener('input', validatePassword);

  function validatePassword() {
    const val = password.value;

    rulesBox.style.display = val.length > 0 ? 'block' : 'none';

    toggleRule(rules.length, val.length >= 5);
    toggleRule(rules.uppercase, /[A-Z]/.test(val));
    toggleRule(rules.symbol, /[\W_]/.test(val));
  }

  function toggleRule(element, condition) {
    if (condition) {
      element.classList.add('valid');
      element.classList.remove('invalid');
    } else {
      element.classList.add('invalid');
      element.classList.remove('valid');
    }
  }
});
</script>

</body>
</html>
