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
        Schema::create('camiones', function (Blueprint $table) {
        $table->id();
        $table->string('placa')->unique(); 
        $table->integer('pesaje'); 
        $table->text('descripcion')->nullable();
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('camiones');
    }
};
