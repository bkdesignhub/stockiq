@extends('layouts.app')
@section('title', 'Edit Vendor Price - StockIQ')
@section('content')
    <div class="mb-6"><p class="page-kicker">Vendor prices</p><h1 class="page-title">Edit price</h1><p class="page-subtitle">Keep purchase intelligence current as vendors change rates.</p></div>
    <form method="POST" action="{{ route('vendor-prices.update', $vendorPrice) }}" class="app-panel p-5">
        @method('PUT')
        @include('vendor-prices._form')
    </form>
@endsection
