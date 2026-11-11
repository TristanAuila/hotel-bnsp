<x-layouts.app pageTitle="Pemesanan Berhasil">
    <section class="section-tight">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="receipt">
                        <div class="receipt-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div>
                                <h1 class="h3 fw-bold mb-1"><i class="bi bi-check-circle me-2"></i>Pemesanan Berhasil</h1>
                                <p class="text-white-50 mb-0">Terima kasih, {{ $booking->nama_pemesan }}.</p>
                            </div>
                            <div class="text-md-end">
                                <span class="d-block small text-white-50">Kode Booking</span>
                                <strong class="fs-5">{{ $booking->kode_booking }}</strong>
                            </div>
                        </div>

                        <div class="panel-body">
                            <h2 class="h5 fw-bold mb-3">Detail Pemesan</h2>
                            <table class="table table-sm align-middle mb-4">
                                <tbody>
                                    @foreach ([
                                        'Nama Pemesan' => $booking->nama_pemesan,
                                        'Jenis Kelamin' => $booking->jenis_kelamin,
                                        'Nomor Identitas' => $booking->nomor_identitas,
                                        'Tipe Kamar' => 'Kamar ' . $booking->tipe_kamar . ($room ? ' · ' . $room->capacity : ''),
                                        'Tanggal Pesan' => $booking->tanggal_pesan->format('d/m/Y'),
                                        'Durasi Menginap' => $booking->durasi_menginap . ' malam',
                                        'Termasuk Breakfast' => $booking->termasuk_breakfast ? 'Ya' : 'Tidak',
                                    ] as $label => $nilai)
                                        <tr>
                                            <th scope="row" class="text-muted fw-normal w-25">{{ $label }}</th>
                                            <td>{{ $nilai }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <h2 class="h5 fw-bold mb-3">Rincian Pembayaran</h2>
                            <div class="summary-box">
                                <div class="summary-row"><span>Harga / malam</span><span>{{ rupiah($booking->harga_kamar) }}</span></div>
                                <div class="summary-row"><span>Subtotal kamar ({{ $booking->durasi_menginap }} malam)</span><span>{{ rupiah($booking->subtotal_kamar) }}</span></div>
                                <div class="summary-row"><span>Breakfast</span><span>{{ rupiah($booking->biaya_breakfast) }}</span></div>
                                <div class="summary-row"><span>Diskon</span><span class="discount">- {{ rupiah($booking->diskon) }}</span></div>
                                <div class="summary-row total"><span>Total Bayar</span><span>{{ rupiah($booking->total_bayar) }}</span></div>
                            </div>

                            <div class="alert alert-light border small my-4">
                                Tunjukkan kode <strong>{{ $booking->kode_booking }}</strong> kepada resepsionis saat tiba. Pembayaran dilakukan di hotel.
                            </div>

                            <div class="d-flex flex-wrap gap-2 no-print">
                                <a href="{{ route('home') }}" class="btn btn-outline-dark"><i class="bi bi-house-door me-1"></i>Beranda</a>
                                <a href="{{ route('pesan.create') }}" class="btn btn-outline-dark"><i class="bi bi-plus-circle me-1"></i>Pesan Lagi</a>
                                <button type="button" class="btn btn-pesan" onclick="window.print()"><i class="bi bi-printer me-1"></i>Cetak Bukti</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
