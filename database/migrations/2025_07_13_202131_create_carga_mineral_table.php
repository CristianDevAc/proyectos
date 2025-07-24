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
        Schema::create('carga_mineral', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carga_id')->constrained('cargas')->onDelete('cascade');
            $table->foreignId('mineral_id')->constrained('minerales')->onDelete('cascade');
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
        Schema::dropIfExists('carga_mineral');
    }
};
