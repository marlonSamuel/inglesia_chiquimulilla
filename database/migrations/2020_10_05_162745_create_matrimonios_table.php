<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatrimoniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matrimonios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('folio');
            $table->integer('partida');
            $table->date('fecha');
            $table->string('testigos');
            $table->unsignedBigInteger('libro_id');
            $table->unsignedBigInteger('novio_id');
            $table->unsignedBigInteger('novia_id');
            $table->unsignedBigInteger('padre_novio_id');
            $table->unsignedBigInteger('madre_novio_id');
            $table->unsignedBigInteger('padre_novia_id');
            $table->unsignedBigInteger('madre_novia_id');
            $table->unsignedBigInteger('parroco_parroquia_id');
            $table->timestamps();

            $table->foreign('libro_id')->references('id')->on('libros');
            $table->foreign('novio_id')->references('id')->on('feligreses');
            $table->foreign('novia_id')->references('id')->on('feligreses');
            $table->foreign('padre_novio_id')->references('id')->on('feligreses');
            $table->foreign('madre_novio_id')->references('id')->on('feligreses');
            $table->foreign('padre_novia_id')->references('id')->on('feligreses');
            $table->foreign('madre_novia_id')->references('id')->on('feligreses');
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
        Schema::dropIfExists('matrimonios');
    }
}
