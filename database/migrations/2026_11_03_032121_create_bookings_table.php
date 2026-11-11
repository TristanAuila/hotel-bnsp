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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking', 24)->unique()->comment('Kode unik pemesanan');
            $table->string('nama_pemesan', 100);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->char('nomor_identitas', 16)->comment('NIK 16 digit');
            $table->enum('tipe_kamar', ['Standar', 'Deluxe', 'Family']);
            $table->decimal('harga_kamar', 12, 2)->comment('Harga kamar per malam');
            $table->date('tanggal_pesan');
            $table->unsignedSmallInteger('durasi_menginap')->comment('Jumlah malam');
            $table->boolean('termasuk_breakfast')->default(false);
            $table->decimal('biaya_breakfast', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->comment('Subtotal kamar + breakfast');
            $table->decimal('diskon', 12, 2)->default(0);
            $table->decimal('total_bayar', 12, 2);
            $table->timestamps();

            $table->index('tanggal_pesan');
            $table->index('tipe_kamar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};