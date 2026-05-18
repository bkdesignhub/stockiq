@extends('layouts.app')

@section('title', 'Purchases - StockIQ')

@section('content')
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Purchases</p>
            <h1 class="page-title">Purchase stock-in</h1>
            <p class="page-subtitle">Post purchase entries to automatically update stock, cost basis, and inventory value.</p>
        </div>
        <a href="{{ route('purchases.create') }}" class="btn-primary">Post Purchase</a>
    </div>

    <form method="GET" action="{{ route('purchases.index') }}" class="mb-5 flex items-center gap-2 rounded-2xl border border-blue-100 bg-white px-4 py-3 shadow-sm">
        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-4.3-4.3 M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" stroke-linecap="round"/></svg>
        <input name="search" value="{{ $search }}" placeholder="Search vendor, invoice, product, or SKU..." class="min-h-0 flex-1 border-0 bg-transparent p-0 shadow-none focus:border-transparent focus:ring-0">
        @if ($search)
            <a href="{{ route('purchases.index') }}" class="desktop-action">Clear</a>
        @endif
    </form>

    <div class="grid gap-4 lg:hidden">
        @forelse ($purchases as $purchase)
            <article class="app-panel p-5">
                <a href="{{ route('purchases.show', $purchase) }}" class="block">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-black text-[#071333]">{{ $purchase->vendor->name }}</h2>
                        <p class="mt-1 text-sm font-bold text-slate-500">{{ $purchase->purchase_date->format('d M Y') }} {{ $purchase->invoice_no ? '/ '.$purchase->invoice_no : '' }}</p>
                    </div>
                    <p class="text-right text-lg font-black text-blue-700">Rs. {{ number_format($purchase->total, 2) }}</p>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-500">{{ $purchase->items->count() }} items</span>
                    <span class="green-pill">Subtotal Rs. {{ number_format($purchase->subtotal, 2) }}</span>
                </div>
                </a>
                <div class="mt-4 grid grid-cols-3 gap-3">
                    <a href="{{ route('purchases.show', $purchase) }}" class="btn-secondary">Open</a>
                    <a href="{{ route('purchases.edit', $purchase) }}" class="btn-secondary">Edit</a>
                    <form method="POST" action="{{ route('purchases.destroy', $purchase) }}" onsubmit="return confirm('Delete this purchase and remove its stock movement?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn-danger w-full">Delete</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="app-panel p-8 text-center">
                <p class="text-lg font-black text-[#071333]">No purchases yet</p>
                <p class="mt-2 text-sm font-bold text-slate-500">Post a purchase to add stock.</p>
                <a href="{{ route('purchases.create') }}" class="btn-primary mt-5">Post first purchase</a>
            </div>
        @endforelse
    </div>

    <div class="app-panel hidden overflow-hidden lg:block">
        <table class="desktop-table">
            <thead>
                <tr>
                    <th>Vendor</th>
                    <th>Invoice</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Subtotal</th>
                    <th>Tax</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchases as $purchase)
                    <tr>
                        <td class="font-black text-[#071333]">{{ $purchase->vendor->name }}</td>
                        <td>{{ $purchase->invoice_no ?: '-' }}</td>
                        <td>{{ $purchase->purchase_date->format('d M Y') }}</td>
                        <td>{{ $purchase->items->count() }}</td>
                        <td>Rs. {{ number_format($purchase->subtotal, 2) }}</td>
                        <td>Rs. {{ number_format($purchase->tax, 2) }}</td>
                        <td class="font-black text-blue-700">Rs. {{ number_format($purchase->total, 2) }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('purchases.show', $purchase) }}" class="desktop-action">Open</a>
                                <a href="{{ route('purchases.edit', $purchase) }}" class="desktop-action">Edit</a>
                                <form method="POST" action="{{ route('purchases.destroy', $purchase) }}" onsubmit="return confirm('Delete this purchase and remove its stock movement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="desktop-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8">No purchases yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $purchases->links() }}</div>
@endsection
