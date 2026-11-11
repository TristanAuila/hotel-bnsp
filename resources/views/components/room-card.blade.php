@props(['tipe', 'room', 'showFacilities' => false])

<article class="room-card">
    <img src="{{ $room->image_url }}" class="room-img" alt="Kamar {{ $tipe }}" loading="lazy">
    <span class="promo-badge">Hemat {{ round(config('hotel.discount_rate') * 100) }}% &bull; &gt; {{ config('hotel.discount_min_nights') }} malam</span>
    <div class="room-body">
        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
            <h3 class="h5 fw-bold mb-0">Kamar {{ $tipe }}</h3>
            <span class="price-tag">{{ $room->formatted_price }}/malam</span>
        </div>
        <p class="text-muted small mb-3">{{ $room->description }}</p>
        <div class="room-meta">
            <span><i class="bi bi-people me-1"></i>{{ $room->capacity }}</span>
            <span><i class="bi bi-arrows-fullscreen me-1"></i>{{ $room->size }}</span>
        </div>

        @if ($showFacilities)
            <div class="mb-3">
                @foreach ($room->facilities as $fasilitas)
                    <span class="facility-chip"><i class="bi bi-check2"></i>{{ $fasilitas }}</span>
                @endforeach
            </div>
        @endif

        <a href="{{ route('pesan.create', ['tipe' => $tipe]) }}" class="btn btn-pesan w-100">Pesan Kamar {{ $tipe }}</a>
    </div>
</article>
