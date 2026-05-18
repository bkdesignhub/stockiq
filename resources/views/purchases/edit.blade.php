@extends('layouts.app')

@section('title', 'Edit Purchase - StockIQ')

@section('content')
    @php
        $storedItems = $purchase->items
            ->map(fn ($item) => [
                'product_id' => $item->product_id,
                'unit_cost' => $item->unit_cost,
                'quantity' => $item->quantity,
            ])
            ->values()
            ->all();
        $rows = old('items', [...$storedItems, ['product_id' => null, 'unit_cost' => null, 'quantity' => null]]);
    @endphp

    <section class="mb-5 flex items-start justify-between gap-3">
        <div>
            <p class="page-kicker">Purchase Entry</p>
            <h1 class="page-title">Edit Purchase</h1>
            <p class="page-subtitle">Update purchase cost, quantity, vendor, and invoice details.</p>
        </div>
        <a href="{{ route('purchases.show', $purchase) }}" class="btn-secondary">Back</a>
    </section>

    <form method="POST" action="{{ route('purchases.update', $purchase) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <section class="app-panel p-5">
            <div class="grid gap-4">
                <label class="block">
                    <span class="text-sm font-black text-[#071333]">Vendor</span>
                    <select name="vendor_id" class="mt-2 w-full" required>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" @selected(old('vendor_id', $purchase->vendor_id) == $vendor->id)>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-black text-[#071333]">Purchase Date</span>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}" class="mt-2 w-full" required>
                </label>
            </div>
        </section>

        <section class="app-panel p-5">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-black text-[#071333]">Items</p>
                    <p class="mt-1 text-xs font-bold text-slate-500">Fill the empty row to add one more item.</p>
                </div>
            </div>

            <div class="space-y-4">
                @foreach ($rows as $index => $row)
                    <div class="rounded-2xl border border-[#edf1f8] bg-[#f8faff] p-4">
                        <div class="grid gap-4 lg:grid-cols-3">
                            <label class="block">
                                <span class="text-sm font-black text-[#071333]">Product</span>
                                <select name="items[{{ $index }}][product_id]" class="mt-2 w-full" @required($index === 0)>
                                    <option value="">Select product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" @selected(($row['product_id'] ?? null) == $product->id)>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="block">
                                <span class="text-sm font-black text-[#071333]">Cost Price (Rs.)</span>
                                <input type="number" step="0.01" min="0" name="items[{{ $index }}][unit_cost]" value="{{ $row['unit_cost'] ?? null }}" class="mt-2 w-full" @required($index === 0)>
                            </label>

                            <label class="block">
                                <span class="text-sm font-black text-[#071333]">Quantity</span>
                                <div class="mt-2 flex">
                                    <input type="number" min="1" name="items[{{ $index }}][quantity]" value="{{ $row['quantity'] ?? null }}" class="w-full rounded-r-none" @required($index === 0)>
                                    <span class="grid min-w-16 place-items-center rounded-r-xl border border-l-0 border-[#e4e9f5] bg-slate-50 px-4 text-sm font-black text-slate-500">qty</span>
                                </div>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl border border-green-200 bg-green-50 p-5">
            <p class="text-sm font-black text-green-900">Stock Summary</p>
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div>
                    <p class="stat-label text-green-700">Tax</p>
                    <input type="number" step="0.01" min="0" name="tax" value="{{ old('tax', $purchase->tax) }}" class="mt-2 w-full border-green-200">
                </div>
                <div>
                    <p class="stat-label text-green-700">Freight</p>
                    <input type="number" step="0.01" min="0" name="freight" value="{{ old('freight', $purchase->freight) }}" class="mt-2 w-full border-green-200">
                </div>
            </div>
        </section>

        <section class="app-panel p-5">
            <label class="block">
                <span class="text-sm font-black text-[#071333]">Invoice No</span>
                <input name="invoice_no" value="{{ old('invoice_no', $purchase->invoice_no) }}" class="mt-2 w-full">
            </label>
            <label class="mt-4 block">
                <span class="text-sm font-black text-[#071333]">Notes</span>
                <textarea name="notes" rows="3" class="mt-2 w-full">{{ old('notes', $purchase->notes) }}</textarea>
            </label>
        </section>

        <button class="btn-primary w-full">Update Purchase</button>
    </form>
@endsection
