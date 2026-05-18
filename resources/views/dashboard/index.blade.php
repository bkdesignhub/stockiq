@extends('layouts.app')

@section('title', 'Dashboard - StockIQ')

@php
    $icons = [
        'bar-chart' => '<path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>',
        'calendar' => '<path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/>',
        'rupee' => '<path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8 8"/><path d="M6 13h3"/><path d="M9 13c6 0 6-10 0-10"/>',
        'wallet' => '<path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3v4a1 1 0 0 1-1 1H5a2 2 0 0 1-2-2V5"/><path d="M18 12h.01"/>',
        'trend' => '<path d="m22 7-8.5 8.5-5-5L2 17"/><path d="M16 7h6v6"/>',
        'percent' => '<line x1="19" x2="5" y1="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>',
        'package' => '<path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>',
        'cart' => '<circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L21.8 7H5.12"/>',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'line-chart' => '<path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/>',
        'bell' => '<path d="M10.27 21a2 2 0 0 0 3.46 0"/><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'eye' => '<path d="M2.06 12.35a1 1 0 0 1 0-.7A10.75 10.75 0 0 1 12 5a10.75 10.75 0 0 1 9.94 6.65 1 1 0 0 1 0 .7A10.75 10.75 0 0 1 12 19a10.75 10.75 0 0 1-9.94-6.65Z"/><circle cx="12" cy="12" r="3"/>',
        'home' => '<path d="m3 9 9-7 9 7"/><path d="M9 22V12h6v10"/><path d="M5 10v12h14V10"/>',
        'boxes' => '<path d="M2.97 12.92 12 17.8l9.03-4.88"/><path d="M2.97 17.92 12 22.8l9.03-4.88"/><path d="M12 2 2.97 6.88 12 11.76l9.03-4.88Z"/>',
        'plus' => '<path d="M5 12h14"/><path d="M12 5v14"/>',
    ];
@endphp

@section('content')
    <script>
        window.StockIQDashboard = @json($dashboardChart);
    </script>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">Dashboard</h1>
            <p class="mt-1 text-sm font-medium text-slate-600">Welcome back. Here is your business overview.</p>
        </div>
        <button class="flex h-11 items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-950 shadow-sm">
            {{ now()->format('d M Y') }}
            <svg class="h-5 w-5 text-slate-700" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons['calendar'] !!}</svg>
        </button>
    </div>

    <section class="grid gap-5 xl:grid-cols-4">
        @foreach ([
            ['Total Stock Cost', $stockWorth, 'Rs.', 'Stock Cost', 'rupee', 'bg-blue-50 text-blue-700', '12%'],
            ['Expected Selling Value', $expectedSellingValue, 'Rs.', 'Selling Value', 'wallet', 'bg-orange-50 text-orange-600', '18%'],
            ['Expected Profit', $expectedProfit, 'Rs.', 'Profit', 'trend', 'bg-green-50 text-green-600', '15%'],
            ['Average Margin', $averageMargin, 'Rs.', 'Margin', 'percent', 'bg-red-50 text-red-600', '6%'],
        ] as [$label, $value, $prefix, $alt, $icon, $tone, $change])
            <article class="metric-card">
                <div class="flex items-center gap-5">
                    <span class="icon-bubble h-14 w-14 {{ $tone }}">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons[$icon] !!}</svg>
                    </span>
                    <div class="min-w-0">
                        <p class="metric-label">{{ $label }}</p>
                        <p class="metric-value">{{ $prefix }} {{ number_format($value, 0) }}</p>
                        <p class="mt-2 flex items-center gap-1 text-xs font-semibold text-slate-500">
                            <span class="text-green-600">Up {{ $change }}</span>
                            <span>vs last month</span>
                        </p>
                    </div>
                </div>
            </article>
        @endforeach
    </section>

    <section class="mt-5 grid gap-5 xl:grid-cols-[1fr_0.95fr]">
        <article class="glass-card p-5">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-950">Profit Overview</h2>
                    <div class="mt-3 flex gap-5 text-xs font-semibold">
                        <span class="flex items-center gap-2 text-blue-700"><span class="h-1.5 w-4 rounded-full bg-blue-600"></span>Profit</span>
                        <span class="flex items-center gap-2 text-green-600"><span class="h-1.5 w-4 rounded-full bg-green-600"></span>Margin %</span>
                    </div>
                </div>
                <button class="btn-secondary min-h-10 px-4 py-2">
                    Last 7 Days
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['chevron-down'] !!}</svg>
                </button>
            </div>
            <div class="chart-line relative h-60 rounded-2xl border border-slate-200 bg-white p-5">
                <canvas id="profitOverviewChart"></canvas>
            </div>
        </article>

        <article class="glass-card overflow-hidden">
            <div class="app-panel-header">
                <h2 class="text-lg font-bold text-slate-950">Top High Margin Products</h2>
                <a href="{{ route('reports.index') }}" class="text-sm font-bold text-blue-700">View All</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($topProducts as $product)
                    <div class="flex items-center justify-between px-5 py-4">
                        <div class="flex items-center gap-3">
                            <span class="product-avatar">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons['package'] !!}</svg>
                            </span>
                            <div>
                                <p class="font-semibold text-slate-950">{{ $product->name }}</p>
                                <p class="text-xs font-medium text-slate-500">{{ $product->productCategory?->name ?: 'Uncategorized' }}</p>
                            </div>
                        </div>
                        <p class="text-sm font-bold text-green-700">Profit: Rs. {{ number_format($product->expected_profit, 0) }}</p>
                    </div>
                @empty
                    <p class="p-5 text-sm font-medium text-slate-500">No product profit data yet.</p>
                @endforelse
            </div>
        </article>
    </section>

    <section class="mt-5 grid gap-5 xl:grid-cols-[1.05fr_0.62fr_0.48fr]">
        <article class="glass-card overflow-hidden">
            <div class="app-panel-header">
                <h2 class="text-lg font-bold text-slate-950">Best Vendor Prices Today</h2>
                <a href="{{ route('vendor-prices.index') }}" class="text-sm font-bold text-blue-700">View All</a>
            </div>
            <table class="desktop-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Best Vendor</th>
                        <th>Best Price</th>
                        <th>Avg Price</th>
                        <th>Diff.</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vendorRows as $row)
                        <tr>
                            <td class="font-semibold text-slate-950">{{ $row['product'] }}</td>
                            <td><span class="green-pill">{{ $row['vendor'] }}</span></td>
                            <td>Rs. {{ number_format($row['best'], 2) }}</td>
                            <td>Rs. {{ number_format($row['avg'], 2) }}</td>
                            <td class="font-semibold text-green-700">Rs. {{ number_format($row['diff'], 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Add vendor prices to compare suppliers.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </article>

        <article class="glass-card p-5">
            <h2 class="text-lg font-bold text-slate-950">Stock Summary</h2>
            <div class="mt-6 grid place-items-center">
                <div class="relative h-44 w-44">
                    <canvas id="stockCategoryChart"></canvas>
                    <div class="absolute inset-9 grid place-items-center rounded-full bg-white text-center">
                        <span class="text-xs font-medium text-slate-500">Total Items</span>
                        <span class="block text-2xl font-extrabold text-slate-950">{{ $productCount }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-5 space-y-2 text-sm font-medium">
                @forelse ($categoryBreakdown->take(5) as $category)
                    <p class="flex justify-between"><span class="text-slate-600">{{ $category['name'] }}</span><span class="font-bold text-slate-950">{{ $category['count'] }}</span></p>
                @empty
                    <p class="text-slate-500">No category data yet.</p>
                @endforelse
            </div>
        </article>

        <article class="glass-card overflow-hidden">
            <div class="app-panel-header">
                <h2 class="text-lg font-bold text-slate-950">Low Margin Products</h2>
                <a href="{{ route('reports.index') }}" class="text-sm font-bold text-blue-700">View All</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($lowMarginProducts as $product)
                    <div class="flex items-center justify-between px-5 py-4">
                        <div>
                            <p class="font-semibold text-slate-950">{{ $product->name }}</p>
                            <p class="text-xs font-medium text-slate-500">Profit: Rs. {{ number_format($product->expected_profit, 0) }}</p>
                        </div>
                        <span class="red-pill">Rs. {{ number_format($product->margin, 0) }}</span>
                    </div>
                @empty
                    <p class="p-5 text-sm font-medium text-slate-500">No low margin products yet.</p>
                @endforelse
            </div>
        </article>
    </section>

    <section class="glass-card mt-5 overflow-hidden">
        <div class="app-panel-header">
            <h2 class="text-lg font-bold text-slate-950">Recent Purchases</h2>
            <a href="{{ route('purchases.index') }}" class="btn-primary min-h-10 px-4 py-2">View All Purchases</a>
        </div>
        <table class="desktop-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice No.</th>
                    <th>Vendor</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentPurchases as $purchase)
                    <tr>
                        <td>{{ $purchase->purchase_date->format('d M Y') }}</td>
                        <td>{{ $purchase->invoice_no ?: 'PUR-'.$purchase->id }}</td>
                        <td>{{ $purchase->vendor->name }}</td>
                        <td>{{ $purchase->items_count }}</td>
                        <td class="font-bold text-slate-950">Rs. {{ number_format($purchase->total, 2) }}</td>
                        <td>
                            <a href="{{ route('purchases.show', $purchase) }}" class="desktop-action" aria-label="View purchase">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['eye'] !!}</svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No purchases posted yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection

@section('mobile')
    <script>
        window.StockIQDashboard = @json($dashboardChart);
    </script>

    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-blue-50 text-blue-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['bar-chart'] !!}</svg>
            </span>
            <p class="text-xl font-extrabold tracking-tight text-slate-950">Stock<span class="text-emerald-500">IQ</span></p>
        </div>
        <button class="grid h-10 w-10 place-items-center rounded-xl bg-white text-slate-700 shadow-sm ring-1 ring-slate-200">
            <svg class="h-5.5 w-5.5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons['bell'] !!}</svg>
        </button>
    </div>

    <div class="mb-4 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-bold text-slate-950">Hi, {{ auth()->user()->name }}</h1>
            <p class="text-sm font-medium text-slate-600">Good Morning!</p>
        </div>
        <button class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-950 shadow-sm">
            Today
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['chevron-down'] !!}</svg>
        </button>
    </div>

    <section class="blue-summary">
        <div class="flex items-center justify-between">
            <p class="font-bold">Today's Overview</p>
            <svg class="h-6 w-6 text-blue-100" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons['bar-chart'] !!}</svg>
        </div>
        <div class="mt-5 grid grid-cols-2 gap-4">
            <div><p class="text-xs font-medium text-blue-100">Stock Cost</p><p class="mt-1 text-xl font-extrabold">Rs. {{ number_format($stockWorth, 0) }}</p></div>
            <div><p class="text-xs font-medium text-blue-100">Profit</p><p class="mt-1 text-xl font-extrabold">Rs. {{ number_format($expectedProfit, 0) }}</p></div>
            <div><p class="text-xs font-medium text-blue-100">Selling Value</p><p class="mt-1 text-xl font-extrabold">Rs. {{ number_format($expectedSellingValue, 0) }}</p></div>
            <div><p class="text-xs font-medium text-blue-100">Avg Margin</p><p class="mt-1 text-xl font-extrabold">Rs. {{ number_format($averageMargin, 0) }}</p></div>
        </div>
    </section>

    <section class="mt-5">
        <h2 class="mb-3 font-bold text-slate-950">Quick Actions</h2>
        <div class="grid grid-cols-4 gap-3">
            @foreach ([
                ['Add Purchase', 'purchases.create', 'cart', 'bg-blue-50 text-blue-700'],
                ['Products', 'products.index', 'package', 'bg-green-50 text-green-700'],
                ['Vendors', 'vendors.index', 'users', 'bg-violet-50 text-violet-700'],
                ['Reports', 'reports.index', 'line-chart', 'bg-orange-50 text-orange-700'],
            ] as [$label, $route, $icon, $tone])
                <a href="{{ route($route) }}" class="text-center">
                    <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl {{ $tone }} shadow-sm">
                        <svg class="h-6.5 w-6.5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons[$icon] !!}</svg>
                    </span>
                    <p class="mt-2 text-[11px] font-semibold text-slate-950">{{ $label }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <section class="app-panel mt-5 overflow-hidden">
        <div class="app-panel-header">
            <h2 class="font-bold text-slate-950">Best Vendor Price Today</h2>
            <a href="{{ route('vendor-prices.index') }}" class="text-xs font-bold text-blue-700">View All</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($vendorRows as $row)
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center gap-3">
                        <span class="product-avatar">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons['package'] !!}</svg>
                        </span>
                        <div>
                            <p class="font-semibold text-slate-950">{{ $row['product'] }}</p>
                            <p class="text-xs font-medium text-slate-500">{{ $row['vendor'] }}</p>
                        </div>
                    </div>
                    <p class="font-bold text-green-700">Rs. {{ number_format($row['best'], 2) }}</p>
                </div>
            @empty
                <p class="p-5 text-sm font-medium text-slate-500">No vendor prices yet.</p>
            @endforelse
        </div>
    </section>

    <section class="app-panel mt-5 overflow-hidden">
        <div class="app-panel-header">
            <h2 class="font-bold text-slate-950">Top High Margin Products</h2>
            <a href="{{ route('reports.index') }}" class="text-xs font-bold text-blue-700">View All</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($topProducts->take(3) as $product)
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center gap-3">
                        <span class="product-avatar">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons['package'] !!}</svg>
                        </span>
                        <p class="font-semibold text-slate-950">{{ $product->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-700">Rs. {{ number_format($product->margin, 0) }}</p>
                        <p class="text-xs font-medium text-slate-500">Rs. {{ number_format($product->expected_profit, 0) }}</p>
                    </div>
                </div>
            @empty
                <p class="p-5 text-sm font-medium text-slate-500">No product profit data yet.</p>
            @endforelse
        </div>
    </section>
@endsection
