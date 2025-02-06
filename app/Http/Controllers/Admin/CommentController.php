<?php

namespace App\Http\Controllers\Admin;

use App\Http\Filters\CommentFilter;
use App\Http\Requests\Admin\Comments\UpdateRequest;
use App\Http\Resources\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CommentController extends AdminController
{
    protected string $policyClass = Comment::class;

    /**
     * Get All Comments.
     */
    public function index(CommentFilter $filters): Response
    {
        if ($this->isAble('view', Comment::class)) {
            $headers = [
                'Author',
                'Comment',
                'Post',
                'Submitted On',
            ];

            return Inertia::render('Admin/Comments/Index', [
                'comments' => CommentResource::collection(Comment::filter($filters)->paginate(10)),
                'headers' => $headers,
            ]);
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Show Specific Comment.
     */
    public function show(Comment $comment): Response
    {
        if ($this->isAble('view', Comment::class)) {
            return Inertia::render('Admin/Comments/Show', [
                'comment' => new CommentResource($comment),
            ]);
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Update Comment.
     */
    public function update(UpdateRequest $request, Comment $comment): RedirectResponse|Response
    {
        if ($this->isAble('update', Comment::class)) {
            $comment->update($request->validated());

            return redirect(route('admin.comments.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Delete Comment.
     */
    public function destroy(Comment $comment): RedirectResponse|Response
    {
        if ($this->isAble('delete', Comment::class)) {
            $comment->delete();

            return redirect(route('admin.comments.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }
}
