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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string("company_name")->nullable();
            $table->string("ruc")->nullable();
            $table->string("address")->nullable();
            $table->string("contact_number")->nullable();
            $table->string("mail_mailer")->default("smtp");
            $table->string("mail_host")->nullable();
            $table->integer("mail_port")->default(587);
            $table->string("email");
            $table->string("mail_password")->nullable();
            $table->string("regime_category")->nullable();
            $table->string("mail_encryption")->default("tls");
            $table->string("mail_from_address")->nullable();
            $table->string("mail_from_name")->nullable();
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('configurations');
    }
};
