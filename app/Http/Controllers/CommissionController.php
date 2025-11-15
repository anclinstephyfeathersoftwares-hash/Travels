<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $status = $request->status ?? '';

        $query = Commission::query();

        if ($search) {
            $query->where('receiver', 'LIKE', "%$search%")
                  ->orWhere('type', 'LIKE', "%$search%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        $commissions = $query->orderBy('date', 'desc')->paginate(10);

        return view('commission.index', compact('commissions', 'search', 'status'));
    }

    // ADD PAGE
    public function create()
    {
        return view('commission.create');
    }

    // STORE
    public function store(Request $request)
    {
        Commission::create([
            'receiver' => $request->receiver,
            'amount' => $request->amount,
            'date' => $request->date,
            'status' => $request->status,
            'type' => 'Commission',
        ]);

        return redirect()->route('commission.index')->with('success', 'Commission Added Successfully');
    }

    // EDIT PAGE
    public function edit($id)
    {
        $commission = Commission::findOrFail($id);
        return view('commission.edit', compact('commission'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $commission = Commission::findOrFail($id);

        $commission->update([
            'receiver' => $request->receiver,
            'amount' => $request->amount,
            'date' => $request->date,
            'status' => $request->status,
        ]);

        return redirect()->route('commission.index')->with('success', 'Commission Updated Successfully');
    }

    // DELETE
    public function destroy($id)
    {
        Commission::destroy($id);
        return redirect()->route('commission.index')->with('success', 'Commission Deleted Successfully');
    }
}
