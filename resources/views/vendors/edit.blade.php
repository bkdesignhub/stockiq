@extends('layouts.app')

@section('title', 'Edit Vendor - StockIQ')

@section('content')
    <div class="mb-6"><p class="page-kicker">Vendors</p><h1 class="page-title">Edit vendor</h1><p class="page-subtitle">Update contact and procurement details for {{ $vendor->name }}.</p></div>
    <form method="POST" action="{{ route('vendors.update', $vendor) }}" class="app-panel p-5">
        @method('PUT')
        @include('vendors._form')
    </form>
@endsection
