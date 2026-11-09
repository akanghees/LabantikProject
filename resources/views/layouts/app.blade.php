<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0f0f0f">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $s['site_name'].' — Komunitas Dokumentasi Sekolah')</title>
    <meta name="description" content="@yield('description', \Illuminate\Support\Str::limit($s['hero_text'], 155))">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $s['site_name'] }}">
    <meta property="og:title" content="@yield('title', $s['site_name'].' — Komunitas Dokumentasi Sekolah')">
    <meta property="og:description" content="@yield('description', \Illuminate\Support\Str::limit($s['hero_text'], 155))">
    <meta property="og:image" content="@yield('og_image', asset('assets/landing/images/hero-poster.webp'))">

    <link rel="preload" href="{{ asset('assets/landing/fonts/instrument-sans-latin-500-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/landing/fonts/instrument-serif-latin-400-italic.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/landing/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing/css/landing.css') }}?v={{ filemtime(public_path('assets/landing/css/landing.css')) }}">
</head>
<body>
    @include('landing.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('landing.partials.footer')

    <script src="{{ asset('assets/landing/js/landing.js') }}?v={{ filemtime(public_path('assets/landing/js/landing.js')) }}" defer></script>
</body>
</html>
