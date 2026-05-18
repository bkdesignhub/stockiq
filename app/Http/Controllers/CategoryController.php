<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();
        $categories = Category::withCount('products')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('categories.index', [
            'categories' => $categories,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('categories.create', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        Category::create($this->validated($request));

        return redirect()->route('categories.index')->with('status', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validated($request, $category->id));

        return redirect()->route('categories.index')->with('status', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('status', 'Category deleted.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:categories,name,' . $ignoreId],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
