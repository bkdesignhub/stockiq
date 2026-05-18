@extends('layouts.app')

@section('title', 'Purchase Details - StockIQ')

@section('content')
    <div class="mb-5 flex items-start justify-between gap-3">
        <div><p class="page-kicker">Purchase</p><h1 class="page-title">{{ $purchase->vendor->name }}</h1><p class="page-subtitle">{{ $purchase->purchase_date->format('d M Y') }} {{ $purchase->invoice_no ? '/ '.$purchase->invoice_no : '' }}</p></div>
        <div class="flex gap-2">
            <a href="{{ route('purchases.index') }}" class="btn-secondary">Back</a>
            <a href="{{ route('purchases.edit', $purchase) }}" class="btn-secondary">Edit</a>
            <form method="POST" action="{{ route('purchases.destroy', $purchase) }}" onsubmit="return confirm('Delete this purchase and remove its stock movement?');">
                @csrf
                @method('DELETE')
                <button class="btn-danger">Delete</button>
            </form>
        </div>
    </div>
    <section class="app-panel">
        <div class="divide-y divide-slate-100">
            @foreach ($purchase->items as $item)
                <div class="flex items-center justify-between gap-3 p-4">
                    <div><p class="font-black text-slate-950">{{ $item->product->name }}</p><p class="text-sm font-semibold text-slate-500">{{ $item->quantity }} x Rs. {{ number_format($item->unit_cost, 2) }}</p></div>
                    <p class="font-black text-slate-950">Rs. {{ number_format($item->line_total, 2) }}</p>
                </div>
            @endforeach
        </div>
        <div class="border-t border-slate-200 bg-slate-50 p-4">
            <div class="flex justify-between text-sm font-semibold text-slate-600"><span>Subtotal</span><span>Rs. {{ number_format($purchase->subtotal, 2) }}</span></div>
            <div class="flex justify-between text-sm font-semibold text-slate-600"><span>Tax</span><span>Rs. {{ number_format($purchase->tax, 2) }}</span></div>
            <div class="flex justify-between text-sm font-semibold text-slate-600"><span>Freight</span><span>Rs. {{ number_format($purchase->freight, 2) }}</span></div>
            <div class="mt-3 flex justify-between text-lg font-black text-slate-950"><span>Total</span><span>Rs. {{ number_format($purchase->total, 2) }}</span></div>
        </div>
    </section>
@endsection
