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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();

            $table->string('cargo_name');
            $table->float('amount_of_charge')->nullable();
            // Peso - Weight
            $table->string('unit_of_weight_measurement')->nullable();
            $table->float('weight')->nullable();
            // Medidas - Measures
            $table->string('unit_of_length_measurement')->nullable();
            // Largo - Length
            $table->float('length')->nullable();
            // Ancho - Width
            $table->float('width')->nullable();
            // Alto - High
            $table->float('high')->nullable();

            $table->float('volumen')->nullable();
            $table->float('weight_calculated')->nullable();

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
        Schema::dropIfExists('product_details');
    }
};
