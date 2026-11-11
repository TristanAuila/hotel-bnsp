<x-layouts.app pageTitle="Beranda">
    <section class="hero">
        <div class="container">
            <span class="eyebrow">Hotel di Jakarta Pusat</span>
            <h1>Istirahat Nyaman,<br>Harga Tetap Bersahabat.</h1>
            <p class="lead">
                Selamat datang di {{ config('hotel.name') }}. Kamar bersih, sarapan lezat,
                dan pelayanan ramah di lokasi strategis pusat kota Jakarta.
            </p>
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="{{ route('pesan.create') }}" class="btn btn-pesan btn-lg px-4">Pesan Kamar</a>
                <a href="{{ route('produk') }}" class="btn btn-outline-light btn-lg px-4">Lihat Kamar</a>
            </div>
        </div>
    </section>

    <section class="section-tight">
        <div class="container">
            <div class="promo-banner mb-5">
                <span class="promo-angka">{{ round(config('hotel.discount_rate') * 100) }}%</span>
                <div class="flex-grow-1">
                    <strong class="d-block">Promo Menginap Lama</strong>
                    Hemat {{ round(config('hotel.discount_rate') * 100) }}% dari harga kamar untuk menginap lebih dari {{ config('hotel.discount_min_nights') }} malam. Otomatis, tanpa kode promo.
                </div>
                <a href="{{ route('pesan.create', ['durasi' => config('hotel.discount_min_nights') + 1]) }}" class="btn btn-gold d-none d-md-inline-block">Pesan Sekarang</a>
            </div>

            <div class="row g-4 mb-5">
                @foreach ([
                    ['bi-geo-alt', 'Lokasi Strategis', 'Di Jalan Jenderal Sudirman, dekat pusat bisnis, mal, dan transportasi umum.'],
                    ['bi-cup-hot', 'Sarapan Berkualitas', 'Tambahkan paket sarapan dengan menu khas Nusantara setiap pagi.'],
                    ['bi-shield-check', 'Pemesanan Aman', 'Total pembayaran dihitung transparan tanpa biaya tersembunyi.'],
                ] as [$icon, $judul, $teks])
                    <div class="col-md-4">
                        <div class="feature-card">
                            <span class="feature-icon"><i class="bi {{ $icon }}"></i></span>
                            <h2 class="h6 fw-bold">{{ $judul }}</h2>
                            <p class="text-muted small mb-0">{{ $teks }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="section-heading">
                <span class="kicker">Pilihan Kamar</span>
                <h2>Kamar Terbaik untuk Anda</h2>
                <p>Tiga pilihan kamar yang bisa disesuaikan dengan kebutuhan dan anggaran.</p>
            </div>

            <div class="row g-4">
                @foreach ($rooms as $tipe => $room)
                    <div class="col-md-6 col-lg-4">
                        <x-room-card :tipe="$tipe" :room="$room" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
