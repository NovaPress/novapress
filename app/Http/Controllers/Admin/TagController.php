<?php

namespace App\Http\Controllers\Admin;

use App\Http\Filters\TagFilter;
use App\Http\Requests\Admin\Tags\StoreRequest;
use App\Http\Requests\Admin\Tags\UpdateRequest;
use App\Http\Resources\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends AdminController
{
    protected string $policyClass = Tag::class;

    /**
     * Get All Tags.
     */
    public function index(TagFilter $filters): Response
    {
        if ($this->isAble('view', Tag::class)) {
            $headers = [
                'Name',
                'Description',
                'Slug',
                'Count',
            ];

            return Inertia::render('Admin/Tags/Index', [
                'tags' => TagResource::collection(Tag::filter($filters)->paginate(10)),
                'headers' => $headers,
            ]);
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Create New Tag.
     */
    public function store(StoreRequest $request): RedirectResponse|Response
    {
        if ($this->isAble('create', Tag::class)) {
            Tag::create($request->validated());

            return redirect(route('admin.tags.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Show Specific Tag.
     */
    public function show(Tag $tag): Response
    {
        if ($this->isAble('view', Tag::class)) {
            return Inertia::render('Admin/Tags/Show', [
                'tag' => new TagResource($tag),
            ]);
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Update Tag.
     */
    public function update(UpdateRequest $request, Tag $tag): RedirectResponse|Response
    {
        if ($this->isAble('update', Tag::class)) {
            $tag->update($request->validated());

            return redirect(route('admin.tags.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Delete Tag.
     */
    public function destroy(Tag $tag): RedirectResponse|Response
    {
        if ($this->isAble('delete', Tag::class)) {
            $tag->delete();

            return redirect(route('admin.tags.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }
}
