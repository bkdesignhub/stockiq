<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorProductPrice;
use Illuminate\Http\Request;

class VendorProductPriceController extends Controller
{
    public function index()
    {
        return view('vendor-prices.index', [
            'prices' => VendorProductPrice::with(['vendor', 'product'])->orderBy('price')->paginate(14),
            'bestPrices' => Product::with('vendorPrices.vendor')->get()->map(function (Product $product) {
                return ['product' => $product, 'best' => $product->vendorPrices->sortBy('price')->first()];
            })->filter(fn ($row) => $row['best']),
        ]);
    }

    public function create()
    {
        return view('vendor-prices.create', $this->formData(new VendorProductPrice()));
    }

    public function store(Request $request)
    {
        VendorProductPrice::updateOrCreate(
            $request->only(['vendor_id', 'product_id']),
            $this->validated($request)
        );

        return redirect()->route('vendor-prices.index')->with('status', 'Vendor price saved.');
    }

    public function edit(VendorProductPrice $vendorPrice)
    {
        return view('vendor-prices.edit', $this->formData($vendorPrice));
    }

    public function update(Request $request, VendorProductPrice $vendorPrice)
    {
        $vendorPrice->update($this->validated($request));

        return redirect()->route('vendor-prices.index')->with('status', 'Vendor price updated.');
    }

    public function destroy(VendorProductPrice $vendorPrice)
    {
        $vendorPrice->delete();

        return redirect()->route('vendor-prices.index')->with('status', 'Vendor price deleted.');
    }

    private function formData(VendorProductPrice $vendorPrice): array
    {
        return [
            'vendorPrice' => $vendorPrice,
            'vendors' => Vendor::orderBy('name')->get(),
            'products' => Product::orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'product_id' => ['required', 'exists:products,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'lead_time_days' => ['required', 'integer', 'min:0'],
            'effective_from' => ['nullable', 'date'],
        ]);
    }
}
