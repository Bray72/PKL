<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('ajuans', 'created_by')) {
            Schema::table('ajuans', function (Blueprint $table) {
                $table->dropConstrainedForeignId('created_by');
            });
        }
    }

    public function down(): void
    {
        Schema::table('ajuans', function (Blueprint $table) {
            $table->foreignId('created_by')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->restrictOnDelete();
        });
    }
};
