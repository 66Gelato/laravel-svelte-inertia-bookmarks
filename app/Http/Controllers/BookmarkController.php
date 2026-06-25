<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookmarkController extends Controller
{
    public function index(Request $request): Response
    {
        $bookmarks = $request->user()
            ->bookmarks()
            ->latest()
            ->get();

        return Inertia::render('Bookmarks', [
            'bookmarks' => $bookmarks,
        ]);
    }
}
