<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bookmark;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BookmarkController extends Controller
{
    public function index(Request $request): Response
    {
        $bookmarks = $request->user()
            ->bookmarks()
            ->with('tags') // eager load
            ->latest()
            ->get();

        return Inertia::render('Bookmarks', [
            'bookmarks' => $bookmarks,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'url' => ['required', 'url', 'max:2048'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'tags' => ['nullable', 'string', 'max:255'],
        ]);

        $bookmark = $request->user()->bookmarks()->create([
            'url' => $validated['url'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        $this->syncTags($request->user(), $bookmark, $validated['tags'] ?? '');
        
        // re-runs index method
        return back();
    }

    private function syncTags(User $user, Bookmark $bookmark, string $tagString): void
    {
        $names = collect(explode(',', $tagString))
            ->map(fn ($name) => trim($name))
            ->filter()        // drop empties
            ->unique()
            ->values();

        $tagIds = $names->map(function ($name) use ($user) {
            return $user->tags()->firstOrCreate(['name' => $name])->id;
        });

        $bookmark->tags()->sync($tagIds);
    }
}
