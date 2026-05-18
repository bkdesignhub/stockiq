@extends('layouts.app')

@section('title', 'Add Product - StockIQ')

@section('content')
    <div class="mb-6"><p class="page-kicker">Products</p><h1 class="page-title">Add product</h1><p class="page-subtitle">Create the SKU record used by purchases, stock valuation, and profit reporting.</p></div>
    <form method="POST" action="{{ route('products.store') }}" class="app-panel p-5">@include('products._form')</form>
@endsection
