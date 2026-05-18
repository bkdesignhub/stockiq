@extends('layouts.app')

@section('title', 'Stock Worth Summary - StockIQ')

@section('content')
    <section class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Reports</p>
            <h1 class="page-title">Stock Worth Summary</h1>
            <p class="page-subtitle">Monthly stock value, total quantity, category value, and top inventory value contributors.</p>
        </div>
        <a href="{{ route('reports.monthly-profit') }}" class="btn-secondary">Monthly Profit</a>
    </section>

    <section class="grid gap-4 lg:grid-cols-3">
        <div class="metric-card"><p class="metric-label">Total Items</p><p class="metric-value">{{ $products->count() }}</p></div>
        <div class="metric-card"><p class="metric-label">Total Quantity</p><p class="metric-value">{{ number_format($totalQuantity, 0) }}</p></div>
        <div class="metric-card bg-blue-50"><p class="metric-label text-blue-700">Stock Value</p><p class="metric-value text-blue-700">Rs. {{ number_format($stockWorth, 0) }}</p></div>
    </section>

    <section class="mt-5 grid gap-5 lg:grid-cols-[0.8fr_1.2fr]">
        <article class="app-panel p-5">
            <h2 class="font-bold text-slate-950">Category Breakdown</h2>
            <div class="mt-5 space-y-3">
                @forelse ($categoryBreakdown as $category)
                    <div class="rounded-xl border border-slate-200 p-4">
                        <div class="flex justify-between"><p class="font-semibold text-slate-950">{{ $category['name'] }}</p><p class="font-bold text-blue-700">Rs. {{ number_format($category['worth'], 0) }}</p></div>
                        <p class="mt-1 text-xs font-medium text-slate-500">{{ $category['quantity'] }} qty / {{ $category['count'] }} items</p>
                    </div>
                @empty
                    <p class="text-sm font-medium text-slate-500">No stock worth data yet.</p>
                @endforelse
            </div>
        </article>

        <article class="app-panel overflow-hidden">
            <div class="app-panel-header"><h2 class="font-bold text-slate-950">Top Stock Value Items</h2></div>
            <table class="desktop-table">
                <thead><tr><th>Product</th><th>Qty</th><th>Avg Cost</th><th>Stock Value</th></tr></thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr><td class="font-semibold text-slate-950">{{ $product->name }}</td><td>{{ $product->current_stock }}</td><td>Rs. {{ number_format($product->average_cost, 2) }}</td><td class="font-bold text-blue-700">Rs. {{ number_format($product->stock_worth, 2) }}</td></tr>
                    @empty
                        <tr><td colspan="4">No products yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </article>
    </section>
@endsection
