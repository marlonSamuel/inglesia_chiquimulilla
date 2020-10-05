<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParrocosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parrocos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero',15);
            $table->string('primer_nombre',25);
            $table->string('segundo_nombre',25)->nullable();
            $table->string('primer_apellido',25);
            $table->string('segundo_apellido',25)->nullable();
            $table->string('direccion',250)->nullable();
            $table->unsignedBigInteger('municipio_id');
            $table->timestamps();

            $table->foreign('municipio_id')->references('id')->on('municipios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parrocos');
    }
}
