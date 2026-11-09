<section class="sec" id="tentang" aria-labelledby="h-tentang">
    <div class="intro">
        <div class="eyebrow"><b>{{ $s['about_label'] }}</b><span>{{ $s['about_sub'] }}</span></div>
        <h2 class="big-type" id="h-tentang">
            @foreach (preg_split('/\R/', $s['about_headline']) as $line)
                <span class="bt-line">{{ $line }}</span>
            @endforeach
        </h2>
        <p class="lead">{{ $s['about_text'] }}</p>
    </div>

    @if ($divisions->isNotEmpty())
        {{-- Marquee nama divisi (Figma: strip logo klien) --}}
        <div class="clients" aria-hidden="true">
            <div class="track" id="divTrack" data-shift="12.875" data-cycle="10">
                <div class="set">
                    @foreach ($divisions as $d)
                        <span>{{ $d->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Daftar divisi (Figma: Our Capabilities) --}}
        <div class="divs">
            <h2>Divisi Kami</h2>
            <ul>
                @foreach ($divisions as $d)
                    <li>
                        <b>{{ $d->name }}</b>
                        @if ($d->description)<p>{{ $d->description }}</p>@endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</section>
