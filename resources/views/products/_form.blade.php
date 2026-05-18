@csrf
<div class="grid gap-4 sm:grid-cols-2">
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">SKU</span>
        <input name="sku" value="{{ old('sku', $product->sku) }}" class="mt-1 w-full" required>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Name</span>
        <input name="name" value="{{ old('name', $product->name) }}" class="mt-1 w-full" required>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Category</span>
        <select name="category_id" class="mt-1 w-full" required>
            <option value="">Select category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Brand (optional)</span>
        <select name="brand_id" class="mt-1 w-full">
            <option value="">No brand</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
            @endforeach
        </select>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Unit</span>
        <input name="unit" value="{{ old('unit', $product->unit ?: 'pcs') }}" class="mt-1 w-full" required>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Selling price</span>
        <input type="number" step="0.01" min="0" name="selling_price" value="{{ old('selling_price', $product->selling_price ?: 0) }}" class="mt-1 w-full" required>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Reorder level</span>
        <input type="number" min="0" name="reorder_level" value="{{ old('reorder_level', $product->reorder_level ?: 0) }}" class="mt-1 w-full" required>
    </label>
</div>
<div class="mt-5 flex gap-3">
    <button class="btn-primary">Save product</button>
    <a href="{{ route('products.index') }}" class="btn-secondary">Cancel</a>
</div>
