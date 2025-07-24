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
    public function up(): void
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mineral_id')
                  ->constrained('minerales')
                  ->onDelete('cascade');

            $table->enum('quincena', ['PRIMERA', 'SEGUNDA']);
            $table->year('gestion');
            $table->tinyInteger('mes'); // 1 a 12
            $table->decimal('valor', 10, 2);

            $table->timestamps();

            // Prevención de duplicados
            $table->unique(['mineral_id', 'quincena', 'gestion', 'mes'], 'cotizacion_unica');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizaciones');
    }
};
