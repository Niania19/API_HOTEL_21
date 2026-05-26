<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->string('transaction_id')->nullable();

            $table->string('payment_status')
                  ->default('pendiente');

            $table->timestamp('payment_date')
                  ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([
                'transaction_id',
                'payment_status',
                'payment_date'
            ]);

        });
    }
};