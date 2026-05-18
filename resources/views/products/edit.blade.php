@extends('layouts.app')

@section('title', 'Edit Product - StockIQ')

@section('content')
    <div class="mb-6"><p class="page-kicker">Products</p><h1 class="page-title">Edit product</h1><p class="page-subtitle">Update pricing and reorder assumptions for {{ $product->name }}.</p></div>
    <form method="POST" action="{{ route('products.update', $product) }}" class="app-panel p-5">
        @method('PUT')
        @include('products._form')
    </form>
@endsection
