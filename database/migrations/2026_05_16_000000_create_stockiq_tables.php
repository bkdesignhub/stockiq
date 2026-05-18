<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('unit')->default('pcs');
            $table->decimal('selling_price', 12, 2)->default(0);
            $table->unsignedInteger('reorder_level')->default(0);
            $table->timestamps();
        });

        Schema::create('vendor_product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('lead_time_days')->default(0);
            $table->date('effective_from')->nullable();
            $table->timestamps();
            $table->unique(['vendor_id', 'product_id']);
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_no')->nullable();
            $table->date('purchase_date');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('freight', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_cost', 12, 2);
            $table->decimal('line_total', 12, 2);
            $table->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('purchase_item_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['purchase', 'adjustment', 'sale', 'return'])->default('purchase');
            $table->integer('quantity');
            $table->decimal('unit_cost', 12, 2)->default(0);
            $table->date('movement_date');
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('vendor_product_prices');
        Schema::dropIfExists('products');
        Schema::dropIfExists('vendors');
    }
};
