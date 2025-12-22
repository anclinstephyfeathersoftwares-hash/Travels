<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    /**
     * Update Profile Image
     */
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Delete old image
        if ($user->profile_image && Storage::disk('public')->exists("profile/" . $user->profile_image)) {
            Storage::disk('public')->delete("profile/" . $user->profile_image);
        }

        // Upload new image
        $path = $request->file('profile_image')->store('profile', 'public');
        $user->profile_image = basename($path);
        $user->save();

        return back()->with('success', 'Profile image updated!');
    }

    /**
     * Update Company Image
     */
    public function updateCompanyImage(Request $request)
    {
        $request->validate([
            'company_image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048'
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Delete old company image
        if ($user->company_image && Storage::disk('public')->exists("company/" . $user->company_image)) {
            Storage::disk('public')->delete("company/" . $user->company_image);
        }

        // Upload new image
        $path = $request->file('company_image')->store('company', 'public');
        $user->company_image = basename($path);
        $user->save();

        return back()->with('success', 'Company image updated successfully!');
    }
    /**
     * Update Account Username + Password
     */
    public function updateAccount(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|min:6'
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->name = $request->username;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Account updated!');
    }

public function updateCompanyDetails(Request $request)
{
    // Validate data (optional)
    $request->validate([
        'company_name' => 'nullable|string|max:255',
        'company_address' => 'nullable|string',
        'company_phone' => 'nullable|string|max:20',
        'company_email' => 'nullable|email',
        'company_website' => 'nullable|string',
        'currency' => 'nullable|string',
    ]);

    // Fetch the first row (or create default)
    $company = \App\Models\Company::first() ?? new \App\Models\Company();

    $company->company_name = $request->company_name;
    $company->company_address = $request->company_address;
    $company->company_phone = $request->company_phone;
    $company->company_email = $request->company_email;
    $company->company_website = $request->company_website;
    $company->currency = $request->currency ?? 'INR';

    $company->save();

    return back()->with('success', 'Company details updated successfully');
}




    /**
     * Delete User Account
     */
    public function deleteAccount()
    {
        /** @var User $user */
        $user = Auth::user();

        // Delete profile image
        if ($user->profile_image && Storage::disk('public')->exists("profile/" . $user->profile_image)) {
            Storage::disk('public')->delete("profile/" . $user->profile_image);
        }

        // Delete company image
        if ($user->company_image && Storage::disk('public')->exists("company/" . $user->company_image)) {
            Storage::disk('public')->delete("company/" . $user->company_image);
        }

        // Delete user record
        $user->delete();

        Auth::logout();

        return redirect('/')->with('success', 'Account deleted!');
    }
}
