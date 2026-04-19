<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $keys = ['studio_name','tagline','address','phone_primary','phone_secondary',
                 'email_primary','email_bookings','working_hours','whatsapp_number',
                 'instagram_url','facebook_url','pinterest_url','youtube_url',
                 'years_experience','weddings_count','clients_count',
                 'hero_title','hero_subtitle','hero_description','about_story',
                 'quote_text','quote_author'];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key, '');
        }

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $allowedKeys = ['studio_name','tagline','address','phone_primary','phone_secondary',
                        'email_primary','email_bookings','working_hours','whatsapp_number',
                        'instagram_url','facebook_url','pinterest_url','youtube_url',
                        'years_experience','weddings_count','clients_count',
                        'hero_title','hero_subtitle','hero_description','about_story',
                        'quote_text','quote_author'];

        foreach ($allowedKeys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
