@php
    $hotel = config('hotel');
    $diskonPersen = round($hotel['discount_rate'] * 100);
    $contohKamar = $rooms->first();
    $contohMalam = $hotel['discount_min_nights'] + 1;
    $contoh = \App\Http\Controllers\BookingController::hitungBiaya($contohKamar->price, $contohMalam, true);
@endphp

<x-layouts.app pageTitle="Daftar Harga">
    <section class="section-tight">
        <div class="container">
            <div class="section-heading">
                <span class="kicker">Daftar Harga</span>
                <h1>Harga Jelas, Tanpa Biaya Tersembunyi</h1>
                <p>Harga berlaku per kamar per malam. Sarapan dan diskon dihitung otomatis pada formulir pemesanan.</p>
            </div>

            <div class="table-responsive">
                <table class="table price-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Tipe Kamar</th>
                            <th scope="col">Kapasitas</th>
                            <th scope="col">Ukuran</th>
                            <th scope="col">Fasilitas Utama</th>
                            <th scope="col" class="text-end">Harga / Malam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $tipe => $room)
                            <tr>
                                <th scope="row">Kamar {{ $tipe }}</th>
                                <td>{{ $room->capacity }}</td>
                                <td>{{ $room->size }}</td>
                                <td class="text-muted small">{{ implode(', ', array_slice($room->facilities, 0, 4)) }}</td>
                                <td class="text-end price-amount">{{ $room->formatted_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-md-6">
                    <div class="feature-card">
                        <span class="feature-icon"><i class="bi bi-cup-hot"></i></span>
                        <h2 class="h5 fw-bold">Tambahan Sarapan</h2>
                        <p class="text-muted mb-2">Centang <strong>Termasuk Breakfast</strong> pada formulir pemesanan.</p>
                        <p class="mb-0 fw-bold">Biaya: {{ rupiah($hotel['breakfast_fee']) }} per malam</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <span class="feature-icon"><i class="bi bi-percent"></i></span>
                        <h2 class="h5 fw-bold">Diskon Menginap</h2>
                        <p class="text-muted mb-2">Potongan <strong>{{ $diskonPersen }}%</strong> dari subtotal kamar untuk menginap lebih dari {{ $hotel['discount_min_nights'] }} malam.</p>
                        <p class="mb-0 fw-bold">Berlaku otomatis.</p>
                    </div>
                </div>
            </div>

            <div class="alert alert-light border mt-4" role="note">
                <strong>Contoh:</strong> {{ $contohMalam }} malam Kamar {{ $contohKamar->name }} + sarapan =
                ({{ $contohKamar->formatted_price }} &times; {{ $contohMalam }}) + ({{ rupiah($hotel['breakfast_fee']) }} &times; {{ $contohMalam }})
                &minus; diskon {{ $diskonPersen }}% ({{ rupiah($contoh['diskon1']) }})
                &minus; diskon {{ round($hotel['discount_rate2'] * 100) }}% ({{ rupiah($contoh['diskon2']) }}) =
                <strong>{{ rupiah($contoh['total']) }}</strong>.
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('pesan.create') }}" class="btn btn-pesan btn-lg px-4">Hitung &amp; Pesan Kamar</a>
            </div>
        </div>
    </section>
</x-layouts.app>
