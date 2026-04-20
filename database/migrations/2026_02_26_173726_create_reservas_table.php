<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {

            $table->id('id_reserva');

            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_habitacion');

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->string('estado');

            $table->foreign('id_cliente')
                ->references('id_cliente')
                ->on('clientes')
                ->onDelete('cascade');

            $table->foreign('id_habitacion')
                ->references('id_habitacion')
                ->on('habitaciones')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};