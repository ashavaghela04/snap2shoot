<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Review;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings   = Booking::count();
        $totalClients    = Booking::distinct('client_email')->count('client_email');
        $monthlyRevenue  = Booking::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');
        $upcomingCount   = Booking::where('status', 'confirmed')
            ->where('event_date', '>=', now())
            ->count();

        $upcomingBookings = Booking::with('service')
            ->where('status', 'confirmed')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(5)
            ->get();

        $recentMessages = Message::where('is_read', false)->latest()->take(5)->get();
        $pendingReviews = Review::where('status', 'pending')->count();

        $revenueData = [];
        for ($m = 1; $m <= 12; $m++) {
            $revenueData[] = Booking::where('status', 'completed')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->sum('amount');
        }

        return view('admin.dashboard', compact(
            'totalBookings', 'totalClients', 'monthlyRevenue', 'upcomingCount',
            'upcomingBookings', 'recentMessages', 'pendingReviews', 'revenueData'
        ));
    }
}
