@if ($photos->isNotEmpty())
<section class="sec" id="galeri" aria-labelledby="h-galeri">
    <div class="sh"><h2 id="h-galeri">Galeri Foto</h2></div>

    <div class="gal" id="gal">
        @foreach ($photos as $p)
            @php
                $full = asset('storage/' . $p->image);
                $cap  = $p->caption ?: 'Foto galeri ' . $s['site_name'];
            @endphp
            <button type="button" data-full="{{ $full }}" data-cap="{{ $p->caption }}" aria-label="Perbesar foto: {{ $cap }}">
                <img src="{{ $full }}" alt="{{ $cap }}" loading="lazy" decoding="async">
            </button>
        @endforeach
    </div>

    {{-- Lightbox (tanpa library, dikendalikan landing.js) --}}
    <div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Pratinjau foto">
        <img id="lbImg" src="" alt="">
        <p id="lbCap"></p>
        <div class="ctl">
            <button type="button" data-lb="prev">Sebelumnya</button>
            <button type="button" data-lb="next">Berikutnya</button>
            <button type="button" data-lb="close">Tutup</button>
        </div>
    </div>
</section>
@endif
