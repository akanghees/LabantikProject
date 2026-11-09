@if ($achievements->isNotEmpty())
<section class="sec" id="prestasi" aria-labelledby="h-prestasi">
    <div class="sh"><h2 id="h-prestasi">Prestasi</h2></div>

    <ul class="ach">
        @foreach ($achievements as $a)
            <li>
                <article class="arow">
                    <span class="dt">{{ $a->event_date->translatedFormat('d M Y') }}</span>
                    <div>
                        <h3>{{ $a->title }}</h3>
                        @if ($a->members->isNotEmpty())
                            <p class="who">{{ $a->members->pluck('name')->implode(', ') }}</p>
                        @endif
                    </div>
                    <div class="tg">
                        <span class="tag rank">{{ $a->rank }}</span>
                        <span class="tag">{{ ucfirst($a->level) }}</span>
                        @if ($a->organizer)<span class="tag">{{ $a->organizer }}</span>@endif
                    </div>
                    @if ($a->photo)
                        <img src="{{ asset('storage/' . $a->photo) }}" alt="" loading="lazy">
                    @endif
                </article>
            </li>
        @endforeach
    </ul>
</section>
@endif
