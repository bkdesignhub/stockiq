<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorProductPriceController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::post('login', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');
    Route::get('admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('brands', BrandController::class)->except(['show']);
    Route::resource('vendors', VendorController::class)->except(['show']);
    Route::resource('vendor-prices', VendorProductPriceController::class)
        ->only(['index']);
    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::post('stocks', [StockController::class, 'store'])->name('stocks.store');
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/monthly-profit', [ReportController::class, 'monthlyProfit'])->name('reports.monthly-profit');
    Route::get('reports/stock-worth', [ReportController::class, 'stockWorth'])->name('reports.stock-worth');
    Route::view('settings', 'settings.index')->name('settings.index');
});
