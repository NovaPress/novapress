<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->when(Request::input('search'), function ($query, $search) {
                $query->where('title', 'like', '%' . $search . '%');
            })->paginate(10)
            ->withQueryString()
            ->through(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'body' => $post->body,
                    'author' => $post->author->name,
                    'published_at' => $post->published_at,
                ];
            });

        $headers = [
            'Title',
            'Author',
            'Categories',
            'Tags',
            'Comments',
            'Date',
        ];

        $filters = Request::only('search');

        return Inertia::render('Admin/Posts/Index', [
            'posts' => $posts,
            'headers' => $headers,
            'filters' => $filters,
        ]);
    }
}
