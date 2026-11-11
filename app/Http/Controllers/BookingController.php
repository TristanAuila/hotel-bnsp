<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $rooms = RoomType::activeByName();

        $selectedType = $request->query('tipe');
        if (! $rooms->has($selectedType)) {
            $selectedType = $rooms->keys()->first();
        }

        return view('pesan', [
            'rooms' => $rooms,
            'selectedType' => $selectedType,
            'today' => now()->toDateString(),
            'durasiAwal' => min(365, max(1, $request->integer('durasi', 1))),
        ]);
    }

    public function store(Request $request)
    {
        $rooms = RoomType::activeByName();

        $data = $request->validate([
            'nama_pemesan' => ['required', 'string', 'min:3', 'max:100', "regex:/^[\pL\s.'-]+$/u"],
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'nomor_identitas' => 'required|digits:16',
            'tipe_kamar' => ['required', Rule::in($rooms->keys()->all())],
            'tanggal_pesan' => 'required|date_format:Y-m-d|after_or_equal:today',
            'durasi' => 'required|integer|min:1|max:365',
        ], [
            'required' => ':attribute wajib diisi.',
            'nama_pemesan.min' => 'Nama pemesan minimal 3 karakter.',
            'nama_pemesan.max' => 'Nama pemesan maksimal 100 karakter.',
            'nama_pemesan.regex' => 'Nama pemesan hanya boleh berisi huruf.',
            'jenis_kelamin.in' => 'Pilih jenis kelamin Laki-laki atau Perempuan.',
            'nomor_identitas.digits' => 'isian salah..data harus 16 digit',
            'tipe_kamar.in' => 'Tipe kamar tidak valid.',
            'tanggal_pesan.date_format' => 'Tanggal pesan tidak valid.',
            'tanggal_pesan.after_or_equal' => 'Tanggal pesan tidak boleh sebelum hari ini.',
            'durasi.integer' => 'harus isi angka',
            'durasi.min' => 'Durasi menginap minimal 1 malam.',
            'durasi.max' => 'Durasi menginap maksimal 365 malam.',
        ], [
            'nama_pemesan' => 'Nama pemesan',
            'jenis_kelamin' => 'Jenis kelamin',
            'nomor_identitas' => 'Nomor identitas',
            'tipe_kamar' => 'Tipe kamar',
            'tanggal_pesan' => 'Tanggal pesan',
            'durasi' => 'Durasi menginap',
        ]);

        $hargaKamar = $rooms[$data['tipe_kamar']]->price;
        $durasi = (int) $data['durasi'];
        $breakfast = $request->boolean('breakfast');
        $biaya = self::hitungBiaya($hargaKamar, $durasi, $breakfast);

        $booking = Booking::create([
            'kode_booking' => $this->buatKodeBooking(),
            'nama_pemesan' => $data['nama_pemesan'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'nomor_identitas' => $data['nomor_identitas'],
            'tipe_kamar' => $data['tipe_kamar'],
            'harga_kamar' => $hargaKamar,
            'tanggal_pesan' => $data['tanggal_pesan'],
            'durasi_menginap' => $durasi,
            'termasuk_breakfast' => $breakfast,
            'biaya_breakfast' => $biaya['breakfast'],
            'subtotal' => $biaya['subtotal'],
            'diskon' => $biaya['diskon'],
            'total_bayar' => $biaya['total'],
        ]);

        return redirect()->route('booking.success', $booking->kode_booking);
    }

    public function success(string $kodeBooking)
    {
        $booking = Booking::where('kode_booking', $kodeBooking)->firstOrFail();
        $room = RoomType::where('name', $booking->tipe_kamar)->first();

        return view('booking.success', compact('booking', 'room'));
    }

    /**
     * Aturan hitung (sesuai soal):
     * - Subtotal = (harga kamar x durasi) + (biaya breakfast x durasi).
     * - Diskon 10% dari subtotal kamar bila durasi > 3 malam.
     * - Lalu diskon tambahan 5% dari total setelah diskon 10%.
     */
    public static function hitungBiaya(int $hargaKamar, int $durasi, bool $breakfast): array
    {
        $subtotalKamar = $hargaKamar * $durasi;
        $biayaBreakfast = $breakfast ? (int) config('hotel.breakfast_fee') * $durasi : 0;
        $subtotal = $subtotalKamar + $biayaBreakfast;

        $dapatDiskon = $durasi > config('hotel.discount_min_nights');
        $diskon1 = $dapatDiskon ? (int) round($subtotalKamar * config('hotel.discount_rate')) : 0;
        $diskon2 = $dapatDiskon ? (int) round(($subtotal - $diskon1) * config('hotel.discount_rate2')) : 0;
        $diskon = $diskon1 + $diskon2;

        return [
            'kamar' => $subtotalKamar,
            'breakfast' => $biayaBreakfast,
            'subtotal' => $subtotal,
            'diskon1' => $diskon1,
            'diskon2' => $diskon2,
            'diskon' => $diskon,
            'total' => $subtotal - $diskon,
        ];
    }

    private function buatKodeBooking(): string
    {
        return 'HTL-'.now()->format('YmdHis').'-'.strtoupper(bin2hex(random_bytes(2)));
    }
}
