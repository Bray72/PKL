<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('ajuans', 'nama_opd')) {
            Schema::table('ajuans', function (Blueprint $table) {
                // Nullable agar migration aman pada database yang sudah berisi data lama.
                $table->string('nama_opd', 255)->nullable()->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('ajuans', 'nama_opd')) {
            Schema::table('ajuans', function (Blueprint $table) {
                $table->dropColumn('nama_opd');
            });
        }
    }
};
