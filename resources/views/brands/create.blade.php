@extends('layouts.app')

@section('title', 'Add Brand - StockIQ')

@section('content')
    <div class="mb-6">
        <p class="page-kicker">Master Data</p>
        <h1 class="page-title">Add Brand</h1>
        <p class="page-subtitle">Brands are optional when creating products.</p>
    </div>
    <form method="POST" action="{{ route('brands.store') }}" class="app-panel p-5">@include('brands._form')</form>
@endsection
