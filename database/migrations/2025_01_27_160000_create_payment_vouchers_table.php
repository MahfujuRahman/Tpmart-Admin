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
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no')->unique();
            $table->date('payment_date');
            $table->decimal('total_amount', 15, 2);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('general_ledger_id')->nullable();
            $table->string('payment_by')->nullable();
            $table->string('subsidiary_ledger_id')->nullable();
            $table->decimal('paid_amount', 15, 2)->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index(['payment_date', 'status']);
            $table->index('voucher_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_vouchers');
    }
};
