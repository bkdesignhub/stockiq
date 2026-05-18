@csrf
<div class="grid gap-4 sm:grid-cols-2">
    <label class="block sm:col-span-2">
        <span class="text-sm font-bold text-[#071333]">Vendor name</span>
        <input name="name" value="{{ old('name', $vendor->name) }}" class="mt-1 w-full" required>
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Contact person</span>
        <input name="contact_person" value="{{ old('contact_person', $vendor->contact_person) }}" class="mt-1 w-full">
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Phone</span>
        <input name="phone" value="{{ old('phone', $vendor->phone) }}" class="mt-1 w-full">
    </label>
    <label class="block">
        <span class="text-sm font-bold text-[#071333]">Email</span>
        <input type="email" name="email" value="{{ old('email', $vendor->email) }}" class="mt-1 w-full">
    </label>
    <label class="block sm:col-span-2">
        <span class="text-sm font-bold text-[#071333]">Address</span>
        <textarea name="address" rows="3" class="mt-1 w-full">{{ old('address', $vendor->address) }}</textarea>
    </label>
</div>
<div class="mt-5 flex gap-3">
    <button class="btn-primary">Save vendor</button>
    <a href="{{ route('vendors.index') }}" class="btn-secondary">Cancel</a>
</div>
