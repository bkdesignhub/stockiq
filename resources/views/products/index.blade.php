@extends('layouts.app')

@section('title', 'Products - StockIQ')

@section('content')
    <section class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Products</p>
            <h1 class="page-title">Product margin intelligence</h1>
            <p class="page-subtitle">Search SKUs, compare purchase cost to selling price, and monitor expected profit.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn-primary">Add Product</a>
    </section>

    <form method="GET" action="{{ route('products.index') }}" class="mb-5 flex items-center gap-2 rounded-2xl border border-blue-100 bg-white px-4 py-3 shadow-sm">
        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-4.3-4.3 M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" stroke-linecap="round"/></svg>
        <input name="search" value="{{ $search }}" placeholder="Search product, SKU, category, or brand..." class="min-h-0 flex-1 border-0 bg-transparent p-0 shadow-none focus:border-transparent focus:ring-0">
        @if ($search)
            <a href="{{ route('products.index') }}" class="desktop-action">Clear</a>
        @endif
    </form>

    <div class="grid gap-4 lg:hidden">
        @forelse ($products as $product)
            <article class="app-panel p-5">
                <div class="flex items-start gap-4">
                    <span class="product-avatar h-16 w-16 text-xl">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="text-xl font-black text-[#071333]">{{ $product->name }}</h2>
                                <p class="text-sm font-bold text-slate-500">{{ $product->productCategory?->name ?: 'Uncategorized' }}{{ $product->brand?->name ? ' / '.$product->brand->name : '' }} / {{ $product->unit }}</p>
                            </div>
                            <span class="{{ $product->current_stock <= $product->reorder_level ? 'red-pill' : 'green-pill' }}">{{ $product->current_stock <= $product->reorder_level ? 'Low' : 'In Stock' }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-5 grid grid-cols-3 gap-2 rounded-2xl bg-blue-50 p-3 ring-1 ring-blue-100">
                    <div><p class="stat-label">Qty</p><p class="stat-value">{{ $product->current_stock }}</p></div>
                    <div><p class="stat-label">Avg. Cost</p><p class="stat-value">Rs. {{ number_format($product->average_cost, 0) }}</p></div>
                    <div><p class="stat-label">Value</p><p class="stat-value text-blue-700">Rs. {{ number_format($product->stock_worth, 0) }}</p></div>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-2">
                    <div class="stat-tile"><p class="stat-label">Sell</p><p class="stat-value">Rs. {{ number_format($product->selling_price, 0) }}</p></div>
                    <div class="stat-tile"><p class="stat-label">Margin</p><p class="stat-value text-green-700">Rs. {{ number_format($product->margin, 0) }}</p></div>
                    <div class="stat-tile"><p class="stat-label">Profit</p><p class="stat-value text-green-700">Rs. {{ number_format($product->expected_profit, 0) }}</p></div>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-3">
                    <a href="{{ route('products.show', $product) }}" class="btn-secondary">Detail</a>
                    <a href="{{ route('products.edit', $product) }}" class="btn-secondary">Edit</a>
                    <a href="{{ route('purchases.create') }}" class="btn-primary">Purchase</a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn-danger w-full">Delete</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="app-panel p-8 text-center">
                <p class="text-lg font-black text-[#071333]">No products yet</p>
                <p class="mt-2 text-sm font-bold text-slate-500">Create products before posting purchases.</p>
                <a href="{{ route('products.create') }}" class="btn-primary mt-5">Add first product</a>
            </div>
        @endforelse
    </div>

    <div class="app-panel hidden overflow-hidden lg:block">
        <table class="desktop-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Stock</th>
                    <th>Avg Cost</th>
                    <th>Selling Price</th>
                    <th>Margin</th>
                    <th>Expected Profit</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <span class="product-avatar h-11 w-11">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                <div>
                                    <p class="font-black text-[#071333]">{{ $product->name }}</p>
                                    <p class="text-xs font-bold text-slate-400">{{ $product->productCategory?->name ?: 'Uncategorized' }}{{ $product->brand?->name ? ' / '.$product->brand->name : '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->sku }}</td>
                        <td><span class="{{ $product->current_stock <= $product->reorder_level ? 'red-pill' : 'green-pill' }}">{{ $product->current_stock }} {{ $product->unit }}</span></td>
                        <td>Rs. {{ number_format($product->average_cost, 2) }}</td>
                        <td>Rs. {{ number_format($product->selling_price, 2) }}</td>
                        <td class="text-green-700">Rs. {{ number_format($product->margin, 2) }}</td>
                        <td class="text-blue-700">Rs. {{ number_format($product->expected_profit, 2) }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('products.show', $product) }}" class="desktop-action">View</a>
                                <a href="{{ route('products.edit', $product) }}" class="desktop-action">Edit</a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="desktop-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $products->links() }}</div>
@endsection
