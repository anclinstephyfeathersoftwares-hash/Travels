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

    return view('commission', compact('commissions', 'search', 'status'));
}


   public function store(Request $request)
{
    Commission::create([
        'receiver' => $request->receiver,
        'amount' => $request->amount,
        'date' => $request->date,
        'status' => $request->status,
        'type' => 'Default',  // change if needed
    ]);

    return redirect()->route('commission.index')->with('success', 'Commission Added Successfully');
}

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

public function destroy($id)
{
    Commission::destroy($id);
    
    return redirect()->route('commission.index')->with('success', 'Commission Deleted Successfully');
}

}
