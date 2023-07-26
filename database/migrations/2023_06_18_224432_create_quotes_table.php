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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('type_of_transport');
            $table->string('cargo_type');
            // Si cargo_type es "contenedor"
            $table->string('containerized_cargo_type')->nullable();
            $table->string('incoterm');

            $table->timestamp('registration_date');

            $table->float('subtotal_12')->nullable();
            $table->float('subtotal_0')->nullable();
            $table->float('iva')->nullable();
            $table->float('total')->nullable();

            $table->string('international_freight_information')->nullable();
            $table->string('additional_information')->nullable();
            $table->integer('transit_time')->nullable();
            $table->integer('quote_validity')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->unsignedBigInteger('customer_id')->nullable();

            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
};
