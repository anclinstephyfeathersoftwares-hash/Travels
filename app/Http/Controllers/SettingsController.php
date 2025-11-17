<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class SettingsController extends Controller
{
    public function index()
    {
        return view('settings'); 
    }

    // Update Profile Image
    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();

        $file = $request->file('profile_image');
        $name = time() . '_profile.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/profile'), $name);

        $user->profile_image = $name;
        $user->save();

        return back()->with('success', 'Profile image updated!');
    }

    // Update Logo
    public function updateCompanyImage(Request $request)
{
    $request->validate([
        'company_image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048'
    ]);

    $user = auth()->user();

    if ($request->hasFile('company_image')) {

        $file = $request->file('company_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/company'), $filename);

        $user->company_image = $filename;
    }

    $user->save();

    return back()->with('success', 'Company image updated successfully!');
}

    // Update Username + Password
    public function updateAccount(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|min:6'
        ]);

        $user = Auth::user();
        $user->name = $request->username;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Account updated!');
    }

    // Delete Account
    public function deleteAccount()
    {
        $user = Auth::user();
        $user->delete();
        Auth::logout();

        return redirect('/')->with('success', 'Account deleted!');
    }
}
