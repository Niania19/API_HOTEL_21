<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habitaciones', function (Blueprint $table) {

            $table->id('id_habitacion');

            $table->integer('numero');

            $table->unsignedBigInteger('id_hotel');
            $table->unsignedBigInteger('id_tipo');

            $table->decimal('precio',8,2);
            $table->string('estado');

            $table->foreign('id_hotel')
                ->references('id_hotel')
                ->on('hoteles')
                ->onDelete('cascade');

            $table->foreign('id_tipo')
                ->references('id_tipo')
                ->on('tipo_habitaciones')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habitaciones');
    }
};