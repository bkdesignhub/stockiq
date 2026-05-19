<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;

class ReportController extends Controller
{
    public function index()
    {
        $products = Product::with(['purchaseItems', 'stockMovements'])->get();

        return view('reports.index', [
            'stockWorth' => $products->sum(fn (Product $product) => $product->stock_worth),
            'expectedProfit' => $products->sum(fn (Product $product) => $product->expected_profit),
            'averageMargin' => $products->count() ? $products->avg(fn (Product $product) => $product->margin) : 0,
            'products' => $products->sortByDesc('expected_profit'),
            'purchasesByVendor' => Purchase::query()
                ->selectRaw('vendor_id, sum(total) as total_spend, count(*) as purchase_count')
                ->with('vendor')
                ->groupBy('vendor_id')
                ->orderByDesc('total_spend')
                ->get(),
        ]);
    }

    public function monthlyProfit()
    {
        $products = Product::with(['purchaseItems', 'stockMovements'])->get();
        $purchases = Purchase::with('vendor')->latest('purchase_date')->take(8)->get();

        return view('reports.monthly-profit', [
            'stockWorth' => $products->sum(fn (Product $product) => $product->stock_worth),
            'expectedProfit' => $products->sum(fn (Product $product) => $product->expected_profit),
            'averageMargin' => $products->count() ? $products->avg(fn (Product $product) => $product->margin) : 0,
            'totalPurchase' => Purchase::whereMonth('purchase_date', now()->month)->whereYear('purchase_date', now()->year)->sum('total'),
            'products' => $products->sortByDesc('expected_profit')->values(),
            'purchases' => $purchases,
        ]);
    }

    public function stockWorth()
    {
        $products = Product::with(['productCategory', 'purchaseItems', 'stockMovements'])->get();
        $categoryBreakdown = $products
            ->groupBy(fn (Product $product) => $product->productCategory?->name ?: 'Uncategorized')
            ->map(fn ($items, $name) => [
                'name' => $name,
                'count' => $items->count(),
                'quantity' => $items->sum(fn (Product $product) => $product->current_stock),
                'worth' => $items->sum(fn (Product $product) => $product->stock_worth),
            ])
            ->sortByDesc('worth')
            ->values();

        return view('reports.stock-worth', [
            'products' => $products->sortByDesc('stock_worth')->values(),
            'categoryBreakdown' => $categoryBreakdown,
            'stockWorth' => $products->sum(fn (Product $product) => $product->stock_worth),
            'totalQuantity' => $products->sum(fn (Product $product) => $product->current_stock),
        ]);
    }
}
