<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();

            $table->string('type_of_service')->nullable();
            $table->integer('amount_of_service')->nullable();
            $table->integer('code_service')->nullable();
            $table->string('service')->nullable();
            $table->float('pvp_provider')->nullable();
            $table->float('utility')->nullable();
            $table->float('utility_usd')->nullable();
            $table->float('subtotal')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->unsignedBigInteger('quote_id')->nullable();
            $table->foreign('quote_id')->references('id')->on('quotes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_details');
    }
};
