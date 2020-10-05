<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParrocoParroquiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parroco_parroquias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parroco_id');
            $table->unsignedBigInteger('parroquia_id');
            $table->boolean('actual')->default(true);
            $table->boolean('principal')->default(false);
            $table->timestamps();

            $table->foreign('parroco_id')->references('id')->on('parrocos');
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
        Schema::dropIfExists('parroco_parroquias');
    }
}
