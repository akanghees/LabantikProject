<section class="sec" id="dokumentasi" aria-labelledby="h-dokumentasi">
    <div class="sh"><h2 id="h-dokumentasi">Dokumentasi Terbaru</h2></div>

    @if ($documentations->isNotEmpty())
        <div class="grid">
            @foreach ($documentations as $doc)
                @include('landing.partials.doc-card', ['doc' => $doc, 'i' => $loop->index])
            @endforeach
        </div>

        <div class="more">
            <a class="btn" href="{{ route('dokumentasi.index') }}">
                <span class="ar l">@include('landing.partials.arrow')</span>
                <span class="lbl">Semua Dokumentasi</span>
                <span class="ar r">@include('landing.partials.arrow')</span>
            </a>
        </div>
    @else
        <p class="empty">Belum ada dokumentasi yang dipublikasikan.</p>
    @endif
</section>
