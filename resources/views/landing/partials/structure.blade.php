@if ($generations->isNotEmpty())
<section class="sec" id="struktur" aria-labelledby="h-struktur" data-url="{{ url('struktur') }}">
    <div class="sh"><h2 id="h-struktur">Struktur Organisasi</h2></div>

    {{-- Pilihan angkatan --}}
    <div class="chips" id="chips" role="group" aria-label="Pilih angkatan">
        @foreach ($generations as $g)
            <button type="button" class="chip" data-gen="{{ $g->id }}"
                    aria-pressed="{{ $activeGeneration && $g->id === $activeGeneration->id ? 'true' : 'false' }}">{{ $g->name }}</button>
        @endforeach
    </div>

    {{-- Carousel kartu anggota --}}
    <div class="mtrack" id="mtrack" aria-live="polite">
        @include('landing.partials.member-cards', ['members' => $members])
    </div>

    <div class="arrows">
        <button type="button" data-mv="-1" aria-label="Geser ke kiri"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 10H4M10 4l-6 6 6 6"/></svg></button>
        <button type="button" data-mv="1" aria-label="Geser ke kanan">@include('landing.partials.arrow')</button>
    </div>
</section>
@endif
