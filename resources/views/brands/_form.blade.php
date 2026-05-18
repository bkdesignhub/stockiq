@csrf
<div class="grid gap-4">
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Brand name</span>
        <input name="name" value="{{ old('name', $brand->name) }}" class="mt-1 w-full" required>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Description</span>
        <textarea name="description" rows="3" class="mt-1 w-full">{{ old('description', $brand->description) }}</textarea>
    </label>
</div>
<div class="mt-5 flex gap-3">
    <button class="btn-primary">Save brand</button>
    <a href="{{ route('brands.index') }}" class="btn-secondary">Cancel</a>
</div>
