@csrf
<div class="grid gap-4 sm:grid-cols-2">
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Vendor</span>
        <select name="vendor_id" class="mt-1 w-full" required>
            @foreach ($vendors as $vendor)
                <option value="{{ $vendor->id }}" @selected(old('vendor_id', $vendorPrice->vendor_id) == $vendor->id)>{{ $vendor->name }}</option>
            @endforeach
        </select>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Product</span>
        <select name="product_id" class="mt-1 w-full" required>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected(old('product_id', $vendorPrice->product_id) == $product->id)>{{ $product->name }}</option>
            @endforeach
        </select>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Purchase price</span>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $vendorPrice->price ?: 0) }}" class="mt-1 w-full" required>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Lead time days</span>
        <input type="number" min="0" name="lead_time_days" value="{{ old('lead_time_days', $vendorPrice->lead_time_days ?: 0) }}" class="mt-1 w-full" required>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Effective from</span>
        <input type="date" name="effective_from" value="{{ old('effective_from', optional($vendorPrice->effective_from)->format('Y-m-d')) }}" class="mt-1 w-full">
    </label>
</div>
<div class="mt-5 flex gap-3">
    <button class="btn-primary">Save price</button>
    <a href="{{ route('vendor-prices.index') }}" class="btn-secondary">Cancel</a>
</div>
