@props(['pageTitle' => null])

@php
    $menu = [
        'home'         => ['label' => 'Beranda',      'icon' => 'bi-house-door'],
        'produk'       => ['label' => 'Produk',       'icon' => 'bi-door-open'],
        'harga'        => ['label' => 'Daftar Harga', 'icon' => 'bi-tags'],
        'tentang'      => ['label' => 'Tentang Kami', 'icon' => 'bi-info-circle'],
        'pesan.create' => ['label' => 'Pesan Kamar',  'icon' => 'bi-calendar-check'],
        'galeri'       => ['label' => 'Galeri Media', 'icon' => 'bi-images'],
    ];
    $hotel = config('hotel');
@endphp

<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $hotel['name'] }} - {{ $hotel['tagline'] }}. Pesan kamar hotel secara online dengan harga terbaik.">
    <title>{{ $pageTitle ? $pageTitle . ' · ' : '' }}{{ $hotel['name'] }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<a href="#konten-utama" class="visually-hidden-focusable skip-link">Lewati ke konten utama</a>

<nav class="navbar navbar-expand-lg site-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="brand-mark"><i class="bi bi-building"></i></span>
            <span>
                {{ $hotel['name'] }}
                <small class="d-block brand-sub">HOTEL &amp; RESIDENCE</small>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuUtama"
                aria-controls="menuUtama" aria-expanded="false" aria-label="Buka menu navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuUtama">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                @foreach ($menu as $route => $item)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}" href="{{ route($route) }}"
                           @if (request()->routeIs($route)) aria-current="page" @endif>
                            <i class="bi {{ $item['icon'] }} me-1"></i>{{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

<main id="konten-utama">
    {{ $slot }}
</main>

<footer class="site-footer">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <h2 class="footer-brand h5 mb-3"><i class="bi bi-building me-2"></i>{{ $hotel['name'] }}</h2>
                <p class="text-white-50 mb-3">
                    Penginapan modern di jantung Jakarta dengan pelayanan ramah, kamar nyaman,
                    dan harga transparan untuk keluarga maupun perjalanan bisnis.
                </p>
                <div class="d-flex gap-2">
                    <a class="footer-social" href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a class="footer-social" href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a class="footer-social" href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h3 class="footer-heading">Navigasi</h3>
                <ul class="list-unstyled footer-links">
                    @foreach ($menu as $route => $item)
                        <li><a href="{{ route($route) }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h3 class="footer-heading">Layanan</h3>
                <ul class="list-unstyled footer-links">
                    @foreach (['Resepsionis 24 jam', 'Sarapan pagi', 'Wi-Fi gratis', 'Parkir luas', 'Laundry kilat'] as $layanan)
                        <li><i class="bi bi-check2 me-2"></i>{{ $layanan }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-3">
                <h3 class="footer-heading">Hubungi Kami</h3>
                <ul class="list-unstyled footer-links">
                    <li><i class="bi bi-geo-alt me-2"></i>{{ $hotel['address'] }}</li>
                    <li><i class="bi bi-telephone me-2"></i><a href="tel:{{ preg_replace('/[^\d+]/', '', $hotel['phone']) }}">{{ $hotel['phone'] }}</a></li>
                    <li><i class="bi bi-whatsapp me-2"></i><a href="https://wa.me/{{ preg_replace('/\D/', '', $hotel['whatsapp']) }}">{{ $hotel['whatsapp'] }}</a></li>
                    <li><i class="bi bi-envelope me-2"></i><a href="mailto:{{ $hotel['email'] }}">{{ $hotel['email'] }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container d-flex flex-column flex-md-row justify-content-between gap-2 py-3">
            <span>&copy; {{ date('Y') }} {{ $hotel['name'] }}. Seluruh hak cipta dilindungi.</span>
            <span>Dibuat untuk praktik Junior Web Developer &middot; LSP Informatika</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
@stack('scripts')
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
