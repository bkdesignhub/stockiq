@extends('layouts.app')

@section('title', 'Monthly Profit Report - StockIQ')

@section('content')
    <section class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Reports</p>
            <h1 class="page-title">Monthly Profit Report</h1>
            <p class="page-subtitle">Track purchase spend, current stock value, expected profit, and average margin for {{ now()->format('F Y') }}.</p>
        </div>
        <a href="{{ route('reports.index') }}" class="btn-secondary">Reports Dashboard</a>
    </section>

    <section class="grid grid-cols-2 gap-3 lg:grid-cols-4">
        <div class="metric-card"><p class="metric-label">Total Purchase</p><p class="metric-value">Rs. {{ number_format($totalPurchase, 0) }}</p></div>
        <div class="metric-card"><p class="metric-label">Stock Value</p><p class="metric-value">Rs. {{ number_format($stockWorth, 0) }}</p></div>
        <div class="metric-card bg-green-50"><p class="metric-label text-green-700">Expected Profit</p><p class="metric-value text-green-700">Rs. {{ number_format($expectedProfit, 0) }}</p></div>
        <div class="metric-card"><p class="metric-label">Avg Margin</p><p class="metric-value">{{ number_format($averageMargin, 0) }}%</p></div>
    </section>

    <section class="mt-5 grid gap-5 lg:grid-cols-[1.2fr_0.8fr]">
        <article class="app-panel p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-bold text-slate-950">Monthly Trend</h2>
                <div class="flex gap-3 text-xs font-semibold"><span class="text-blue-700">Purchase</span><span class="text-green-700">Profit</span></div>
            </div>
            <div class="flex h-52 items-end gap-3">
                @foreach ([42, 70, 58, 74, 62, 88] as $bar)
                    <div class="flex flex-1 items-end gap-1">
                        <span class="flex-1 rounded-t-xl bg-blue-600" style="height: {{ $bar }}%"></span>
                        <span class="flex-1 rounded-t-xl bg-green-500" style="height: {{ max($bar - 24, 18) }}%"></span>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="app-panel overflow-hidden">
            <div class="app-panel-header"><h2 class="font-bold text-slate-950">Top Profitable Items</h2></div>
            <div class="divide-y divide-slate-100">
                @forelse ($products->take(5) as $product)
                    <div class="flex items-center justify-between p-4">
                        <div><p class="font-semibold text-slate-950">{{ $product->name }}</p><p class="text-xs font-medium text-slate-500">Margin Rs. {{ number_format($product->margin, 0) }}</p></div>
                        <p class="font-bold text-green-700">Rs. {{ number_format($product->expected_profit, 0) }}</p>
                    </div>
                @empty
                    <p class="p-5 text-sm font-medium text-slate-500">No profitable items yet.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
