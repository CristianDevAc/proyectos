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
        Schema::create('muestra_laboratorio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carga_id')->constrained('cargas')->onDelete('cascade');
            $table->foreignId('laboratorio_id')->constrained('laboratorios')->onDelete('cascade');
            $table->date('fecha_muestra');
            $table->enum('tipo', ['NORMAL', 'CERTIFICADO']);
            $table->boolean('estado')->default(0);
            $table->text('observaciones')->nullable();
            $table->string('imagen_certificado')->nullable();
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
        Schema::dropIfExists('muestra_laboratorio');
    }
};
