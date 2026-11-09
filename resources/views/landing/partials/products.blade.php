@if ($products->isNotEmpty())
<section class="sec" id="produk" aria-labelledby="h-produk">
    <div class="sh"><h2 id="h-produk">Produk dan Karya</h2></div>

    @php $palette = ['#1b30ae', '#87e246', '#2b2b2b', '#ed732e']; @endphp
    <div class="grid g3">
        @foreach ($products as $p)
            <article class="dcard" style="--c: {{ $palette[$loop->index % 4] }}">
                <img class="cover"
                     src="{{ $p->image ? asset('storage/' . $p->image) : asset('assets/landing/images/thumb-placeholder.webp') }}"
                     alt="" loading="lazy" decoding="async">
                <div class="cap">
                    <h3 class="ttl">{{ $p->name }}</h3>
                    <div class="reveal">
                        <div class="tags">
                            @if ($p->division)<span class="badge">{{ $p->division->name }}</span>@endif
                            <span class="badge">{{ $p->year }}</span>
                        </div>
                        <div class="acts">
                            @if ($p->link_url)
                                <a class="pill w" href="{{ $p->link_url }}" target="_blank" rel="noopener">Lihat karya</a>
                            @endif
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif
