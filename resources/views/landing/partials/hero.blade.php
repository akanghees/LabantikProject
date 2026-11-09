@php
    $heroImg = !empty($s['hero_image'])
        ? asset('storage/' . $s['hero_image'])
        : asset('assets/landing/images/hero-poster.webp');
    $heroBg = $s['hero_bg'] ?? null;
    $heroBgIsVideo = $heroBg && preg_match('/\.(mp4|webm)$/i', $heroBg);
@endphp
<section class="hero" id="top">
    {{-- Latar opsional (gambar atau video) dari settings.hero_bg --}}
    @if ($heroBg)
        <div class="hero-bg" aria-hidden="true">
            @if ($heroBgIsVideo)
                <video src="{{ asset('storage/' . $heroBg) }}" autoplay muted loop playsinline></video>
            @else
                <img src="{{ asset('storage/' . $heroBg) }}" alt="">
            @endif
        </div>
    @endif

    <div class="stage" id="stage">
        <h1>
            <span class="row r1"><span class="word">{{ $s['hero_word_1'] }}</span><span class="sans">{{ $s['hero_title_1'] }}</span></span>
            <span class="row r2"><span class="word">{{ $s['hero_word_2'] }}</span></span>
        </h1>

        {{-- Gambar yang berpindah-pindah (animasi spring dari Figma) --}}
        <div class="hero-img" id="heroImg"><img src="{{ $heroImg }}" alt="" width="200" height="270"></div>

        <p class="hero-copy">{{ $s['hero_text'] }}</p>

        <div class="hero-cta">
            <a class="btn" href="{{ route('dokumentasi.index') }}">
                <span class="ar l">@include('landing.partials.arrow')</span>
                <span class="lbl">Lihat Dokumentasi</span>
                <span class="ar r">@include('landing.partials.arrow')</span>
            </a>
            <a class="btn ghost" href="#tentang" data-go="tentang" data-off="-120">
                <span class="ar l">@include('landing.partials.arrow')</span>
                <span class="lbl">Tentang Kami</span>
                <span class="ar r">@include('landing.partials.arrow')</span>
            </a>
        </div>
    </div>
</section>
