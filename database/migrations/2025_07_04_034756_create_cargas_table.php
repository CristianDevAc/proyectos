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
        Schema::create('cargas', function (Blueprint $table) {
        $table->id();

        $table->foreignId('cooperativa_id')->nullable()->constrained('cooperativas')->onDelete('cascade');
        $table->foreignId('camion_id')->nullable()->constrained('camiones')->onDelete('cascade');
        $table->foreignId('concesion_mina_id')->nullable()->constrained('concesion_minas')->onDelete('cascade');
        $table->foreignId('plataforma_id')->constrained('plataformas')->onDelete('cascade');

        $table->string('lote');
        $table->integer('peso_tara');
        $table->integer('peso_bruto');
        $table->integer('peso_neto');
        $table->date('fecha_registro');
        $table->string('numero_boleta');
        $table->text('observaciones')->nullable();
        $table->integer('cantidad_sacos')->nullable();

        $table->enum('estado', ['PESAJE', 'ACUMULACION', 'LIQUIDACION', 'EXPORTADO'])->default('PESAJE');
        $table->enum('tipo', ['BROSA', 'CONCENTRADO','SACOS']);
        $table->string('producto')->nullable();;

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
        Schema::dropIfExists('cargas');
    }
};
