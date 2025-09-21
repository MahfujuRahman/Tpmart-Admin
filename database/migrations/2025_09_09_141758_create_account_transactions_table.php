<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transactions', function (Blueprint $table) {
                $table->id();
                $table->string('voucher_no', 30);
                $table->integer('voucher_int_no');
                $table->tinyInteger('auto_voucher')->default(0);
                $table->double('amount', 11, 2);
                $table->string('comments', 200)->nullable();
                $table->date('trans_date');
                $table->tinyInteger('trans_type')->comment('1=Payment Transaction, 2=Receive Transaction, 3=Journal Voucher');
                // $table->integer('domain_id');
                $table->tinyInteger('status')->default(1)->comment('1=Active, 0=Inactive');
                $table->timestamps();
                $table->integer('created_by')->nullable();
                $table->integer('updated_by')->nullable();
                $table->softDeletes();
                $table->integer('deleted_by')->nullable();
                $table->tinyInteger('valid')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_transactions');
    }
}
