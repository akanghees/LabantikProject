@if ($testimonials->isNotEmpty())
<section class="sec" id="testimoni" aria-labelledby="h-testimoni">
    <div class="sh"><h2 id="h-testimoni">Kata Mereka</h2></div>

    <div class="tm" id="tm">
        <div class="slides">
            @foreach ($testimonials as $t)
                <figure class="slide {{ $loop->first ? 'on' : '' }}">
                    <blockquote>{{ $t->content }}</blockquote>
                    <figcaption class="by">
                        @if ($t->photo)<img src="{{ asset('storage/' . $t->photo) }}" alt="" loading="lazy">@endif
                        <b>{{ $t->name }}</b>
                        @if ($t->role)<span>{{ $t->role }}</span>@endif
                    </figcaption>
                </figure>
            @endforeach
        </div>

        @if ($testimonials->count() > 1)
            <div class="ctl">
                <div class="arrows">
                    <button type="button" data-tm="-1" aria-label="Testimoni sebelumnya"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 10H4M10 4l-6 6 6 6"/></svg></button>
                </div>
                <div class="dots">
                    @foreach ($testimonials as $t)
                        <button type="button" data-dot="{{ $loop->index }}" aria-label="Testimoni {{ $loop->iteration }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"></button>
                    @endforeach
                </div>
                <div class="arrows">
                    <button type="button" data-tm="1" aria-label="Testimoni berikutnya">@include('landing.partials.arrow')</button>
                </div>
            </div>
        @endif
    </div>
</section>
@endif
