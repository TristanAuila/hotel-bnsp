@php
    $hotel = config('hotel');
    $diskonPersen = round($hotel['discount_rate'] * 100);
    $diskonPersen2 = round($hotel['discount_rate2'] * 100);
    $tipeAwal = old('tipe_kamar', $selectedType);
    $hargaAwal = $rooms[$tipeAwal]->formatted_price ?? rupiah(0);
    $jsConfig = [
        'prices' => $rooms->map->price,
        'breakfastFee' => $hotel['breakfast_fee'],
        'discountRate' => $hotel['discount_rate'],
        'discountRate2' => $hotel['discount_rate2'],
        'discountMinNights' => $hotel['discount_min_nights'],
    ];
@endphp

<x-layouts.app pageTitle="Pesan Kamar">
    <section class="section-tight">
        <div class="container">
            <div class="section-heading">
                <span class="kicker">Pesan Kamar</span>
                <h1>Formulir Pemesanan</h1>
                <p>Lengkapi data di bawah. Total bayar dihitung otomatis.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Periksa kembali isian Anda:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="booking-panel">
                        <div class="panel-header"><h2>Data Pemesan</h2></div>
                        <div class="panel-body">
                            <form id="formPemesanan" action="{{ route('pesan.store') }}" method="post" novalidate>
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6" data-field>
                                        <label for="namaPemesan" class="form-label">Nama Pemesan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_pemesan') is-invalid @enderror"
                                               id="namaPemesan" name="nama_pemesan" value="{{ old('nama_pemesan') }}"
                                               placeholder="Contoh: Budi Santoso" autocomplete="name" maxlength="100" required>
                                        <div class="invalid-feedback">@error('nama_pemesan'){{ $message }}@enderror</div>
                                    </div>

                                    <div class="col-md-6" data-field id="grupJenisKelamin">
                                        <span class="form-label d-block">Jenis Kelamin <span class="text-danger">*</span></span>
                                        @foreach (['lakiLaki' => 'Laki-laki', 'perempuan' => 'Perempuan'] as $id => $jk)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="{{ $id }}"
                                                       value="{{ $jk }}" required @checked(old('jenis_kelamin') === $jk)>
                                                <label class="form-check-label" for="{{ $id }}">{{ $jk }}</label>
                                            </div>
                                        @endforeach
                                        <div class="invalid-feedback">Silakan pilih jenis kelamin.</div>
                                    </div>

                                    <div class="col-md-6" data-field>
                                        <label for="nomorIdentitas" class="form-label">Nomor Identitas (NIK) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nomor_identitas') is-invalid @enderror"
                                               id="nomorIdentitas" name="nomor_identitas" value="{{ old('nomor_identitas') }}"
                                               placeholder="16 digit angka" inputmode="numeric" minlength="16" maxlength="16" pattern="\d{16}" autocomplete="off" required>
                                        <div class="invalid-feedback">@error('nomor_identitas'){{ $message }}@enderror</div>
                                        <div id="infoNik" class="info-diskon" aria-live="polite"></div>
                                    </div>

                                    <div class="col-md-6" data-field>
                                        <label for="tanggalPesan" class="form-label">Tanggal Pesan <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tanggal_pesan') is-invalid @enderror"
                                               id="tanggalPesan" name="tanggal_pesan" min="{{ $today }}"
                                               value="{{ old('tanggal_pesan', $today) }}" required>
                                        <div class="invalid-feedback">@error('tanggal_pesan'){{ $message }}@enderror</div>
                                    </div>

                                    <div class="col-md-6" data-field>
                                        <label for="tipeKamar" class="form-label">Tipe Kamar <span class="text-danger">*</span></label>
                                        <select class="form-select" id="tipeKamar" name="tipe_kamar" required>
                                            @foreach ($rooms as $tipe => $room)
                                                <option value="{{ $tipe }}" @selected($tipe === $tipeAwal)>{{ $tipe }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="hargaKamar" class="form-label">Harga / Malam</label>
                                        <input type="text" class="form-control fw-bold" id="hargaKamar" value="{{ $hargaAwal }}" readonly tabindex="-1">
                                    </div>

                                    <div class="col-md-6" data-field>
                                        <label for="durasiMenginap" class="form-label">Durasi Menginap (malam) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('durasi') is-invalid @enderror"
                                               id="durasiMenginap" name="durasi" value="{{ old('durasi', $durasiAwal) }}"
                                               inputmode="numeric" maxlength="3" required>
                                        <div class="invalid-feedback">@error('durasi'){{ $message }}@enderror</div>
                                        <div id="infoDiskon" class="info-diskon" aria-live="polite"></div>
                                    </div>

                                    <div class="col-md-6 d-flex align-items-end">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                   id="termasukBreakfast" name="breakfast" value="1" @checked(old('breakfast'))>
                                            <label class="form-check-label" for="termasukBreakfast">
                                                Termasuk Breakfast (+{{ rupiah($hotel['breakfast_fee']) }}/malam)
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <button type="button" class="btn btn-outline-dark px-4" id="btnHitung">
                                        <i class="bi bi-calculator me-1"></i>Hitung Total Bayar
                                    </button>
                                    <button type="submit" class="btn btn-pesan px-4" id="btnKirim">
                                        <i class="bi bi-send me-1"></i>Kirim Pesanan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="booking-panel">
                        <div class="panel-header"><h2>Ringkasan Biaya</h2></div>
                        <div class="panel-body">
                            <div class="summary-box">
                                <div class="summary-row"><span>Harga / malam</span><span id="ringkasHarga">{{ $hargaAwal }}</span></div>
                                <div class="summary-row"><span>Durasi</span><span><span id="ringkasDurasi">1</span> malam</span></div>
                                <div class="summary-row"><span>Subtotal kamar</span><span id="ringkasSubtotalKamar">-</span></div>
                                <div class="summary-row"><span>Breakfast</span><span id="ringkasBreakfast">-</span></div>
                                <div class="summary-row"><span>Diskon {{ $diskonPersen }}%</span><span class="discount" id="ringkasDiskon">-</span></div>
                                <div class="summary-row"><span>Diskon {{ $diskonPersen2 }}%</span><span class="discount" id="ringkasDiskon2">-</span></div>
                                <div class="summary-row total"><span>Total Bayar</span><span id="ringkasTotal">-</span></div>
                            </div>
                            <div id="infoHitung" class="alert alert-light border small mt-3 mb-0" role="status">
                                Tekan <strong>Hitung Total Bayar</strong> untuk memastikan perhitungan.
                            </div>
                        </div>
                    </div>

                    <ul class="small text-muted mt-3 ps-3">
                        <li>NIK harus tepat 16 digit angka.</li>
                        <li>Breakfast {{ rupiah($hotel['breakfast_fee']) }} per malam.</li>
                        <li>Diskon {{ $diskonPersen }}% dari subtotal kamar bila menginap lebih dari {{ $hotel['discount_min_nights'] }} malam, lalu diskon tambahan {{ $diskonPersen2 }}% dari total setelahnya.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            window.HOTEL = @json($jsConfig);
        </script>
    @endpush
</x-layouts.app>
