<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'kode_booking',
        'nama_pemesan',
        'jenis_kelamin',
        'nomor_identitas',
        'tipe_kamar',
        'harga_kamar',
        'tanggal_pesan',
        'durasi_menginap',
        'termasuk_breakfast',
        'biaya_breakfast',
        'subtotal',
        'diskon',
        'total_bayar',
    ];

    protected $casts = [
        'harga_kamar' => 'integer',
        'biaya_breakfast' => 'integer',
        'subtotal' => 'integer',
        'diskon' => 'integer',
        'total_bayar' => 'integer',
        'durasi_menginap' => 'integer',
        'termasuk_breakfast' => 'boolean',
        'tanggal_pesan' => 'date',
    ];

    /** Subtotal kamar saja (harga x durasi), tanpa breakfast. */
    public function getSubtotalKamarAttribute(): int
    {
        return $this->harga_kamar * $this->durasi_menginap;
    }
}
