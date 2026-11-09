@extends('layouts.app')

@section('title', $doc->title . ' — ' . $s['site_name'])
@section('description', \Illuminate\Support\Str::limit(strip_tags((string) $doc->description), 155))
@if ($doc->thumbnail)
    @section('og_image', asset('storage/' . $doc->thumbnail))
@endif

@section('content')
<article class="page detail">
    <img class="cover"
         src="{{ $doc->thumbnail ? asset('storage/' . $doc->thumbnail) : asset('assets/landing/images/thumb-placeholder.webp') }}"
         alt="{{ $doc->title }}">

    <h1>{{ $doc->title }}</h1>

    <div class="meta">
        @if ($doc->category)<span class="badge">{{ $doc->category->name }}</span>@endif
        <span class="badge">{{ $doc->event_date->translatedFormat('d F Y') }}</span>
        <span class="badge">{{ ucfirst($doc->media_type) }}</span>
        <span class="badge">{{ number_format($doc->download_count) }} unduhan</span>
    </div>

    @if ($doc->description)
        <p class="desc">{{ $doc->description }}</p>
    @endif

    <div class="acts">
        <a class="btn" href="{{ $doc->view_url }}" target="_blank" rel="noopener">
            <span class="ar l">@include('landing.partials.arrow')</span>
            <span class="lbl">Lihat</span>
            <span class="ar r">@include('landing.partials.arrow')</span>
        </a>
        @if ($doc->download_url)
            <a class="btn ghost" href="{{ route('dokumentasi.unduh', $doc->slug) }}">
                <span class="ar l">@include('landing.partials.arrow')</span>
                <span class="lbl">Unduh</span>
                <span class="ar r">@include('landing.partials.arrow')</span>
            </a>
        @endif
    </div>
</article>

@if ($related->isNotEmpty())
    <section class="sec">
        <div class="sh"><h2>Dokumentasi Terkait</h2></div>
        <div class="grid">
            @foreach ($related as $r)
                @include('landing.partials.doc-card', ['doc' => $r, 'i' => $loop->index])
            @endforeach
        </div>
    </section>
@endif
@endsection
