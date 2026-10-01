<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ajuan_id')
                ->constrained('ajuans')
                ->cascadeOnDelete();
            $table->foreignId('temuan_id')
                ->nullable()
                ->constrained('temuans')
                ->nullOnDelete();
            $table->string('jenis_dokumen', 100);
            $table->string('nama_file', 255);
            $table->string('path_file', 500);
            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
