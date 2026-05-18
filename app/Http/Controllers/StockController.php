<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        return view('stocks.index', [
            'products' => Product::with(['purchaseItems', 'stockMovements'])->orderBy('name')->paginate(12),
            'allProducts' => Product::orderBy('name')->get(),
            'movements' => StockMovement::with('product')->latest('movement_date')->take(12)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:adjustment,sale,return'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_cost' => ['nullable', 'numeric', 'min:0'],
            'movement_date' => ['required', 'date'],
            'reference' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $data['quantity'] = $data['type'] === 'sale' ? -abs($data['quantity']) : abs($data['quantity']);
        StockMovement::create($data);

        return redirect()->route('stocks.index')->with('status', 'Stock movement recorded.');
    }
}
