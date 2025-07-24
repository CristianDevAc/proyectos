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
        Schema::create('muestra_laboratorio_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('muestra_laboratorio_id')->constrained('muestra_laboratorio')->onDelete('cascade');
            $table->foreignId('mineral_id')->constrained('minerales')->onDelete('cascade');
            $table->decimal('humedad', 8, 2)->nullable();
            $table->decimal('ley', 8, 2)->nullable();
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
        Schema::dropIfExists('muestra_laboratorio_detail');
    }
};
