<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();
        $vendors = Vendor::withCount(['prices', 'purchases'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('vendors.index', [
            'vendors' => $vendors,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('vendors.create', ['vendor' => new Vendor()]);
    }

    public function store(Request $request)
    {
        Vendor::create($this->validated($request));

        return redirect()->route('vendors.index')->with('status', 'Vendor created.');
    }

    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $vendor->update($this->validated($request));

        return redirect()->route('vendors.index')->with('status', 'Vendor updated.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendors.index')->with('status', 'Vendor deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'contact_person' => ['nullable', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'email', 'max:180'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);
    }
}
