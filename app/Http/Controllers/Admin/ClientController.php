<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Booking::select('client_name','client_email','client_phone')
            ->selectRaw('COUNT(*) as booking_count, MAX(created_at) as last_booking, SUM(amount) as total_spent')
            ->groupBy('client_email','client_name','client_phone')
            ->orderByDesc('last_booking')
            ->paginate(20);

        return view('admin.clients', compact('clients'));
    }
}
