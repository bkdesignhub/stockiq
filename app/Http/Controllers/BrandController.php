<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();
        $brands = Brand::withCount('products')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('brands.index', [
            'brands' => $brands,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('brands.create', ['brand' => new Brand()]);
    }

    public function store(Request $request)
    {
        Brand::create($this->validated($request));

        return redirect()->route('brands.index')->with('status', 'Brand created.');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $brand->update($this->validated($request, $brand->id));

        return redirect()->route('brands.index')->with('status', 'Brand updated.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->with('status', 'Brand deleted.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:brands,name,' . $ignoreId],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
