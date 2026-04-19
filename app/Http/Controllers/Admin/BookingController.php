<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('service')->latest();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(15);
        $services = Service::active()->get();

        return view('admin.bookings', compact('bookings', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name'    => 'required|string|max:255',
            'client_email'   => 'required|email',
            'client_phone'   => 'required|string|max:20',
            'service_id'     => 'nullable|exists:services,id',
            'event_date'     => 'nullable|date',
            'event_location' => 'nullable|string|max:255',
            'amount'         => 'nullable|numeric',
            'notes'          => 'nullable|string',
            'status'         => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        Booking::create($validated);
        return back()->with('success', 'Booking created successfully.');
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'amount' => 'nullable|numeric',
            'notes'  => 'nullable|string',
        ]);

        $booking->update($validated);
        return back()->with('success', 'Booking updated.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking deleted.');
    }
}
