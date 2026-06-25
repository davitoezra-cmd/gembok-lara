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
        Schema::create('backbones', function (Blueprint $table) {
           $table->id();
            $table->string('kode_backbone')->unique(); // Contoh: BB-KDR-001
            $table->string('nama_jalur');            // Contoh: Node A ke Node B
            $table->integer('kapasitas_core');       // Contoh: 24, 48, 96 Core
            $table->integer('core_terpakai')->default(0);
            $table->double('panjang_kabel');         // Dalam satuan Meter atau KM
            $table->enum('tipe_kabel', ['aerial', 'underground', 'submarine'])->default('aerial');
            $table->enum('status', ['aktif', 'gangguan', 'maintenance'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backbones');
    }
};
