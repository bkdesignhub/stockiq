@extends('layouts.app')

@section('title', 'Edit Brand - StockIQ')

@section('content')
    <div class="mb-6">
        <p class="page-kicker">Master Data</p>
        <h1 class="page-title">Edit Brand</h1>
    </div>
    <form method="POST" action="{{ route('brands.update', $brand) }}" class="app-panel p-5">
        @method('PUT')
        @include('brands._form')
    </form>
@endsection
