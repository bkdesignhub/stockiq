<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Vendor;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $products = Product::with(['productCategory', 'brand', 'purchaseItems', 'stockMovements'])->get();
        $stockWorth = $products->sum(fn (Product $product) => $product->stock_worth);
        $expectedProfit = $products->sum(fn (Product $product) => $product->expected_profit);
        $expectedSellingValue = $stockWorth + $expectedProfit;
        $averageMargin = $products->count()
            ? $products->avg(fn (Product $product) => $product->margin)
            : 0;
        $topProducts = $products->sortByDesc('expected_profit')->take(5);
        $lowMarginProducts = $products
            ->filter(fn (Product $product) => $product->current_stock > 0 || $product->average_cost > 0)
            ->sortBy('margin')
            ->take(5);

        $vendorRows = PurchaseItem::with(['product', 'purchase.vendor'])
            ->whereHas('purchase.vendor')
            ->get()
            ->groupBy('product_id')
            ->map(function ($items) {
                $product = $items->first()->product;
                $vendorRows = $items
                    ->groupBy(fn (PurchaseItem $item) => $item->purchase->vendor_id)
                    ->map(function ($vendorItems) {
                        $latest = $vendorItems
                            ->sortByDesc(fn (PurchaseItem $item) => $item->purchase->purchase_date?->timestamp ?? 0)
                            ->first();

                        return [
                            'vendor' => $latest->purchase->vendor,
                            'latest_price' => (float) $latest->unit_cost,
                        ];
                    })
                    ->values();

                $best = $vendorRows->sortBy('latest_price')->first();

                if (! $product || ! $best) {
                    return null;
                }

                $averagePrice = $vendorRows->avg('latest_price') ?: 0;

                return [
                    'product' => $product->name,
                    'vendor' => $best['vendor']->name,
                    'best' => (float) $best['latest_price'],
                    'avg' => (float) $averagePrice,
                    'diff' => max(0, (float) $averagePrice - (float) $best['latest_price']),
                    'margin' => max(0, (float) $product->selling_price - (float) $best['latest_price']),
                ];
            })
            ->filter()
            ->values();

        $categoryBreakdown = $products
            ->groupBy(fn (Product $product) => $product->productCategory?->name ?: 'Uncategorized')
            ->map(fn ($items, $name) => [
                'name' => $name,
                'count' => $items->count(),
                'worth' => $items->sum(fn (Product $product) => $product->stock_worth),
            ])
            ->values();

        $chartDates = collect(range(6, 0))->map(fn ($daysAgo) => now()->subDays($daysAgo));
        $chartLabels = $chartDates->map(fn ($date) => $date->format('d M'))->values();
        $purchaseTrend = $chartDates->map(fn ($date) => (float) Purchase::whereDate('purchase_date', $date->toDateString())->sum('total'))->values();
        $profitTrend = $purchaseTrend->map(fn ($value) => round($value * 0.35, 2));

        return view('dashboard.index', [
            'productCount' => $products->count(),
            'vendorCount' => Vendor::count(),
            'purchaseCount' => Purchase::count(),
            'stockWorth' => $stockWorth,
            'expectedSellingValue' => $expectedSellingValue,
            'expectedProfit' => $expectedProfit,
            'averageMargin' => $averageMargin,
            'recentPurchases' => Purchase::with('vendor')->withCount('items')->latest('purchase_date')->take(5)->get(),
            'topProducts' => $topProducts,
            'lowMarginProducts' => $lowMarginProducts,
            'vendorRows' => $vendorRows,
            'categoryBreakdown' => $categoryBreakdown,
            'dashboardChart' => [
                'labels' => $chartLabels,
                'profit' => $profitTrend,
                'margin' => $purchaseTrend->map(fn ($value) => $value > 0 ? 35 : 0),
                'categories' => $categoryBreakdown->pluck('count'),
                'categoryLabels' => $categoryBreakdown->pluck('name'),
            ],
        ]);
    }
}
