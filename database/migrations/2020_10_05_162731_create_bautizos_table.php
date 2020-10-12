<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBautizosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bautizos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('folio');
            $table->integer('partida');
            $table->date('fecha');
            $table->unsignedBigInteger('feligres_id');
            $table->unsignedBigInteger('libro_id');
            $table->unsignedBigInteger('padre_id');
            $table->unsignedBigInteger('madre_id');
            $table->unsignedBigInteger('padrino1_id');
            $table->unsignedBigInteger('padrino2_id');
            $table->unsignedBigInteger('parroco_parroquia_id');
            $table->timestamps();

            $table->foreign('libro_id')->references('id')->on('libros');
            $table->foreign('feligres_id')->references('id')->on('feligreses');
            $table->foreign('padre_id')->references('id')->on('feligreses');
            $table->foreign('madre_id')->references('id')->on('feligreses');
            $table->foreign('padrino1_id')->references('id')->on('feligreses');
            $table->foreign('padrino2_id')->references('id')->on('feligreses');
            $table->foreign('parroco_parroquia_id')->references('id')->on('parroco_parroquias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bautizos');
    }
}
