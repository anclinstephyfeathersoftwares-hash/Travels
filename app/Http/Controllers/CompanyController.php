<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        if (Company::first()) {
            return redirect()->route('select.role');
        }

        return view('company.setup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'company_email' => 'required|email',
        ]);

        Company::create([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
        ]);

        return redirect()->route('select.role');
    }
}
