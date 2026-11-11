@php($hotel = config('hotel'))

<x-layouts.app pageTitle="Tentang Kami">
    <section class="section-tight">
        <div class="container">
            <div class="section-heading">
                <span class="kicker">Tentang Kami</span>
                <h1>Keramahan Nusantara di Jantung Jakarta</h1>
            </div>

            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <p>{{ $hotel['name'] }} berdiri sejak 2012 sebagai penginapan keluarga yang mengutamakan kenyamanan tamu. Kami melayani wisatawan, pelaku bisnis, dan keluarga dengan tiga tipe kamar dan resepsionis 24 jam.</p>
                    <p>Kami percaya pengalaman menginap yang baik dimulai dari kebersihan, keramahan, dan transparansi harga. Semua biaya ditampilkan jelas dan dapat dihitung melalui formulir pemesanan.</p>

                    <div class="row g-3 mt-3">
                        <div class="col-sm-6">
                            <div class="feature-card">
                                <h2 class="h6 fw-bold mb-1">Visi</h2>
                                <p class="text-muted small mb-0">Menjadi pilihan penginapan utama yang ramah keluarga di Jakarta.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-card">
                                <h2 class="h6 fw-bold mb-1">Misi</h2>
                                <p class="text-muted small mb-0">Memberikan layanan terbaik dengan harga adil dan pelayanan tulus.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1000&q=80"
                         alt="Fasad {{ $hotel['name'] }}" class="about-image" loading="lazy">
                </div>
            </div>

            <div class="row g-5 mt-2">
                <div class="col-lg-6">
                    <h2 class="h5 fw-bold mb-2">Alamat &amp; Kontak</h2>
                    <div class="contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <div><strong class="d-block">Alamat</strong><span class="text-muted">{{ $hotel['address'] }}</span></div>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-telephone"></i>
                        <div><strong class="d-block">Telepon</strong><a href="tel:{{ preg_replace('/[^\d+]/', '', $hotel['phone']) }}">{{ $hotel['phone'] }}</a></div>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-whatsapp"></i>
                        <div><strong class="d-block">WhatsApp</strong><a href="https://wa.me/{{ preg_replace('/\D/', '', $hotel['whatsapp']) }}">{{ $hotel['whatsapp'] }}</a></div>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-envelope"></i>
                        <div><strong class="d-block">Email</strong><a href="mailto:{{ $hotel['email'] }}">{{ $hotel['email'] }}</a></div>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-clock"></i>
                        <div><strong class="d-block">Operasional</strong><span class="text-muted">Resepsionis 24 jam setiap hari.</span></div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h2 class="h5 fw-bold mb-3">Lokasi di Peta</h2>
                    <iframe class="map-frame"
                            src="https://www.google.com/maps?q={{ urlencode($hotel['maps_query']) }}&output=embed"
                            title="Peta lokasi {{ $hotel['name'] }}"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
