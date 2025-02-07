<?php

namespace App\Http\Controllers\Admin;

use App\Http\Filters\CategoryFilter;
use App\Http\Requests\Admin\Categories\StoreRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Http\Resources\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends AdminController
{
    protected string $policyClass = Category::class;

    /**
     * Get All Categories.
     */
    public function index(CategoryFilter $filters): Response
    {
        if ($this->isAble('view', Category::class)) {
            $headers = [
                'Name',
                'Description',
                'Slug',
                'Count',
            ];

            return Inertia::render('Admin/Categories/Index', [
                'categories' => CategoryResource::collection(Category::filter($filters)->paginate(10)),
                'headers' => $headers,
            ]);
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Create New Category.
     */
    public function store(StoreRequest $request): RedirectResponse|Response
    {
        if ($this->isAble('create', Category::class)) {
            Category::create($request->validated());

            return redirect(route('admin.categories.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Show Specific Category
     */
    public function show(Category $category): Response
    {
        if ($this->isAble('view', Category::class)) {
            return Inertia::render('Admin/Categories/Show', [
                'category' => new CategoryResource($category),
            ]);
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Update Category.
     */
    public function update(UpdateRequest $request, Category $category): RedirectResponse|Response
    {
        if ($this->isAble('update', Category::class)) {
            $category->update($request->validated());

            return redirect(route('admin.categories.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }

    /**
     * Delete Category.
     */
    public function destroy(Category $category): RedirectResponse|Response
    {
        if ($this->isAble('delete', Category::class)) {
            $category->delete();

            return redirect(route('admin.categories.index', absolute: false));
        }

        return Inertia::render('Admin/Error/403');
    }
}
