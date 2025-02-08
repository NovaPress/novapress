<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $glanceData = [
            'posts' => Post::count(),
            'pages' => 0,
            'comments' => Comment::count(),
            'spam' => Comment::where('status', 'spam')->count(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'glanceData' => $glanceData,
        ]);
    }

    public function storeDraft(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Post::create([
            'user_id' => auth()->id(),
            'title' => $request['title'],
            'body' => $request['content'],
        ]);

        return redirect()->route('admin.index');
    }
}
