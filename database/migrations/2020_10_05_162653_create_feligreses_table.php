<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeligresesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feligreses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero',15);
            $table->string('primer_nombre',25);
            $table->string('segundo_nombre',25)->nullable();
            $table->string('primer_apellido',25);
            $table->string('segundo_apellido',25)->nullable();
            $table->string('direccion',255)->nullable();
            $table->unsignedBigInteger('municipio_id');
            $table->unsignedBigInteger('parroquia_id');
            $table->timestamps();

            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('parroquia_id')->references('id')->on('parroquias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feligrese');
    }
}
