<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            // User yang absen (bisa admin, teknisi, collector, agent)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Role saat absen, untuk membedakan dari portal mana
            // nilai: admin | technician | collector | agent
            $table->enum('role', ['admin', 'technician', 'collector', 'agent']);

            // Foto selfie — disimpan sebagai path file di storage/app/public/attendances/
            $table->string('photo')->nullable()->comment('Path foto selfie');

            // Lokasi GPS saat absen
            $table->decimal('latitude', 10, 7)->nullable()->comment('Latitude GPS');
            $table->decimal('longitude', 10, 7)->nullable()->comment('Longitude GPS');

            // Alamat hasil reverse geocoding (opsional, bisa diisi dari frontend)
            $table->string('address')->nullable()->comment('Alamat lokasi absen');

            // Waktu check-in dan check-out dalam satu hari
            $table->timestamp('check_in')->nullable()->comment('Waktu masuk');
            $table->timestamp('check_out')->nullable()->comment('Waktu pulang');

            // Status kehadiran
            $table->enum('status', ['hadir', 'terlambat', 'izin', 'sakit'])->default('hadir');

            // Catatan tambahan (opsional)
            $table->text('notes')->nullable()->comment('Catatan absen');

            // Tanggal absen (memudahkan query per hari tanpa parsing timestamp)
            $table->date('date')->comment('Tanggal absen');

            $table->timestamps();

            // Index untuk mempercepat query per user per tanggal
            $table->index(['user_id', 'date']);
            $table->index(['role', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};