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
        Schema::create('concesion_minas', function (Blueprint $table) {
        $table->id();
        $table->string('codigo')->unique();
        $table->string('mina'); // nombre de la mina
        $table->foreignId('municipio_id')
              ->constrained()
              ->onDelete('cascade'); // elimina concesiones si se elimina el municipio
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
        Schema::dropIfExists('concesion_minas');
    }
};
