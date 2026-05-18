@extends('layouts.app')

@section('title', $product->name.' - StockIQ')

@section('content')
    <section class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Product Detail</p>
            <h1 class="page-title">{{ $product->name }}</h1>
            <p class="page-subtitle">{{ $product->productCategory?->name ?: 'Uncategorized' }}{{ $product->brand?->name ? ' / '.$product->brand->name : '' }} / SKU {{ $product->sku }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('products.edit', $product) }}" class="btn-secondary">Edit Price</a>
            <a href="{{ route('purchases.create') }}" class="btn-primary">Add Purchase</a>
        </div>
    </section>

    <section class="grid gap-4 lg:grid-cols-4">
        <div class="metric-card"><p class="metric-label">Total Stock</p><p class="metric-value">{{ $product->current_stock }} {{ $product->unit }}</p></div>
        <div class="metric-card"><p class="metric-label">Avg Cost Price</p><p class="metric-value">Rs. {{ number_format($product->average_cost, 2) }}</p></div>
        <div class="metric-card"><p class="metric-label">Stock Value</p><p class="metric-value">Rs. {{ number_format($product->stock_worth, 0) }}</p></div>
        <div class="metric-card"><p class="metric-label">Margin</p><p class="metric-value text-green-700">{{ $product->average_cost > 0 ? number_format(($product->margin / max($product->average_cost, 1)) * 100, 2) : 0 }}%</p></div>
    </section>

    <section class="mt-5 grid gap-5 lg:grid-cols-[0.9fr_1.1fr]">
        <article class="app-panel overflow-hidden">
            <div class="app-panel-header">
                <h2 class="font-bold text-slate-950">Compare Vendors</h2>
                <a href="{{ route('vendor-prices.index') }}" class="text-sm font-bold text-blue-700">View All</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($product->vendorPrices->sortBy('price') as $price)
                    <div class="flex items-center justify-between p-4">
                        <div>
                            <p class="font-semibold text-slate-950">{{ $price->vendor->name }}</p>
                            <p class="text-xs font-medium text-slate-500">{{ $price->lead_time_days }} day lead time</p>
                        </div>
                        <p class="font-bold {{ $loop->first ? 'text-green-700' : 'text-slate-950' }}">Rs. {{ number_format($price->price, 2) }}</p>
                    </div>
                @empty
                    <p class="p-5 text-sm font-medium text-slate-500">No vendor prices recorded for this product.</p>
                @endforelse
            </div>
        </article>

        <article class="app-panel overflow-hidden">
            <div class="app-panel-header">
                <h2 class="font-bold text-slate-950">Purchase History</h2>
            </div>
            <table class="desktop-table">
                <thead><tr><th>Date</th><th>Qty</th><th>Unit Cost</th><th>Total</th></tr></thead>
                <tbody>
                    @forelse ($product->purchaseItems->sortByDesc('purchase.purchase_date') as $item)
                        <tr>
                            <td>{{ $item->purchase?->purchase_date?->format('d M Y') ?: '-' }}</td>
                            <td>{{ $item->quantity }} {{ $product->unit }}</td>
                            <td>Rs. {{ number_format($item->unit_cost, 2) }}</td>
                            <td class="font-bold text-slate-950">Rs. {{ number_format($item->line_total, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No purchases yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="divide-y divide-slate-100 lg:hidden">
                @forelse ($product->purchaseItems->sortByDesc('purchase.purchase_date') as $item)
                    <div class="flex items-center justify-between p-4">
                        <div>
                            <p class="font-semibold text-slate-950">{{ $item->purchase?->purchase_date?->format('d M Y') ?: '-' }}</p>
                            <p class="text-xs font-medium text-slate-500">{{ $item->quantity }} x Rs. {{ number_format($item->unit_cost, 2) }}</p>
                        </div>
                        <p class="font-bold text-slate-950">Rs. {{ number_format($item->line_total, 2) }}</p>
                    </div>
                @empty
                    <p class="p-5 text-sm font-medium text-slate-500">No purchases yet.</p>
                @endforelse
            </div>
        </article>
    </section>
@endsection
