<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();
        $purchases = Purchase::with(['vendor', 'items.product'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('invoice_no', 'like', "%{$search}%")
                        ->orWhere('notes', 'like', "%{$search}%")
                        ->orWhereHas('vendor', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('items.product', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('sku', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('purchase_date')
            ->paginate(10)
            ->withQueryString();

        return view('purchases.index', [
            'purchases' => $purchases,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('purchases.create', [
            'purchase' => new Purchase(['purchase_date' => now()]),
            'vendors' => Vendor::orderBy('name')->get(),
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($data) {
            $purchase = Purchase::create($this->purchasePayload($data));
            $this->syncItems($purchase, $data['items'], $data['purchase_date']);
        });

        return redirect()->route('purchases.index')->with('status', 'Purchase posted and stock updated.');
    }

    public function edit(Purchase $purchase)
    {
        return view('purchases.edit', [
            'purchase' => $purchase->load('items'),
            'vendors' => Vendor::orderBy('name')->get(),
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Purchase $purchase)
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($purchase, $data) {
            $purchase->load('items.stockMovement');

            foreach ($purchase->items as $item) {
                $item->stockMovement?->delete();
            }

            $purchase->items()->delete();
            $purchase->update($this->purchasePayload($data));
            $this->syncItems($purchase, $data['items'], $data['purchase_date']);
        });

        return redirect()->route('purchases.show', $purchase)->with('status', 'Purchase updated and stock adjusted.');
    }

    public function show(Purchase $purchase)
    {
        return view('purchases.show', ['purchase' => $purchase->load(['vendor', 'items.product'])]);
    }

    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            $purchase->load('items.stockMovement');

            foreach ($purchase->items as $item) {
                $item->stockMovement?->delete();
            }

            $purchase->items()->delete();
            $purchase->delete();
        });

        return redirect()->route('purchases.index')->with('status', 'Purchase deleted and stock updated.');
    }

    private function validated(Request $request): array
    {
        $request->merge([
            'items' => collect($request->input('items', []))
                ->filter(fn ($item) => filled($item['product_id'] ?? null) || filled($item['quantity'] ?? null) || filled($item['unit_cost'] ?? null))
                ->values()
                ->all(),
        ]);

        return $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'invoice_no' => ['nullable', 'string', 'max:120'],
            'purchase_date' => ['required', 'date'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'freight' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:800'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_cost' => ['required', 'numeric', 'min:0'],
        ]);
    }

    private function purchasePayload(array $data): array
    {
        $subtotal = collect($data['items'])->sum(fn ($item) => $item['quantity'] * $item['unit_cost']);
        $tax = $data['tax'] ?? 0;
        $freight = $data['freight'] ?? 0;

        return [
                'vendor_id' => $data['vendor_id'],
                'invoice_no' => $data['invoice_no'] ?? null,
                'purchase_date' => $data['purchase_date'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'freight' => $freight,
                'total' => $subtotal + $tax + $freight,
                'notes' => $data['notes'] ?? null,
        ];
    }

    private function syncItems(Purchase $purchase, array $items, string $purchaseDate): void
    {
        foreach ($items as $row) {
            $item = $purchase->items()->create([
                'product_id' => $row['product_id'],
                'quantity' => $row['quantity'],
                'unit_cost' => $row['unit_cost'],
                'line_total' => $row['quantity'] * $row['unit_cost'],
            ]);

            $item->stockMovement()->create([
                'product_id' => $row['product_id'],
                'type' => 'purchase',
                'quantity' => $row['quantity'],
                'unit_cost' => $row['unit_cost'],
                'movement_date' => $purchaseDate,
                'reference' => $purchase->invoice_no ?: 'PUR-' . $purchase->id,
                'notes' => 'Purchase stock-in',
            ]);
        }
    }
}
