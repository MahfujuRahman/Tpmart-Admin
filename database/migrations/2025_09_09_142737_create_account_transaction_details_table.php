<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transaction_details', function (Blueprint $table) {
            $table->id();
            // foreign key relation
            $table->unsignedBigInteger('acc_transaction_id');
            $table->integer('dr_adjust_trans_id')->default(0);
            $table->string('dr_adjust_voucher_no', 30)->nullable();
            $table->date('dr_adjust_voucher_date')->nullable();
            $table->integer('cr_adjust_trans_id')->default(0);
            $table->string('cr_adjust_voucher_no', 30)->nullable();
            $table->date('cr_adjust_voucher_date')->nullable();
            $table->integer('dr_gl_ledger');
            $table->integer('dr_sub_ledger');
            $table->integer('cr_gl_ledger');
            $table->integer('cr_sub_ledger');
            $table->integer('ref_sub_ledger')->default(0);
            $table->double('amount', 11, 2);

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
            $table->tinyInteger('valid')->nullable()->default(null);

            // foreign key relation
            $table->foreign('acc_transaction_id')
                ->references('id')
                ->on('account_transactions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_transaction_details');
    }
}
