<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeamMember;

class TeamController extends Controller
{
    /**
     * Display all team members.
     */
    public function index()
    {
        $team = TeamMember::latest()->get();

        return view('admin.team-members', compact('team'));
    }

    /**
     * Store or update a team member.
     *
     * FIXES:
     * - Added validation
     * - Only pass clean/allowed fields to updateOrCreate (not raw $request->all()
     *   which includes the 'photo' UploadedFile object and could cause mass-assignment issues)
     * - Properly handle image storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:20',
            'experience'  => 'nullable|integer|min:0|max:100',
            'bio'         => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Build only the allowed data array (never pass raw request->all())
        $data = [
            'name'        => $request->name,
            'designation' => $request->designation,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'experience'  => $request->experience,
            'bio'         => $request->bio,
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['image_url'] = $request->file('photo')->store('team', 'public');
        }

        // If editing (id present), update; otherwise create
        if ($request->filled('id')) {
            $member = TeamMember::findOrFail($request->id);
            $member->update($data);
        } else {
            TeamMember::create($data);
        }

        return back()->with('success', 'Team member saved successfully.');
    }

    /**
     * Delete a team member.
     *
     * FIX: This method was completely missing from the original controller,
     * causing a 404/500 error when the delete button was clicked.
     * Route: admin.team.delete expects this method.
     */
    public function delete($id)
    {
        $member = TeamMember::findOrFail($id);

        // Optionally delete the stored image file
        if ($member->image_url) {
            \Storage::disk('public')->delete($member->image_url);
        }

        $member->delete();

        return back()->with('success', 'Team member deleted successfully.');
    }
}