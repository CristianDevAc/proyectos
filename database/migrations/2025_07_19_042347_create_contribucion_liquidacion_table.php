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
        Schema::create('contribucion_liquidacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contribucion_id')->constrained('contribuciones')->onDelete('cascade');
            $table->foreignId('liquidacion_id')->constrained('liquidaciones')->onDelete('cascade');
            $table->decimal('porcentaje', 5, 2);
            $table->decimal('precio', 10, 2);
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
        Schema::dropIfExists('contribucion_liquidacion');
    }
};
