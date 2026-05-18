@extends('layouts.app')
@section('title', 'Add Vendor Price - StockIQ')
@section('content')
    <div class="mb-6"><p class="page-kicker">Vendor prices</p><h1 class="page-title">Add price</h1><p class="page-subtitle">Record a vendor purchase price and lead time for comparison.</p></div>
    <form method="POST" action="{{ route('vendor-prices.store') }}" class="app-panel p-5">@include('vendor-prices._form')</form>
@endsection
