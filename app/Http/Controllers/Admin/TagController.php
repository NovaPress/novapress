<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tags\StoreRequest;
use App\Http\Requests\Admin\Tags\UpdateRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{
    public function index()
    {
        Gate::authorize('view', Tag::class);

        $tags = Tag::query()
            ->when(Request::input('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->paginate(10)
            ->withQueryString()
            ->through(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'description' => $tag->description,
                    'posts_count' => $tag->posts()->count(),
                ];
            });

        $headers = [
            'Name',
            'Description',
            'Slug',
            'Count',
        ];

        $filters = Request::only('search');

        return Inertia::render('Admin/Tags/Index', [
            'tags' => $tags,
            'headers' => $headers,
            'filters' => $filters,
        ]);
    }

    public function store(StoreRequest $request)
    {
        Gate::authorize('create', Tag::class);

        Tag::create($request->validated());

        return back()->with('status', 'Tag created successfully');
    }

    public function show(Tag $tag)
    {
        Gate::authorize('view', $tag);

        return Inertia::render('Admin/Tags/Edit', [
            'tag' => $tag,
        ]);
    }

    public function update(UpdateRequest $request, Tag $tag)
    {
        Gate::authorize('update', $tag);

        $tag->update($request->validated());

        return redirect()->route('admin.tags.index')->with('status', 'Tag updated successfully');
    }

    public function destroy(Tag $tag)
    {
        Gate::authorize('delete', $tag);

        $tag->delete();

        return redirect()->route('admin.tags.index')->with('status', 'Tag deleted successfully');
    }
}
