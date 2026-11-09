@php
    $email = $s['contact_email'];
    $parts = \App\Models\Setting::emailParts($email);
    $socials = [
        'Instagram' => $s['instagram_url'] ?? null,
        'YouTube'   => $s['youtube_url'] ?? null,
        'TikTok'    => $s['tiktok_url'] ?? null,
    ];
@endphp
<footer class="contact" id="kontak">
    <div class="cstage">
        <div class="cbg"></div>

        {{-- Marquee email: "hello at instrument dot com" --}}
        <a class="cmarq" href="mailto:{{ $email }}" aria-label="Kirim email ke {{ $email }}">
            <div class="track" id="mailTrack" data-shift="5.305" data-cycle="10">
                <div class="set">
                    <span class="email">
                        @foreach ($parts as $p)
                            <span class="{{ $p['sans'] ? 'n' : 's' }}">{{ $p['text'] }}</span>
                        @endforeach
                    </span>
                    <span class="send"><svg viewBox="0 0 32 32" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 26 26 6M15 6h11v11"/></svg></span>
                </div>
            </div>
        </a>

        <div class="mailbox"><img src="{{ asset('assets/landing/images/mailbox.webp') }}" alt=""></div>

        <div class="ccta">
            <a class="btn" href="mailto:{{ $email }}">
                <span class="ar l">@include('landing.partials.arrow')</span>
                <span class="lbl">Hubungi Kami</span>
                <span class="ar r">@include('landing.partials.arrow')</span>
            </a>
        </div>

        <nav class="clinks" aria-label="Tautan footer">
            <a href="{{ route('dokumentasi.index') }}">Dokumentasi</a>
            @foreach ($socials as $label => $url)
                @if ($url)<a href="{{ $url }}" target="_blank" rel="noopener">{{ $label }}</a>@endif
            @endforeach
        </nav>

        <div class="cinfo">
            @if (!empty($s['location']))<div>{{ $s['location'] }}</div>@endif
            <div>&copy; {{ date('Y') }} {{ $s['site_name'] }}</div>
        </div>
    </div>
    <div class="foot-space"></div>
</footer>
