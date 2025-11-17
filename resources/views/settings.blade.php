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
<form action="{{ route('settings.company') }}" method="POST" enctype="multipart/form-data">
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