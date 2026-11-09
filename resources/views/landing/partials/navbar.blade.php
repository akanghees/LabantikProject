@php
    $home = route('home');
    // [id section, label, offset scroll (px)]
    $menu = [
        ['dokumentasi', 'Dokumentasi', -40],
        ['galeri',      'Galeri',      -40],
        ['tentang',     'Tentang',     -120],
        ['struktur',    'Struktur',    -40],
        ['prestasi',    'Prestasi',    -40],
        ['produk',      'Produk',      -40],
        ['kontak',      'Kontak',      0],
    ];
@endphp
<header class="nav" id="nav">
    <div class="nav-bar">
        <a class="brand" href="{{ $home }}" data-go="top">{{ $s['site_name'] }}</a>

        <nav class="links" aria-label="Menu utama">
            @foreach ($menu as $m)
                <a href="{{ $home }}#{{ $m[0] }}" data-go="{{ $m[0] }}" data-off="{{ $m[2] }}">{{ $m[1] }}</a>
            @endforeach
            <a class="cta" href="{{ route('dokumentasi.index') }}">Lihat Dokumentasi</a>
        </nav>

        <button class="tog" type="button" aria-expanded="false" aria-controls="navPanel">Menu</button>
    </div>

    <div class="panel" id="navPanel">
        <ul>
            @foreach ($menu as $m)
                <li><a href="{{ $home }}#{{ $m[0] }}" data-go="{{ $m[0] }}" data-off="{{ $m[2] }}">{{ $m[1] }}</a></li>
            @endforeach
            <li><a class="cta" href="{{ route('dokumentasi.index') }}">Lihat Dokumentasi</a></li>
        </ul>
    </div>
</header>
