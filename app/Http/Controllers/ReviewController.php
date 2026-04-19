<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'client_name'  => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'rating'       => 'required|integer|min:1|max:5',
            'review_text'  => 'required|string|min:10',
            'client_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('client_image') && $request->file('client_image')->isValid()) {
            $imagePath = $request->file('client_image')->store('reviews', 'public');
        }

        Review::create([
            'client_name'      => $request->client_name,
            'client_email'     => $request->client_email,
            'rating'           => $request->rating,
            'review_text'      => $request->review_text,
            'client_image_url' => $imagePath ? 'storage/' . $imagePath : null,
            'status'           => 'pending',
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
        // Delete image file from storage when review is deleted
        if ($review->client_image_url) {
            $path = str_replace('storage/', '', $review->client_image_url);
            Storage::disk('public')->delete($path);
        }
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}