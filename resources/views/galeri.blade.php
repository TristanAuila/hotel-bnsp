<x-layouts.app pageTitle="Galeri Media">
    <section class="section-tight">
        <div class="container">
            <div class="section-heading">
                <span class="kicker">Galeri Media</span>
                <h1>Lihat Suasana Hotel Kami</h1>
                <p>Jelajahi foto kamar, fasilitas, dan video singkat tentang {{ config('hotel.name') }}.</p>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-lg-10">
                    <div class="video-frame">
                        {{-- Ganti ID video dengan video profil hotel sendiri. --}}
                        <iframe src="https://www.youtube.com/embed/ScMzIvxBSi4"
                                title="Video profil {{ config('hotel.name') }}"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>
            </div>

            <h2 class="h4 fw-bold mb-3">Foto Hotel</h2>
            <div class="row g-4">
                @foreach ($galeri as $item)
                    <div class="col-sm-6 col-lg-4">
                        <figure class="gallery-item">
                            <img src="{{ $item['gambar'] }}" alt="{{ $item['caption'] }}" loading="lazy">
                            <figcaption>{{ $item['caption'] }}</figcaption>
                        </figure>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('pesan.create') }}" class="btn btn-pesan btn-lg px-4">Pesan Kamar</a>
            </div>
        </div>
    </section>
</x-layouts.app>
