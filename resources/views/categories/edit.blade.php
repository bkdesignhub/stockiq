@extends('layouts.app')

@section('title', 'Edit Category - StockIQ')

@section('content')
    <div class="mb-6">
        <p class="page-kicker">Master Data</p>
        <h1 class="page-title">Edit Category</h1>
    </div>
    <form method="POST" action="{{ route('categories.update', $category) }}" class="app-panel p-5">
        @method('PUT')
        @include('categories._form')
    </form>
@endsection
