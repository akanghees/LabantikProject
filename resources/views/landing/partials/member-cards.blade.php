{{-- Kartu anggota. Dipakai oleh landing (angkatan aktif) dan endpoint AJAX /struktur/{generation} --}}
@forelse ($members as $m)
    @php
        $photo = $m->photo ? asset('storage/' . $m->photo) : asset('assets/landing/images/member-placeholder.webp');
        $sub = array_filter([$m->division ? $m->division->name : null, $m->skills]);
        $ig = $m->instagram ? ltrim($m->instagram, '@') : null;
    @endphp
    <article class="mc" tabindex="0">
        <div class="emp">
            <div class="ph"><img src="{{ $photo }}" alt="{{ $m->name }}" loading="lazy" decoding="async"></div>
            <div class="nm">
                <b>{{ $m->name }}</b>
                <span>{{ $m->position }}</span>
                @if ($sub)<small>{{ implode(', ', $sub) }}</small>@endif
                @if ($ig)<a href="https://instagram.com/{{ $ig }}" target="_blank" rel="noopener">{{ '@' . $ig }}</a>@endif
            </div>
        </div>
    </article>
@empty
    <p class="empty">Belum ada anggota untuk angkatan ini.</p>
@endforelse
