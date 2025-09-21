<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsidiaryCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsidiary_calculations', function (Blueprint $table) {
            $table->id();
            $table->integer('particular')->comment('0=Beginning Balance');
            $table->integer('particular_control_group'); // foreign key relation
            $table->integer('particular_sub_ledger_group_id'); // foreign key relation
            $table->date('trans_date');
            $table->integer('sub_ledger'); // foreign key relation
            $table->integer('gl_ledger'); // foreign key relation
            $table->string('nature_id', 11);
            $table->double('debit_amount', 11, 2);
            $table->double('credit_amount', 11, 2);
            $table->tinyInteger('transaction_type')
                  ->comment('1=acc_opening, 2=acc_transaction, 3=inventory_closing_stock');

            // Relation columns
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('tran_details_id'); // foreign key relation

            $table->integer('adjust_trans_id')->default(0)->nullable();
            $table->date('adjust_vouchar_date')->nullable();
            // $table->integer('domain_id'); // foreign key relation
            // $table->integer('project_id'); // foreign key relation  

            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
            $table->tinyInteger('valid')->nullable()->default(null);

            // Foreign Keys
            $table->foreign('transaction_id')
                  ->references('id')->on('account_transactions')
                  ->onDelete('cascade');

            $table->foreign('tran_details_id')
                  ->references('id')->on('account_transaction_details')
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
        Schema::dropIfExists('subsidiary_calculations');
    }
}
