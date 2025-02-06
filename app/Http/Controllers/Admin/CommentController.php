<?php

namespace App\Http\Controllers\Admin;

use App\Http\Filters\CommentFilter;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Http\Resources\Resources\CommentResource;
use App\Http\Resources\Resources\UserResource;
use App\Models\Comment;
use App\Models\User;
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
     * Show Page For Creating New User
     */
    public function create(): Response
    {
        if ($this->isAble('create', User::class)) {
            return Inertia::render('Admin/Users/Show');
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Create New User.
     */
    public function store(StoreRequest $request): RedirectResponse|Response
    {
        if ($this->isAble('create', User::class)) {
            $user = User::create($request->validated());

            $user->assignRole($request->role);

            return redirect(route('admin.users.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Show Specific User.
     */
    public function show(User $user): Response
    {
        if ($this->isAble('view', User::class)) {
            return Inertia::render('Admin/Users/Show', [
                'user' => new UserResource($user),
            ]);
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Show User's Profile Page.
     */
    public function showProfile(): Response
    {
        if ($this->isAble('view', User::class)) {
            return Inertia::render('Admin/Users/Show', [
                'user' => new UserResource(auth()->user()),
            ]);
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Update User.
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse|Response
    {
        if ($this->isAble('update', User::class)) {
            $user->update($request->validated());

            if ($request->role !== $user->roles()->first()->name) {
                $user->removeRole($user->roles()->first()->name);
                $user->assignRole($request->role);
            }

            return redirect(route('admin.users.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Delete User.
     */
    public function destroy(User $user): RedirectResponse|Response
    {
        if ($this->isAble('delete', User::class)) {
            $user->delete();

            return redirect(route('admin.users.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }
}
