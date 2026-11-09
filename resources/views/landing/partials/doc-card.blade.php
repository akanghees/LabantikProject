{{-- Kartu dokumentasi. Variabel: $doc (model Documentation), $i (indeks, untuk warna latar cadangan) --}}
@php
    $palette = ['#1b30ae', '#87e246', '#2b2b2b', '#ed732e'];
    $thumb = $doc->thumbnail
        ? asset('storage/' . $doc->thumbnail)
        : asset('assets/landing/images/thumb-placeholder.webp');
@endphp
<article class="dcard" style="--c: {{ $palette[$i % 4] }}">
    <img class="cover" src="{{ $thumb }}" alt="" loading="lazy" decoding="async">

    <div class="cap">
        <h3 class="ttl"><a href="{{ route('dokumentasi.show', $doc->slug) }}">{{ $doc->title }}</a></h3>

        <div class="reveal">
            <div class="tags">
                @if ($doc->category)
                    <span class="badge">{{ $doc->category->name }}</span>
                @endif
                <span class="badge">{{ $doc->event_date->translatedFormat('d M Y') }}</span>
                <span class="badge">{{ ucfirst($doc->media_type) }}</span>
            </div>
            <div class="acts">
                <a class="pill w" href="{{ $doc->view_url }}" target="_blank" rel="noopener">Lihat</a>
                @if ($doc->download_url)
                    <a class="pill o" href="{{ route('dokumentasi.unduh', $doc->slug) }}">Unduh</a>
                @endif
            </div>
        </div>
    </div>
</article>
