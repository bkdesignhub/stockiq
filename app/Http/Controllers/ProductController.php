<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();
        $products = Product::with(['productCategory', 'brand', 'purchaseItems', 'stockMovements'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('unit', 'like', "%{$search}%")
                        ->orWhereHas('productCategory', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('brand', fn ($query) => $query->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('products.create', $this->formData(new Product()));
    }

    public function store(Request $request)
    {
        Product::create($this->validated($request));

        return redirect()->route('products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', $this->formData($product));
    }

    public function show(Product $product)
    {
        return view('products.show', [
            'product' => $product->load(['productCategory', 'brand', 'purchaseItems.purchase', 'vendorPrices.vendor']),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request, $product->id));

        return redirect()->route('products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('status', 'Product deleted.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'sku' => ['required', 'string', 'max:80', 'unique:products,sku,' . $ignoreId],
            'name' => ['required', 'string', 'max:180'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'unit' => ['required', 'string', 'max:30'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'reorder_level' => ['required', 'integer', 'min:0'],
        ]);
    }

    private function formData(Product $product): array
    {
        return [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
            'brands' => Brand::orderBy('name')->get(),
        ];
    }
}
