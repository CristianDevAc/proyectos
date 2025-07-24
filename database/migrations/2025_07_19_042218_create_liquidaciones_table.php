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
        Schema::create('liquidaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carga_id')->constrained('cargas')->onDelete('cascade');

            $table->date('fecha_liquidacion');
            $table->decimal('peso_humedo', 10, 2);
            $table->decimal('humedad', 5, 2);
            $table->decimal('peso_seco', 10, 2);
            $table->decimal('valor_tonelada_bs', 10, 5);
            $table->decimal('importe_total', 10, 2);
            $table->decimal('valor_bruto_compra', 10, 2);
            $table->decimal('total_deducciones', 10, 2);
            $table->decimal('cotizacion_dolar', 10, 2);
            $table->decimal('liquido_pagable', 15, 2);
            $table->decimal('total_regalia', 15, 2);
            $table->decimal('muestra')->default(0);
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
        Schema::dropIfExists('liquidaciones');
    }
};
