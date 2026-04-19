<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\PortfolioItem;
use App\Models\Review;
use App\Models\TeamMember;
use App\Models\Setting;
use App\Models\Message;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings   = $this->settings();
        $services   = Service::active()->take(3)->get();
        $portfolio = PortfolioItem::active()->get();
        $reviews    = Review::approved()->latest()->take(2)->get();
        $categories = PortfolioItem::categories();
        return view('index', compact('settings', 'services', 'portfolio', 'reviews', 'categories'));
    }

    public function about()
    {
        $settings = $this->settings();
        $team     = TeamMember::active()->get();

        return view('about', compact('settings', 'team'));
    }

    public function services()
    {
        $settings = $this->settings();
        $services = Service::active()->get();

        return view('services', compact('settings', 'services'));
    }

    public function portfolio()
    {
        $settings  = $this->settings();
        $portfolio = PortfolioItem::active()->get();
        $categories = PortfolioItem::categories();

        return view('portfolio', compact('settings', 'portfolio', 'categories'));
    }

    public function reviews()
    {
        $settings = $this->settings();
        $reviews  = Review::approved()->latest()->paginate(9);

        $totalApproved = Review::approved()->count();
        $avgRating     = Review::approved()->avg('rating');
        $ratingCounts  = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingCounts[$i] = Review::approved()->where('rating', $i)->count();
        }

        return view('reviews', compact('settings', 'reviews', 'totalApproved', 'avgRating', 'ratingCounts'));
    }

    public function contact()
    {
        $settings = $this->settings();
        $services = Service::active()->get();

        return view('contact', compact('settings', 'services'));
    }
    public function submitContact(Request $request)
    {
        // FIX 1: Validate all fields including 'service' (not 'service_interest')
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:20',
            'wedding_date' => 'nullable|date|after_or_equal:today',
            'service'      => 'nullable|string|max:255',
            'message'      => 'required|string|min:10',
        ]);

        // FIX 2: Use $request->input() for nullable fields to avoid missing-key errors
        // FIX 3: Map 'service' (form field) → 'service_interest' (DB column) explicitly
        Message::create([
            'name'             => $validated['name'],
            'email'            => $validated['email'],
            'phone'            => $validated['phone'],
            'wedding_date'     => $request->input('wedding_date') ?: null,
            'service_interest' => $request->input('service') ?: null,
            'message'          => $validated['message'],
            'newsletter'       => $request->has('newsletter') ? true : false,
            'is_read'          => false,
        ]);

        // FIX 4: Redirect to contact route instead of back() to avoid re-submission on refresh
        return redirect()->route('contact')->with('success', 'Thank you! Your message has been sent. We\'ll get back to you within 24 hours.');
    }
    private function settings(): array
    {
        $keys = ['studio_name','tagline','address','phone_primary','phone_secondary','email_primary',
                 'email_bookings','working_hours','whatsapp_number','instagram_url','facebook_url',
                 'pinterest_url','youtube_url','years_experience','weddings_count','clients_count',
                 'hero_title','hero_subtitle','hero_description','about_story','quote_text','quote_author'];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key, '');
        }
        return $settings;
    }
}
