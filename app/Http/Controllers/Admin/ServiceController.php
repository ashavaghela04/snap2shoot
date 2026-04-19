<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->get();
        return view('admin.services-manage', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price_label' => 'required|string|max:255',
            'icon'        => 'required|string|max:100',
            'description' => 'required|string',
            'image_url'   => 'nullable|url',
            'features'    => 'nullable|string',
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->features ?? '')));

        Service::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'price_label' => $validated['price_label'],
            'icon'        => $validated['icon'],
            'description' => $validated['description'],
            'image_url'   => $validated['image_url'] ?? null,
            'features'    => $features,
            'sort_order'  => Service::max('sort_order') + 1,
        ]);

        return back()->with('success', 'Service added successfully.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price_label' => 'required|string|max:255',
            'icon'        => 'required|string|max:100',
            'description' => 'required|string',
            'image_url'   => 'nullable|url',
            'features'    => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->features ?? '')));

        $service->update([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'price_label' => $validated['price_label'],
            'icon'        => $validated['icon'],
            'description' => $validated['description'],
            'image_url'   => $validated['image_url'] ?? null,
            'features'    => $features,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Service deleted.');
    }
}
