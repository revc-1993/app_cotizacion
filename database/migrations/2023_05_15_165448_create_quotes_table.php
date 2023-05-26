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
            $table->string('name');
            $table->string('type_of_transport');
            $table->string('product');
            $table->string('cargo_type');

            // Si cargo_type es "suelta"
            $table->float('weight')->nullable();
            $table->string('unit_of_weight_measurement')->nullable();
            $table->float('length')->nullable();
            $table->string('unit_of_length_measurement')->nullable();
            // Si cargo_type es "contenedor"
            $table->string('containerized_cargo_type')->nullable();
            $table->integer('number_of_containers');
            $table->string('single_cargo_name');

            $table->timestamp('registration_date');
            $table->softDeletes();
            $table->timestamps();
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
