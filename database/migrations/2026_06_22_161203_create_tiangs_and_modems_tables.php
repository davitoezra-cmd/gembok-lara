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
        Schema::create('tiangs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tiang')->unique();
            $table->string('lokasi_spesifik');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('status')->default('baik');
            $table->timestamps();
        });

        Schema::create('modems', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_aset_internal')->unique(); // GL-MDM-2026-001
        $table->string('serial_number')->unique();       // SN Pabrik
        $table->string('merek');                         // Huawei / ZTE
        $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete(); 
        $table->enum('status', ['stok_gudang', 'terpasang', 'rusak'])->default('stok_gudang');
        $table->timestamps();
    });
    }
        

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modems');
        Schema::dropIfExists('tiangs');
    }
};
