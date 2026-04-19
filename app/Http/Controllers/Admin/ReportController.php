<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Message;

class ReportController extends Controller
{
    public function index()
    {
        $yearlyRevenue = Booking::where('status','completed')->whereYear('created_at', now()->year)->sum('amount');
        $totalBookings = Booking::count();
        $completedBookings = Booking::where('status','completed')->count();
        $pendingBookings = Booking::where('status','pending')->count();
        $totalReviews = Review::approved()->count();
        $avgRating = Review::approved()->avg('rating');
        $totalMessages = Message::count();

        $monthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyData[] = [
                'month'    => date('M', mktime(0,0,0,$m,1)),
                'revenue'  => Booking::where('status','completed')->whereYear('created_at',now()->year)->whereMonth('created_at',$m)->sum('amount'),
                'bookings' => Booking::whereYear('created_at',now()->year)->whereMonth('created_at',$m)->count(),
            ];
        }

        return view('admin.reports', compact(
            'yearlyRevenue','totalBookings','completedBookings','pendingBookings',
            'totalReviews','avgRating','totalMessages','monthlyData'
        ));
    }
}
