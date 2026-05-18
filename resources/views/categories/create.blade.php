@extends('layouts.app')

@section('title', 'Add Category - StockIQ')

@section('content')
    <div class="mb-6">
        <p class="page-kicker">Master Data</p>
        <h1 class="page-title">Add Category</h1>
        <p class="page-subtitle">Categories are required when creating products.</p>
    </div>
    <form method="POST" action="{{ route('categories.store') }}" class="app-panel p-5">@include('categories._form')</form>
@endsection
