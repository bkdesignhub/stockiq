@extends('layouts.app')

@section('title', 'Add Vendor - StockIQ')

@section('content')
    <div class="mb-6"><p class="page-kicker">Vendors</p><h1 class="page-title">Add vendor</h1><p class="page-subtitle">Create a supplier profile for purchases and price comparison.</p></div>
    <form method="POST" action="{{ route('vendors.store') }}" class="app-panel p-5">@include('vendors._form')</form>
@endsection
