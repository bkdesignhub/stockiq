@extends('layouts.app')

@section('title', 'Stocks - StockIQ')

@section('content')
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Inventory</p>
            <h1 class="page-title">Stock worth analysis</h1>
            <p class="page-subtitle">Monitor on-hand quantity, purchase cost, stock value, reorder status, and expected profit.</p>
        </div>
        <a href="{{ route('purchases.create') }}" class="btn-primary">Add Stock</a>
    </div>

    <section class="grid gap-4 lg:hidden">
        @foreach ($products as $product)
            <article class="app-panel p-5">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="product-avatar">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                        <div>
                            <h2 class="font-black text-[#071333]">{{ $product->name }}</h2>
                            <p class="text-sm font-bold text-slate-500">{{ $product->sku }} / reorder {{ $product->reorder_level }}</p>
                        </div>
                    </div>
                    <p class="{{ $product->current_stock <= $product->reorder_level ? 'red-pill' : 'green-pill' }}">{{ $product->current_stock }}</p>
                </div>
                <div class="mt-5 grid grid-cols-3 gap-3">
                    <div class="stat-tile"><p class="stat-label">Avg cost</p><p class="stat-value">Rs. {{ number_format($product->average_cost, 2) }}</p></div>
                    <div class="stat-tile"><p class="stat-label">Worth</p><p class="stat-value">Rs. {{ number_format($product->stock_worth, 2) }}</p></div>
                    <div class="stat-tile bg-green-50 ring-green-100"><p class="stat-label text-green-700">Profit</p><p class="stat-value text-green-800">Rs. {{ number_format($product->expected_profit, 2) }}</p></div>
                </div>
            </article>
        @endforeach
    </section>

    <div class="app-panel hidden overflow-hidden lg:block">
        <table class="desktop-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Current Stock</th>
                    <th>Reorder Level</th>
                    <th>Avg Cost</th>
                    <th>Stock Worth</th>
                    <th>Expected Profit</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <span class="product-avatar h-11 w-11">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                <span class="font-black text-[#071333]">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->current_stock }} {{ $product->unit }}</td>
                        <td>{{ $product->reorder_level }}</td>
                        <td>Rs. {{ number_format($product->average_cost, 2) }}</td>
                        <td class="text-blue-700">Rs. {{ number_format($product->stock_worth, 2) }}</td>
                        <td class="text-green-700">Rs. {{ number_format($product->expected_profit, 2) }}</td>
                        <td><span class="{{ $product->current_stock <= $product->reorder_level ? 'red-pill' : 'green-pill' }}">{{ $product->current_stock <= $product->reorder_level ? 'Low Stock' : 'Healthy' }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="8">No stock records yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $products->links() }}</div>

    <section class="mt-6 grid gap-5 lg:grid-cols-[0.75fr_1.25fr]">
        <form method="POST" action="{{ route('stocks.store') }}" class="app-panel p-5">
            @csrf
            <div class="mb-4">
                <p class="metric-label">Movement</p>
                <h2 class="text-lg font-black text-[#071333]">Manual stock adjustment</h2>
            </div>
            <div class="grid gap-3">
                <select name="product_id" required>
                    @foreach ($allProducts as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <select name="type" required>
                    <option value="adjustment">Adjustment in</option>
                    <option value="sale">Stock out</option>
                    <option value="return">Return in</option>
                </select>
                <div class="grid grid-cols-2 gap-3">
                    <input type="number" min="1" name="quantity" placeholder="Qty" required>
                    <input type="number" step="0.01" min="0" name="unit_cost" placeholder="Unit cost">
                </div>
                <input type="date" name="movement_date" value="{{ now()->format('Y-m-d') }}" required>
                <input name="reference" placeholder="Reference">
                <button class="btn-primary">Record Movement</button>
            </div>
        </form>

        <div class="app-panel">
            <div class="app-panel-header">
                <div>
                    <p class="metric-label">Ledger</p>
                    <h2 class="font-black text-[#071333]">Recent movements</h2>
                </div>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($movements as $movement)
                    <div class="flex items-center justify-between gap-3 p-4">
                        <div class="flex items-center gap-3">
                            <span class="product-avatar">{{ strtoupper(substr($movement->product->name, 0, 1)) }}</span>
                            <div>
                                <p class="font-black text-[#071333]">{{ $movement->product->name }}</p>
                                <p class="text-sm font-bold text-slate-500">{{ $movement->movement_date->format('d M Y') }} / {{ $movement->type }}</p>
                            </div>
                        </div>
                        <p class="font-black {{ $movement->quantity < 0 ? 'text-red-700' : 'text-green-700' }}">{{ $movement->quantity }}</p>
                    </div>
                @empty
                    <p class="p-5 text-sm font-bold text-slate-500">No movements yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
