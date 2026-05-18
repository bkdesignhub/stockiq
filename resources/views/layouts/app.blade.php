<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'StockIQ')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased">
    @php
        $icons = [
            'home' => '<path d="m3 9 9-7 9 7"/><path d="M9 22V12h6v10"/><path d="M5 10v12h14V10"/>',
            'package' => '<path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>',
            'folders' => '<path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/><path d="M3 11h18"/>',
            'badge' => '<path d="M7 7h10v10H7z"/><path d="M4 4h16v16H4z"/>',
            'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
            'cart' => '<circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L21.8 7H5.12"/>',
            'bar-chart' => '<path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>',
            'line-chart' => '<path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/>',
            'bell' => '<path d="M10.27 21a2 2 0 0 0 3.46 0"/><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>',
            'settings' => '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.38a2 2 0 0 0-.73-2.73l-.15-.09a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2Z"/><circle cx="12" cy="12" r="3"/>',
            'plus' => '<path d="M5 12h14"/><path d="M12 5v14"/>',
            'search' => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>',
            'user' => '<path d="M19 21a7 7 0 0 0-14 0"/><circle cx="12" cy="7" r="4"/>',
            'calendar' => '<path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/>',
            'menu' => '<path d="M4 12h16"/><path d="M4 6h16"/><path d="M4 18h16"/>',
            'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        ];
        $sideNav = [
            ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
            ['route' => 'products.index', 'label' => 'Products', 'icon' => 'package'],
            ['route' => 'categories.index', 'label' => 'Categories', 'icon' => 'folders'],
            ['route' => 'brands.index', 'label' => 'Brands', 'icon' => 'badge'],
            ['route' => 'vendors.index', 'label' => 'Vendors', 'icon' => 'users'],
            ['route' => 'purchases.index', 'label' => 'Purchases', 'icon' => 'cart'],
            ['route' => 'stocks.index', 'label' => 'Stock Analysis', 'icon' => 'bar-chart'],
            ['route' => 'vendor-prices.index', 'label' => 'Vendor Comparison', 'icon' => 'line-chart'],
            ['route' => 'reports.index', 'label' => 'Reports', 'icon' => 'line-chart'],
            ['route' => 'settings.index', 'label' => 'Settings', 'icon' => 'settings'],
        ];
        $bottomNav = [
            ['route' => 'dashboard', 'label' => 'Home', 'icon' => 'home'],
            ['route' => 'products.index', 'label' => 'Products', 'icon' => 'package'],
            ['route' => 'purchases.create', 'label' => 'Purchase', 'icon' => 'plus'],
            ['route' => 'stocks.index', 'label' => 'Stocks', 'icon' => 'bar-chart'],
            ['route' => 'settings.index', 'label' => 'More', 'icon' => 'menu'],
        ];
    @endphp

    <div class="hidden min-h-screen bg-slate-50 lg:grid lg:grid-cols-[260px_1fr]">
        <aside class="border-r border-slate-200 bg-white">
            <div class="flex h-20 items-center gap-3 border-b border-slate-200 px-6">
                <span class="grid h-10 w-10 place-items-center rounded-2xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">{!! $icons['bar-chart'] !!}</svg>
                </span>
                <p class="text-2xl font-extrabold tracking-tight text-slate-950">Stock<span class="text-emerald-500">IQ</span></p>
            </div>

            <nav class="space-y-1.5 p-4">
                @foreach ($sideNav as $item)
                    @php $active = request()->routeIs($item['route']) || ($item['route'] === 'vendors.index' && request()->routeIs('vendor-prices.*')); @endphp
                    <a href="{{ route($item['route']) }}" class="group flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition {{ $active ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons[$item['icon']] !!}</svg>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="px-4 pt-5">
                <p class="px-2 text-[11px] font-bold uppercase tracking-wide text-slate-500">Quick Actions</p>
                <div class="mt-3 space-y-2">
                    @foreach ([
                        ['Add Purchase', 'purchases.create', 'cart', 'bg-blue-50 text-blue-700'],
                        ['Add Product', 'products.create', 'package', 'bg-emerald-50 text-emerald-700'],
                        ['Add Vendor', 'vendors.create', 'users', 'bg-violet-50 text-violet-700'],
                        ['View Reports', 'reports.index', 'line-chart', 'bg-amber-50 text-amber-700'],
                    ] as [$label, $route, $icon, $tone])
                        <a href="{{ route($route) }}" class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-semibold {{ $tone }}">
                            <span class="grid h-8 w-8 place-items-center rounded-lg bg-white/70">
                                <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $icons[$icon] !!}</svg>
                            </span>
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <div class="min-w-0">
            <header class="sticky top-0 z-20 border-b border-slate-200 bg-white">
                <div class="flex h-20 items-center gap-5 px-6">
                    <button class="grid h-10 w-10 place-items-center rounded-xl text-slate-700 hover:bg-slate-100">
                        <svg class="h-5.5 w-5.5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons['menu'] !!}</svg>
                    </button>
                    <form action="{{ route('products.index') }}" method="GET" class="flex h-11 flex-1 max-w-xl items-center gap-3 rounded-xl border border-slate-200 bg-white px-4 shadow-sm">
                        <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons['search'] !!}</svg>
                        <input name="search" class="min-h-0 flex-1 border-0 bg-transparent p-0 text-sm font-medium text-slate-700 shadow-none placeholder:text-slate-400 focus:border-transparent focus:ring-0" placeholder="Search products, vendors..." />
                        <span class="rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-500">Ctrl /</span>
                    </form>
                    <a href="{{ route('purchases.create') }}" class="btn-primary">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">{!! $icons['plus'] !!}</svg>
                        Add Purchase
                    </a>
                    <button class="relative grid h-11 w-11 place-items-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm">
                        <span class="absolute -right-1 -top-1 grid h-5 w-5 place-items-center rounded-full bg-red-500 text-[10px] font-bold text-white">3</span>
                        <svg class="h-5.5 w-5.5" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons['bell'] !!}</svg>
                    </button>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 rounded-xl px-2 py-1.5 hover:bg-slate-50">
                            <span class="grid h-11 w-11 place-items-center rounded-full bg-orange-100 text-sm font-bold text-orange-700">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons['user'] !!}</svg>
                            </span>
                            <span class="block text-sm font-bold text-slate-950">{{ auth()->user()->name }}</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 shadow-sm hover:bg-slate-50">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="px-6 py-6">
                @yield('content')
            </main>
        </div>
    </div>

    <div class="min-h-screen bg-slate-50 pb-24 lg:hidden">
        <main class="mx-auto max-w-[430px] px-4 py-5">
            @yield('mobile')
            @hasSection('mobile')
            @else
                @yield('content')
            @endif
        </main>
        <nav class="fixed inset-x-0 bottom-0 z-30 border-t border-slate-200 bg-white/95 shadow-sm backdrop-blur">
            <div class="mx-auto grid max-w-[430px] grid-cols-5">
                @foreach ($bottomNav as $item)
                    @php $active = request()->routeIs($item['route']) || ($item['route'] === 'vendors.index' && request()->routeIs('vendor-prices.*')); @endphp
                    <a href="{{ route($item['route']) }}" class="relative flex flex-col items-center gap-1 px-1 py-2.5 text-[10px] font-semibold {{ $active ? 'text-blue-700' : 'text-slate-600' }}">
                        <span class="{{ $item['route'] === 'purchases.create' ? 'absolute -top-5 grid h-12 w-12 place-items-center rounded-full bg-blue-600 text-white shadow-md' : '' }}">
                            <svg class="{{ $item['route'] === 'purchases.create' ? 'h-6 w-6' : 'h-5 w-5' }}" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">{!! $icons[$item['icon']] !!}</svg>
                        </span>
                        <span class="{{ $item['route'] === 'purchases.create' ? 'mt-7' : '' }}">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </nav>
    </div>
</body>
</html>
