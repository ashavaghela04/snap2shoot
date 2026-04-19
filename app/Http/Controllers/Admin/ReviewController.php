<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'client_name'  => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'rating'       => 'required|integer|min:1|max:5',
            'review_text'  => 'required|string|min:10',
        ]);

        Review::create([
            'client_name'  => $request->client_name,
            'client_email' => $request->client_email,
            'rating'       => $request->rating,
            'review_text'  => $request->review_text,
            'status'       => 'pending',
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted for approval.');
    }

    public function index(Request $request)
    {
        $query = Review::latest();
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        $reviews = $query->paginate(15);
        return view('admin.reviews-manage', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['status' => 'approved']);
        return back()->with('success', 'Review approved.');
    }

    public function reject(Review $review)
    {
        $review->update(['status' => 'rejected']);
        return back()->with('success', 'Review rejected.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}