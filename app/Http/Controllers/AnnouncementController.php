<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with('creator');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $announcements = $query->latest()->paginate(10)->withQueryString();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'created_by' => auth()->id(),
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
            'is_pinned' => $request->has('is_pinned') ? 1 : 0,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully!');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
        ]);

        $wasPublished = $announcement->status === 'published';
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => (!$wasPublished && $request->status === 'published') ? now() : $announcement->published_at,
            'is_pinned' => $request->has('is_pinned') ? 1 : 0,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }

    /**
     * Public view — All published announcements for employees/managers
     */
    public function publicIndex()
    {
        $announcements = Announcement::where('status', 'published')
            ->with('creator')
            ->orderBy('is_pinned', 'desc')
            ->latest('published_at')
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }
}
