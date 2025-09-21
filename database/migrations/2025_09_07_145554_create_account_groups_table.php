<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->unsignedBigInteger('account_type_id');
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(1); // 1 = active, 0 = inactive
            $table->timestamps();
            $table->softDeletes();
            // foreign key
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
        Schema::dropIfExists('account_groups');
    }
}
