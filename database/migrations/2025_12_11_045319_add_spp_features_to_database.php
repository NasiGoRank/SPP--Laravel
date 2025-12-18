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
        // 1. Membuat tabel Program (Objektif 4)
        Schema::create('school_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: 'Reguler', 'Unggulan'
            $table->decimal('fee', 10, 2)->default(0); // Opsional: Menyimpan nominal SPP per program
            $table->timestamps();
        });

        // 2. Update tabel Siswa untuk relasi ke Program (Objektif 6 - Persiapan)
        Schema::table('students', function (Blueprint $table) {
            // Menambahkan kolom foreign key, nullable dulu agar data lama tidak error
            $table->foreignId('school_program_id')->nullable()->constrained('school_programs')->onDelete('set null');
        });

        // 3. Update tabel Transaksi untuk Bukti Bayar (Objektif 7)
        Schema::table('cash_transactions', function (Blueprint $table) {
            $table->string('proof_image')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_transactions', function (Blueprint $table) {
            $table->dropColumn('proof_image');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['school_program_id']);
            $table->dropColumn('school_program_id');
        });

        Schema::dropIfExists('school_programs');
    }
};
