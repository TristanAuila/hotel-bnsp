<x-layouts.app pageTitle="Produk">
    <section class="section-tight">
        <div class="container">
            <div class="section-heading">
                <span class="kicker">Produk Kami</span>
                <h1>Pilih Kamar Sesuai Kebutuhan</h1>
                <p>Semua kamar dilengkapi AC, Wi-Fi gratis, dan kamar mandi dalam. Harga per malam sebelum diskon dan sarapan.</p>
            </div>

            <div class="row g-4">
                @foreach ($rooms as $tipe => $room)
                    <div class="col-md-6 col-lg-4">
                        <x-room-card :tipe="$tipe" :room="$room" show-facilities />
                    </div>
                @endforeach
            </div>

            <p class="text-center text-muted mt-5 mb-0">
                Ingin membandingkan harga? Lihat <a href="{{ route('harga') }}">Daftar Harga</a>.
            </p>
        </div>
    </section>
</x-layouts.app>
