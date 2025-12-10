@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 650px;">

    <div class="card p-4 shadow-lg border-0" style="border-radius: 12px;">
        <h2 class="mb-4 text-center">Settings</h2>

        {{-- Profile Image --}}
        <form action="{{ route('settings.profile') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="form-label">Profile Image</label><br>

            {{-- Preview --}}
            <img id="profilePreview"
                src="{{ auth()->user()->profile_image ? asset('uploads/profile/'.auth()->user()->profile_image) : 'https://via.placeholder.com/120' }}"
                class="rounded"
                style="width:120px; height:120px; object-fit:cover; border:2px solid #ddd; margin-bottom:10px;">

            <input type="file" name="profile_image" class="form-control" onchange="loadProfileImage(event)">
            <button class="btn btn-primary w-100 mt-2">Update Profile</button>
        </form>

        <hr>

        {{-- Logo --}}
        <form action="{{ route('settings.companyLogo') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="form-label">Logo</label><br>

            {{-- Preview --}}
            <img id="logoPreview"
                src="{{ auth()->user()->company_image ? asset('uploads/company/'.auth()->user()->company_image) : 'https://via.placeholder.com/120' }}"
                class="rounded"
                style="width:120px; height:120px; object-fit:cover; border:2px solid #ddd; margin-bottom:10px;">

            <input type="file" name="company_image" class="form-control" onchange="loadLogo(event)">
            <button class="btn btn-warning w-100 mt-2">Update Logo</button>
        </form>

        <hr>

        {{-- Company Details --}}
        <form action="{{ route('settings.companyDetails') }}" method="POST">
            @csrf

            <h5 class="mt-3">Company Details</h5>

            <label class="form-label">Company Name</label>
            <input type="text" name="company_name" class="form-control"
                value="{{ auth()->user()->company_name }}">

            <label class="form-label mt-2">Address</label>
            <textarea name="company_address" class="form-control" rows="2">{{ auth()->user()->company_address }}</textarea>

            <label class="form-label mt-2">Phone Number</label>
            <input type="text" name="company_phone" class="form-control"
                value="{{ auth()->user()->company_phone }}">

            <label class="form-label mt-2">Currency (INR / USD etc.)</label>
            <input type="text" name="currency" class="form-control"
                value="{{ auth()->user()->currency ?? 'INR' }}">

            <label class="form-label mt-2">Website (optional)</label>
            <input type="text" name="company_website" class="form-control"
                value="{{ auth()->user()->company_website }}">

            <label class="form-label mt-2">Email (optional)</label>
            <input type="email" name="company_email" class="form-control"
                value="{{ auth()->user()->company_email }}">

            <button class="btn btn-info w-100 mt-3">Save Company Details</button>
        </form>

        <hr>

        {{-- Username + Password --}}
        <form action="{{ route('settings.account') }}" method="POST">
            @csrf

            <label class="form-label">Username</label>
            <input type="text" name="username" value="{{ auth()->user()->name }}" class="form-control">

            <label class="form-label mt-2">New Password</label>
            <input type="password" name="password" class="form-control">

            <button class="btn btn-success w-100 mt-3">Save Changes</button>
        </form>

        <hr>

        {{-- Delete Account --}}
        <form action="{{ route('settings.delete') }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger w-100" onclick="return confirm('Delete your account?')">
                Delete Account
            </button>
        </form>
    </div>
</div>

{{-- Image Preview Script --}}
<script>
    function loadProfileImage(event) {
        var output = document.getElementById('profilePreview');
        output.src = URL.createObjectURL(event.target.files[0]);
    }

    function loadLogo(event) {
        var output = document.getElementById('logoPreview');
        output.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

@endsection
