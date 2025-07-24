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
        Schema::create('leyes_minerales_liquidacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('liquidacion_id')->constrained('liquidaciones')->onDelete('cascade');
            $table->foreignId('mineral_id')->constrained('minerales')->onDelete('cascade');
            $table->decimal('ley', 10, 4); // Ley en porcentaje (ej. 2.5%)
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
        Schema::dropIfExists('leyes_minerales_liquidacion');
    }
};
