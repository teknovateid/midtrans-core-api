<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();

            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null')->command('');
            $table->json('customer_snapshot')->nullable();

            $table->decimal('gross_amount', 15, 2)->comment('price before tax and discount');
            $table->decimal('total_discount_amount', 15, 2)->default(0)->comment('total discount amount applied');
            $table->decimal('total_additional_costs', 15, 2)->default(0)->comment('total additional costs (e.g., shipping, handling, etc.)');

            $table->decimal('net_amount', 15, 2)->comment('price after tax and discount (what customer pay)');

            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamp('balance_added_at')->nullable();

            $table->text('payment_response')->nullable()->comment('Raw response from payment gateway');

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });



        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');

            $table->json('product_snapshot')->comment('Snapshot product data');

            $table->decimal('unit_price', 12, 2)->comment('Unit price of the product at the time of transaction');
            $table->integer('quantity')->default(1);

            $table->decimal('subtotal', 15, 2)->comment('Total price per item (unit_price * quantity)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
        Schema::dropIfExists('transactions');
    }
};
