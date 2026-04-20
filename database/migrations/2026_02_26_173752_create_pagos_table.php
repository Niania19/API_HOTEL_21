<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {

            $table->id('id_pago');

            $table->unsignedBigInteger('id_reserva');

            $table->decimal('monto',10,2);
            $table->date('fecha_pago');
            $table->string('metodo');

            $table->foreign('id_reserva')
                ->references('id_reserva')
                ->on('reservas')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};