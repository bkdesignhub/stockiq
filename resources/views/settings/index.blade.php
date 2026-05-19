@extends('layouts.app')

@section('title', 'More / Settings - StockIQ')

@section('content')
    <section class="mb-6">
        <p class="page-kicker">More</p>
        <h1 class="page-title">Settings</h1>
        <p class="page-subtitle">Manage product masters, vendor pricing, reports, and stock-focused workflows.</p>
    </section>

    <section class="grid gap-5 lg:grid-cols-3">
        <article class="app-panel overflow-hidden">
            <div class="app-panel-header"><h2 class="font-bold text-slate-950">Manage</h2></div>
            <div class="divide-y divide-slate-100">
                @foreach ([['Products', 'products.index'], ['Vendors', 'vendors.index'], ['Categories', 'categories.index'], ['Brands', 'brands.index']] as [$label, $route])
                    <a href="{{ route($route) }}" class="block p-4 font-semibold text-slate-700 hover:bg-slate-50">{{ $label }}</a>
                @endforeach
            </div>
        </article>

        <article class="app-panel overflow-hidden">
            <div class="app-panel-header"><h2 class="font-bold text-slate-950">Reports</h2></div>
            <div class="divide-y divide-slate-100">
                @foreach ([['Stock Analysis', 'stocks.index'], ['Vendor Comparison', 'vendor-prices.index'], ['Monthly Profit Report', 'reports.monthly-profit'], ['Stock Worth Summary', 'reports.stock-worth']] as [$label, $route])
                    <a href="{{ route($route) }}" class="block p-4 font-semibold text-slate-700 hover:bg-slate-50">{{ $label }}</a>
                @endforeach
            </div>
        </article>

        <article class="app-panel overflow-hidden">
            <div class="app-panel-header"><h2 class="font-bold text-slate-950">Settings</h2></div>
            <div class="divide-y divide-slate-100">
                <a href="{{ route('admin.profile.edit') }}" class="block p-4 font-semibold text-slate-700 hover:bg-slate-50">Admin Profile & Password</a>
                <a href="{{ route('purchases.index') }}" class="block p-4 font-semibold text-slate-700 hover:bg-slate-50">Purchase History</a>
                <a href="{{ route('vendor-prices.index') }}" class="block p-4 font-semibold text-slate-700 hover:bg-slate-50">Vendor Price Comparison</a>
                <a href="{{ route('purchases.create') }}" class="block p-4 font-semibold text-slate-700 hover:bg-slate-50">Purchase Entry</a>
            </div>
        </article>
    </section>
@endsection
