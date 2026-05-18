@extends('layouts.app')

@section('title', 'Vendor Prices - StockIQ')

@section('content')
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Vendor Prices</p>
            <h1 class="page-title">Price comparison</h1>
            <p class="page-subtitle">Choose the best vendor by purchase price, lead time, and product economics.</p>
        </div>
        <a href="{{ route('vendor-prices.create') }}" class="btn-primary">Add Price</a>
    </div>

    <section class="mb-5 grid gap-4 lg:grid-cols-4">
        @forelse ($bestPrices as $row)
            <div class="rounded-2xl border border-green-200 bg-green-50 p-5 shadow-sm">
                <p class="text-sm font-black text-green-900">{{ $row['product']->name }}</p>
                <p class="mt-2 text-2xl font-black text-[#071333]">Rs. {{ number_format($row['best']->price, 2) }}</p>
                <p class="mt-1 text-sm font-bold text-green-800">{{ $row['best']->vendor->name }} / {{ $row['best']->lead_time_days }} days</p>
            </div>
        @empty
            <div class="app-panel p-5 text-sm font-bold text-slate-500 lg:col-span-4">Add vendor prices to start comparing procurement options.</div>
        @endforelse
    </section>

    <div class="grid gap-4 lg:hidden">
        @forelse ($prices as $price)
            <article class="app-panel p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-black text-[#071333]">{{ $price->product->name }}</h2>
                        <p class="mt-1 text-sm font-bold text-slate-500">{{ $price->vendor->name }}</p>
                    </div>
                    <a href="{{ route('vendor-prices.edit', $price) }}" class="btn-secondary">Edit</a>
                </div>
                <div class="mt-5 grid grid-cols-3 gap-3">
                    <div class="stat-tile"><p class="stat-label">Price</p><p class="stat-value">Rs. {{ number_format($price->price, 2) }}</p></div>
                    <div class="stat-tile"><p class="stat-label">Lead</p><p class="stat-value">{{ $price->lead_time_days }}d</p></div>
                    <div class="stat-tile"><p class="stat-label">From</p><p class="stat-value">{{ optional($price->effective_from)->format('d M') ?: '-' }}</p></div>
                </div>
            </article>
        @empty
            <div class="app-panel p-8 text-center">
                <p class="text-lg font-black text-[#071333]">No vendor prices yet</p>
                <p class="mt-2 text-sm font-bold text-slate-500">Add price records to compare suppliers.</p>
                <a href="{{ route('vendor-prices.create') }}" class="btn-primary mt-5">Add first price</a>
            </div>
        @endforelse
    </div>

    <div class="app-panel hidden overflow-hidden lg:block">
        <table class="desktop-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Vendor</th>
                    <th>Price</th>
                    <th>Lead Time</th>
                    <th>Effective From</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prices as $price)
                    <tr>
                        <td class="font-black text-[#071333]">{{ $price->product->name }}</td>
                        <td>{{ $price->vendor->name }}</td>
                        <td class="font-black text-green-700">Rs. {{ number_format($price->price, 2) }}</td>
                        <td>{{ $price->lead_time_days }} days</td>
                        <td>{{ optional($price->effective_from)->format('d M Y') ?: '-' }}</td>
                        <td><a href="{{ route('vendor-prices.edit', $price) }}" class="desktop-action">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6">No vendor prices yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $prices->links() }}</div>
@endsection
