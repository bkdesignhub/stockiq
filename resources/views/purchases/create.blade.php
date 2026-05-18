@extends('layouts.app')

@section('title', 'Add Purchase - StockIQ')

@section('content')
    <section class="mb-5 text-center">
        <p class="page-kicker">Purchase Entry</p>
        <h1 class="page-title">Add Purchase</h1>
        <p class="page-subtitle mx-auto">Record purchase cost and quantity to update stock value automatically.</p>
    </section>

    <form method="POST" action="{{ route('purchases.store') }}" class="space-y-4">
        @csrf

        <section class="app-panel p-5">
            <div class="grid gap-4">
                <label class="block">
                    <span class="text-sm font-black text-[#071333]">Product</span>
                    <select name="items[0][product_id]" class="mt-2 w-full" required>
                        <option value="">Select product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(old('items.0.product_id') == $product->id)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-black text-[#071333]">Vendor</span>
                    <select name="vendor_id" class="mt-2 w-full" required>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" @selected(old('vendor_id') == $vendor->id)>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-black text-[#071333]">Cost Price (Rs.)</span>
                    <input type="number" step="0.01" min="0" name="items[0][unit_cost]" value="{{ old('items.0.unit_cost') }}" class="mt-2 w-full" required>
                </label>

                <label class="block">
                    <span class="text-sm font-black text-[#071333]">Quantity</span>
                    <div class="mt-2 flex">
                        <input type="number" min="1" name="items[0][quantity]" value="{{ old('items.0.quantity') }}" class="w-full rounded-r-none" required>
                        <span class="grid min-w-16 place-items-center rounded-r-xl border border-l-0 border-[#e4e9f5] bg-slate-50 px-4 text-sm font-black text-slate-500">qty</span>
                    </div>
                </label>

                <label class="block">
                    <span class="text-sm font-black text-[#071333]">Purchase Date</span>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date', now()->format('Y-m-d')) }}" class="mt-2 w-full" required>
                </label>
            </div>
        </section>

        <section class="rounded-2xl border border-green-200 bg-green-50 p-5">
            <p class="text-sm font-black text-green-900">New Stock Summary</p>
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div>
                    <p class="stat-label text-green-700">Tax</p>
                    <input type="number" step="0.01" min="0" name="tax" value="{{ old('tax', 0) }}" class="mt-2 w-full border-green-200">
                </div>
                <div>
                    <p class="stat-label text-green-700">Freight</p>
                    <input type="number" step="0.01" min="0" name="freight" value="{{ old('freight', 0) }}" class="mt-2 w-full border-green-200">
                </div>
            </div>
        </section>

        <section class="app-panel p-5">
            <label class="block">
                <span class="text-sm font-black text-[#071333]">Invoice No</span>
                <input name="invoice_no" value="{{ old('invoice_no') }}" class="mt-2 w-full">
            </label>
            <label class="mt-4 block">
                <span class="text-sm font-black text-[#071333]">Notes</span>
                <textarea name="notes" rows="3" class="mt-2 w-full">{{ old('notes') }}</textarea>
            </label>
        </section>

        <button class="btn-primary w-full">Save Purchase</button>
    </form>
@endsection
