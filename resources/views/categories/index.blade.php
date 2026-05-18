@extends('layouts.app')

@section('title', 'Categories - StockIQ')

@section('content')
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="page-kicker">Master Data</p>
            <h1 class="page-title">Categories</h1>
            <p class="page-subtitle">Create product categories used by stock analysis and reporting.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn-primary">Add Category</a>
    </div>

    <form method="GET" action="{{ route('categories.index') }}" class="mb-5 flex items-center gap-2 rounded-2xl border border-blue-100 bg-white px-4 py-3 shadow-sm">
        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-4.3-4.3 M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" stroke-linecap="round"/></svg>
        <input name="search" value="{{ $search }}" placeholder="Search category or description..." class="min-h-0 flex-1 border-0 bg-transparent p-0 shadow-none focus:border-transparent focus:ring-0">
        @if ($search)
            <a href="{{ route('categories.index') }}" class="desktop-action">Clear</a>
        @endif
    </form>

    <div class="app-panel hidden overflow-hidden lg:block">
        <table class="desktop-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="font-black text-[#071333]">{{ $category->name }}</td>
                        <td>{{ $category->description ?: '-' }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('categories.edit', $category) }}" class="desktop-action">Edit</a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="desktop-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="grid gap-4 lg:hidden">
        @forelse ($categories as $category)
            <article class="app-panel p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-black text-[#071333]">{{ $category->name }}</h2>
                        <p class="mt-1 text-sm font-bold text-slate-500">{{ $category->description ?: 'No description' }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('categories.edit', $category) }}" class="btn-secondary">Edit</a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
                <div class="stat-tile mt-4">
                    <p class="stat-label">Products</p>
                    <p class="stat-value">{{ $category->products_count }}</p>
                </div>
            </article>
        @empty
            <div class="app-panel p-8 text-center">
                <p class="text-lg font-black text-[#071333]">No categories yet</p>
                <a href="{{ route('categories.create') }}" class="btn-primary mt-5">Add first category</a>
            </div>
        @endforelse
    </div>

    <div class="mt-5">{{ $categories->links() }}</div>
@endsection
