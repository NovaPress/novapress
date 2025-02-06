<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\StoreRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('view', Category::class);

        $categories = Category::query()
            ->when(Request::input('search'), function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%');
            })->paginate(10)
            ->withQueryString()
            ->through(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'posts_count' => $category->posts()->count(),
                ];
            });

        $headers = [
            'Name',
            'Description',
            'Slug',
            'Count',
        ];

        $filters = Request::only('search');

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
            'headers' => $headers,
            'filters' => $filters,
        ]);
    }

    public function store(StoreRequest $request)
    {
        Gate::authorize('create', Category::class);

        Category::create($request->validated());

        return back()->with('status', 'Category created successfully');
    }

    public function show(Category $category)
    {
        Gate::authorize('view', $category);

        return Inertia::render('Admin/Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateRequest $request, Category $category)
    {
        Gate::authorize('update', $category);

        $category->update($request->validated());

        return redirect()->route('admin.categories.index')->with('status', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Category deleted successfully');
    }
}
