<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $items      = PortfolioItem::orderBy('sort_order')->get();
        $categories = PortfolioItem::categories();
        return view('admin.portfolio-manage', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'category'    => 'required|in:wedding,prewedding,maternity,engagement,traditional',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // max 5 MB
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        // Store image under storage/app/public/portfolio/
        $path = $request->file('image')->store('portfolio', 'public');

        PortfolioItem::create([
            'title'       => $validated['title'],
            'location'    => $validated['location'] ?? null,
            'category'    => $validated['category'],
            'image_path'  => $path,
            'description' => $validated['description'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order'  => PortfolioItem::max('sort_order') + 1,
        ]);

        return back()->with('success', 'Portfolio item added.');
    }

    public function update(Request $request, PortfolioItem $portfolioItem)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'category'    => 'required|in:wedding,prewedding,maternity,engagement,traditional',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = [
            'title'       => $validated['title'],
            'location'    => $validated['location'] ?? null,
            'category'    => $validated['category'],
            'description' => $validated['description'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'is_active'   => $request->boolean('is_active', true),
        ];

        // Replace image only if a new one was uploaded
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($portfolioItem->image_path);
            $data['image_path'] = $request->file('image')->store('portfolio', 'public');
        }

        $portfolioItem->update($data);

        return back()->with('success', 'Portfolio item updated.');
    }

    public function destroy(PortfolioItem $portfolioItem)
    {
        Storage::disk('public')->delete($portfolioItem->image_path);
        $portfolioItem->delete();
        return back()->with('success', 'Portfolio item deleted.');
    }
}