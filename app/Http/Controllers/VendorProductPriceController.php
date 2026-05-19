<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class VendorProductPriceController extends Controller
{
    public function index(Request $request)
    {
        $selectedProductId = $request->integer('product_id') ?: null;
        $products = Product::orderBy('name')->get();
        $selectedProduct = $selectedProductId
            ? Product::find($selectedProductId)
            : null;

        $comparisonRows = collect();

        if ($selectedProduct) {
            $comparisonRows = PurchaseItem::with(['purchase.vendor'])
                ->where('product_id', $selectedProduct->id)
                ->whereHas('purchase.vendor')
                ->get()
                ->groupBy(fn (PurchaseItem $item) => $item->purchase->vendor_id)
                ->map(function ($items) use ($selectedProduct) {
                    $latest = $items
                        ->sortByDesc(fn (PurchaseItem $item) => $item->purchase->purchase_date?->timestamp ?? 0)
                        ->first();
                    $lowest = $items->sortBy('unit_cost')->first();
                    $highest = $items->sortByDesc('unit_cost')->first();
                    $latestPrice = (float) $latest->unit_cost;
                    $sellingPrice = (float) $selectedProduct->selling_price;

                    return [
                        'vendor' => $latest->purchase->vendor,
                        'latest_price' => $latestPrice,
                        'lowest_price' => (float) $lowest->unit_cost,
                        'highest_price' => (float) $highest->unit_cost,
                        'average_price' => (float) $items->avg('unit_cost'),
                        'selling_price' => $sellingPrice,
                        'margin' => $sellingPrice - $latestPrice,
                        'margin_percent' => $latestPrice > 0 ? (($sellingPrice - $latestPrice) / $latestPrice) * 100 : 0,
                        'quantity' => (int) $items->sum('quantity'),
                        'purchase_count' => $items->count(),
                        'last_purchase_date' => $latest->purchase->purchase_date,
                    ];
                })
                ->sortBy('latest_price')
                ->values();
        }

        $bestRow = $comparisonRows->first();
        $highestRow = $comparisonRows->sortByDesc('latest_price')->first();

        return view('vendor-prices.index', [
            'comparisonRows' => $comparisonRows,
            'products' => $products,
            'selectedProduct' => $selectedProduct,
            'selectedProductId' => $selectedProductId,
            'bestRow' => $bestRow,
            'spread' => ($bestRow && $highestRow) ? max(0, $highestRow['latest_price'] - $bestRow['latest_price']) : 0,
        ]);
    }
}
