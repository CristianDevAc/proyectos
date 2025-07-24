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
        Schema::create('minerales', function (Blueprint $table) {
            $table->id(); 
            $table->string('simbolo'); 
            $table->string('nombre'); 
            $table->decimal('alicuota', 5, 2); 
            $table->decimal('conversion', 9, 6); 
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
        Schema::dropIfExists('minerales');
    }
};
