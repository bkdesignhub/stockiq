@extends('layouts.app')

@section('title', 'Vendors - StockIQ')

@section('content')
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Vendors</p>
            <h1 class="page-title">Vendor network</h1>
            <p class="page-subtitle">Manage suppliers, buying relationships, and vendor price intelligence.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('vendor-prices.index') }}" class="btn-secondary">Price List</a>
            <a href="{{ route('vendors.create') }}" class="btn-primary">Add Vendor</a>
        </div>
    </div>

    <form method="GET" action="{{ route('vendors.index') }}" class="mb-5 flex items-center gap-2 rounded-2xl border border-blue-100 bg-white px-4 py-3 shadow-sm">
        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-4.3-4.3 M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" stroke-linecap="round"/></svg>
        <input name="search" value="{{ $search }}" placeholder="Search vendor, contact, phone, or email..." class="min-h-0 flex-1 border-0 bg-transparent p-0 shadow-none focus:border-transparent focus:ring-0">
        @if ($search)
            <a href="{{ route('vendors.index') }}" class="desktop-action">Clear</a>
        @endif
    </form>

    <div class="grid gap-4 lg:hidden">
        @forelse ($vendors as $vendor)
            <article class="app-panel p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-black text-[#071333]">{{ $vendor->name }}</h2>
                        <p class="mt-1 text-sm font-bold text-slate-500">{{ $vendor->contact_person ?: 'No contact person' }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('vendors.edit', $vendor) }}" class="btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('vendors.destroy', $vendor) }}" onsubmit="return confirm('Delete this vendor?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-3">
                    <div class="stat-tile"><p class="stat-label">Prices</p><p class="stat-value">{{ $vendor->prices_count }}</p></div>
                    <div class="stat-tile"><p class="stat-label">Purchases</p><p class="stat-value">{{ $vendor->purchases_count }}</p></div>
                </div>
                <p class="mt-4 text-sm font-bold text-slate-500">{{ $vendor->phone ?: 'No phone' }} {{ $vendor->email ? '/ '.$vendor->email : '' }}</p>
            </article>
        @empty
            <div class="app-panel p-8 text-center">
                <p class="text-lg font-black text-[#071333]">No vendors yet</p>
                <p class="mt-2 text-sm font-bold text-slate-500">Add vendors to compare purchase prices.</p>
                <a href="{{ route('vendors.create') }}" class="btn-primary mt-5">Add first vendor</a>
            </div>
        @endforelse
    </div>

    <div class="app-panel hidden overflow-hidden lg:block">
        <table class="desktop-table">
            <thead>
                <tr>
                    <th>Vendor</th>
                    <th>Contact</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Price Records</th>
                    <th>Purchases</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vendors as $vendor)
                    <tr>
                        <td class="font-black text-[#071333]">{{ $vendor->name }}</td>
                        <td>{{ $vendor->contact_person ?: '-' }}</td>
                        <td>{{ $vendor->phone ?: '-' }}</td>
                        <td>{{ $vendor->email ?: '-' }}</td>
                        <td>{{ $vendor->prices_count }}</td>
                        <td>{{ $vendor->purchases_count }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('vendors.edit', $vendor) }}" class="desktop-action">Edit</a>
                                <form method="POST" action="{{ route('vendors.destroy', $vendor) }}" onsubmit="return confirm('Delete this vendor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="desktop-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">No vendors yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $vendors->links() }}</div>
@endsection
