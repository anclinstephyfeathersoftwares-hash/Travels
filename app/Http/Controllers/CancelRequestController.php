<?php

namespace App\Http\Controllers;

use App\Models\CancelRequest;
use Illuminate\Http\Request;

class CancelRequestController extends Controller
{
    public function index()
    {
        $history = CancelRequest::latest()->get();
        return view('cancel.index', compact('history'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pnr' => 'required',
            'passenger_name' => 'required',
            'ticket_number' => 'required',
            'cancel_reason' => 'required',
            'cancel_date' => 'required',
            'flight_no' => 'required',
        ]);

        CancelRequest::create($request->all());

        return redirect()->back()->with('success', 'Cancel request submitted successfully.');
    }

    public function edit($id)
    {
        $cancel = CancelRequest::findOrFail($id);
        return view('cancel.edit', compact('cancel'));
    }

    public function update(Request $request, $id)
    {
        $cancel = CancelRequest::findOrFail($id);

        $cancel->update($request->all());

        return redirect()->route('cancel.index')->with('success', 'Cancel request updated.');
    }

    public function destroy($id)
    {
        CancelRequest::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Request deleted successfully.');
    }
}
