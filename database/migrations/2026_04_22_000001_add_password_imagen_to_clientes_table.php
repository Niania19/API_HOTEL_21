<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            if (!Schema::hasColumn('clientes', 'password')) {
                $table->string('password', 255)->after('telefono');
            }
            if (!Schema::hasColumn('clientes', 'imagen')) {
                $table->string('imagen')->nullable()->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            if (Schema::hasColumn('clientes', 'imagen')) {
                $table->dropColumn('imagen');
            }
            if (Schema::hasColumn('clientes', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
};
