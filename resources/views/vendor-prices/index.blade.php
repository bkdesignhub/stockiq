@extends('layouts.app')

@section('title', 'Vendor Comparison - StockIQ')

@section('content')
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Vendor Prices</p>
            <h1 class="page-title">Price comparison</h1>
            <p class="page-subtitle">Select an existing product to compare vendor purchase prices against the product selling price.</p>
        </div>
        <a href="{{ route('purchases.create') }}" class="btn-primary">Add Purchase</a>
    </div>

    <form method="GET" action="{{ route('vendor-prices.index') }}" class="app-panel mb-5 p-5">
        <div class="grid gap-4 lg:grid-cols-[1fr_auto] lg:items-end">
            <label class="block">
                <span class="text-sm font-bold text-[#071333]">Product</span>
                <select name="product_id" class="mt-1 w-full" required>
                    <option value="">Select product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected($selectedProductId == $product->id)>
                            {{ $product->name }} / {{ $product->sku }}
                        </option>
                    @endforeach
                </select>
            </label>
            <div class="flex gap-3">
                <button class="btn-primary">Compare</button>
                <a href="{{ route('vendor-prices.index') }}" class="btn-secondary">Clear</a>
            </div>
        </div>
    </form>

    @if ($selectedProduct)
        <section class="mb-5 grid gap-4 lg:grid-cols-4">
            <div class="metric-card">
                <p class="metric-label">Product</p>
                <p class="metric-value text-lg">{{ $selectedProduct->name }}</p>
            </div>
            <div class="metric-card">
                <p class="metric-label">Selling Price</p>
                <p class="metric-value">Rs. {{ number_format($selectedProduct->selling_price, 2) }}</p>
            </div>
            <div class="metric-card">
                <p class="metric-label">Best Vendor</p>
                <p class="metric-value text-lg">{{ $bestRow['vendor']->name ?? '-' }}</p>
            </div>
            <div class="metric-card">
                <p class="metric-label">Price Difference</p>
                <p class="metric-value text-blue-700">Rs. {{ number_format($spread, 2) }}</p>
            </div>
        </section>
    @endif

    <section class="app-panel overflow-hidden">
        @if (! $selectedProduct)
            <div class="p-8 text-center">
                <p class="text-lg font-black text-[#071333]">Select a product</p>
                <p class="mt-2 text-sm font-bold text-slate-500">All existing products are listed above. Choose one to see vendor purchase price comparison.</p>
            </div>
        @elseif ($comparisonRows->isEmpty())
            <div class="p-8 text-center">
                <p class="text-lg font-black text-[#071333]">No purchase prices found</p>
                <p class="mt-2 text-sm font-bold text-slate-500">This product has no purchase entries yet. Add a purchase to compare vendor prices.</p>
                <a href="{{ route('purchases.create') }}" class="btn-primary mt-5">Add Purchase</a>
            </div>
        @else
            <div class="app-panel-header">
                <div>
                    <h2 class="font-bold text-slate-950">Vendor price comparison</h2>
                    <p class="mt-1 text-sm font-semibold text-slate-500">Prices come from purchase history, grouped by vendor.</p>
                </div>
            </div>

            <div class="divide-y divide-slate-100 lg:hidden">
                @foreach ($comparisonRows as $row)
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-black text-[#071333]">{{ $row['vendor']->name }}</p>
                                <p class="mt-1 text-xs font-bold text-slate-500">
                                    Last purchase: {{ optional($row['last_purchase_date'])->format('d M Y') ?: '-' }}
                                </p>
                            </div>
                            @if ($loop->first)
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-black text-green-700">Lowest</span>
                            @endif
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="stat-tile">
                                <p class="stat-label">Latest Cost</p>
                                <p class="stat-value text-green-700">Rs. {{ number_format($row['latest_price'], 2) }}</p>
                            </div>
                            <div class="stat-tile">
                                <p class="stat-label">Selling Margin</p>
                                <p class="stat-value {{ $row['margin'] >= 0 ? 'text-blue-700' : 'text-red-700' }}">Rs. {{ number_format($row['margin'], 2) }}</p>
                            </div>
                            <div class="stat-tile">
                                <p class="stat-label">Avg Cost</p>
                                <p class="stat-value">Rs. {{ number_format($row['average_price'], 2) }}</p>
                            </div>
                            <div class="stat-tile">
                                <p class="stat-label">Qty Bought</p>
                                <p class="stat-value">{{ $row['quantity'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="hidden overflow-x-auto lg:block">
                <table class="desktop-table">
                    <thead>
                        <tr>
                            <th>Vendor</th>
                            <th>Latest Cost</th>
                            <th>Selling Price</th>
                            <th>Margin</th>
                            <th>Avg Cost</th>
                            <th>Lowest / Highest</th>
                            <th>Purchases</th>
                            <th>Last Purchase</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparisonRows as $row)
                            <tr>
                                <td class="font-black text-[#071333]">{{ $row['vendor']->name }}</td>
                                <td class="font-black {{ $loop->first ? 'text-green-700' : 'text-slate-950' }}">Rs. {{ number_format($row['latest_price'], 2) }}</td>
                                <td>Rs. {{ number_format($row['selling_price'], 2) }}</td>
                                <td class="font-black {{ $row['margin'] >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                                    Rs. {{ number_format($row['margin'], 2) }}
                                    <span class="text-xs font-bold text-slate-500">({{ number_format($row['margin_percent'], 1) }}%)</span>
                                </td>
                                <td>Rs. {{ number_format($row['average_price'], 2) }}</td>
                                <td>Rs. {{ number_format($row['lowest_price'], 2) }} / Rs. {{ number_format($row['highest_price'], 2) }}</td>
                                <td>{{ $row['purchase_count'] }} bills / {{ $row['quantity'] }} qty</td>
                                <td>{{ optional($row['last_purchase_date'])->format('d M Y') ?: '-' }}</td>
                                <td>
                                    @if ($loop->first)
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-black text-green-700">Lowest latest cost</span>
                                    @else
                                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">Compare</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
