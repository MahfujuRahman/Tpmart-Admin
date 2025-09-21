<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSubsidiaryLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_subsidiary_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('ledger_code')->unique();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('account_type_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            // Foreign keys
            $table->foreign('group_id')
                  ->references('id')
                  ->on('account_groups')
                  ->onDelete('cascade');

            $table->foreign('account_type_id')
                  ->references('id')
                  ->on('account_types')
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
        Schema::dropIfExists('account_subsidiary_ledgers');
    }
}
