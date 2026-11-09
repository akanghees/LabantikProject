@extends('layouts.app')

@section('title', 'Dokumentasi — ' . $s['site_name'])

@section('content')
<section class="page">
    <div class="sh"><h2>Semua Dokumentasi</h2></div>

    <div class="filters">
        {{-- Cari berdasarkan judul (F-03) --}}
        <form class="search" method="GET" action="{{ route('dokumentasi.index') }}" role="search">
            @if (request('kategori'))<input type="hidden" name="kategori" value="{{ request('kategori') }}">@endif
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul dokumentasi" aria-label="Cari judul dokumentasi">
            <button class="pill w" type="submit">Cari</button>
        </form>

        {{-- Filter kategori (F-03) --}}
        <div class="chips" aria-label="Filter kategori">
            <a class="chip" href="{{ route('dokumentasi.index', array_filter(['q' => request('q')])) }}"
               @if (!request('kategori')) aria-current="page" @endif>Semua</a>
            @foreach ($categories as $c)
                <a class="chip" href="{{ route('dokumentasi.index', array_filter(['kategori' => $c->slug, 'q' => request('q')])) }}"
                   @if (request('kategori') === $c->slug) aria-current="page" @endif>{{ $c->name }}</a>
            @endforeach
        </div>
    </div>

    @if ($documentations->count())
        <div class="grid">
            @foreach ($documentations as $doc)
                @include('landing.partials.doc-card', ['doc' => $doc, 'i' => $loop->index])
            @endforeach
        </div>

        @if ($documentations->hasPages())
            <div class="pager">
                @if ($documentations->previousPageUrl())
                    <a class="pill o" href="{{ $documentations->previousPageUrl() }}">Sebelumnya</a>
                @endif
                @if ($documentations->nextPageUrl())
                    <a class="pill w" href="{{ $documentations->nextPageUrl() }}">Berikutnya</a>
                @endif
            </div>
        @endif
    @else
        <p class="empty">Tidak ada dokumentasi yang cocok dengan pencarianmu.</p>
    @endif
</section>
@endsection
