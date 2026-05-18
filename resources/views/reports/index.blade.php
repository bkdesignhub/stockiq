@extends('layouts.app')

@section('title', 'Reports - StockIQ')

@section('content')
    <section class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Reports</p>
            <h1 class="page-title">Inventory intelligence report</h1>
            <p class="page-subtitle">Analyze stock value, purchase spend, expected profit, and margin performance.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('reports.monthly-profit') }}" class="btn-secondary">Monthly Profit</a>
            <a href="{{ route('reports.stock-worth') }}" class="btn-primary">Stock Worth</a>
        </div>
    </section>

    <section class="grid grid-cols-2 gap-3 lg:grid-cols-4">
        <div class="metric-card bg-blue-50 ring-1 ring-blue-100">
            <p class="metric-label text-blue-700">Stock Worth</p>
            <p class="metric-value text-blue-800">Rs. {{ number_format($stockWorth, 0) }}</p>
        </div>
        <div class="metric-card bg-green-50 ring-1 ring-green-100">
            <p class="metric-label text-green-700">Expected Profit</p>
            <p class="metric-value text-green-800">Rs. {{ number_format($expectedProfit, 0) }}</p>
        </div>
        <div class="metric-card">
            <p class="metric-label">Avg. Margin</p>
            <p class="metric-value">Rs. {{ number_format($averageMargin, 0) }}</p>
        </div>
        <div class="metric-card">
            <p class="metric-label">Products</p>
            <p class="metric-value">{{ $products->count() }}</p>
        </div>
    </section>

    <section class="mt-6 grid gap-5 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="app-panel p-5">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <p class="metric-label">Trend</p>
                    <h2 class="font-black text-[#071333]">Purchase vs Profit</h2>
                </div>
                <div class="flex gap-3 text-xs font-black">
                    <span class="text-blue-700">Purchase</span>
                    <span class="text-green-700">Profit</span>
                </div>
            </div>
            <div class="flex h-44 items-end gap-3">
                @foreach ([52, 78, 60, 82, 66, 91, 72, 88] as $bar)
                    <div class="flex flex-1 items-end gap-1">
                        <span class="flex-1 rounded-t-lg bg-blue-600" style="height: {{ $bar }}%"></span>
                        <span class="flex-1 rounded-t-lg bg-green-500" style="height: {{ max($bar - 22, 20) }}%"></span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="app-panel">
            <div class="app-panel-header">
                <div>
                    <p class="metric-label">Procurement</p>
                    <h2 class="font-black text-[#071333]">Vendor Spend</h2>
                </div>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($purchasesByVendor as $row)
                    <div class="flex justify-between gap-3 p-4">
                        <div>
                            <p class="font-black text-[#071333]">{{ $row->vendor->name }}</p>
                            <p class="text-sm font-bold text-slate-500">{{ $row->purchase_count }} purchases</p>
                        </div>
                        <p class="font-black text-blue-700">Rs. {{ number_format($row->total_spend, 0) }}</p>
                    </div>
                @empty
                    <p class="p-5 text-sm font-bold text-slate-500">No purchase spend yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="app-panel mt-6 overflow-hidden">
        <div class="app-panel-header">
            <div>
                <p class="metric-label">Profit Model</p>
                <h2 class="font-black text-[#071333]">Product Margin Performance</h2>
            </div>
        </div>
        <div class="divide-y divide-slate-100 lg:hidden">
            @forelse ($products->take(8) as $product)
                <div class="flex items-center justify-between gap-3 p-4">
                    <div class="flex items-center gap-3">
                        <span class="product-avatar">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                        <div>
                            <p class="font-black text-[#071333]">{{ $product->name }}</p>
                            <p class="text-xs font-bold text-slate-500">Margin Rs. {{ number_format($product->margin, 0) }}</p>
                        </div>
                    </div>
                    <p class="font-black text-green-700">Rs. {{ number_format($product->expected_profit, 0) }}</p>
                </div>
            @empty
                <p class="p-5 text-sm font-bold text-slate-500">No products to report yet.</p>
            @endforelse
        </div>
        <table class="desktop-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Stock</th>
                    <th>Avg Cost</th>
                    <th>Selling Price</th>
                    <th>Margin</th>
                    <th>Expected Profit</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="font-black text-[#071333]">{{ $product->name }}</td>
                        <td>{{ $product->current_stock }} {{ $product->unit }}</td>
                        <td>Rs. {{ number_format($product->average_cost, 2) }}</td>
                        <td>Rs. {{ number_format($product->selling_price, 2) }}</td>
                        <td class="text-green-700">Rs. {{ number_format($product->margin, 2) }}</td>
                        <td class="text-blue-700">Rs. {{ number_format($product->expected_profit, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">No products to report yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
