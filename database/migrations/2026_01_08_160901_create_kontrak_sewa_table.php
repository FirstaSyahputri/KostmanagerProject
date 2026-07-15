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
        Schema::create('kontrak_sewa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('penyewa_id')->constrained('penyewa')->onDelete('cascade');
            $table->foreignId('kamar_id')->constrained('kamar')->onDelete('restrict');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('harga_bulanan', 10, 2);
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak_sewa');
    }
};
