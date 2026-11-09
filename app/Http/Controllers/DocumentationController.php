<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Documentation;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    /** GET /dokumentasi — daftar + filter kategori + cari judul + pagination. */
    public function index(Request $request)
    {
        $documentations = Documentation::with('category')
            ->where('is_published', true)
            ->when($request->filled('kategori'), fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $request->string('kategori'))))
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
            ->orderByDesc('event_date')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('documentations.index', compact('documentations', 'categories'));
    }

    /** GET /dokumentasi/{slug} */
    public function show(string $slug)
    {
        $doc = Documentation::with('category')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $related = Documentation::with('category')
            ->where('is_published', true)
            ->where('id', '!=', $doc->id)
            ->where('category_id', $doc->category_id)
            ->orderByDesc('event_date')
            ->take(3)
            ->get();

        return view('documentations.show', compact('doc', 'related'));
    }

    /** GET /dokumentasi/{slug}/unduh — hitung unduhan lalu arahkan ke download_url. */
    public function download(string $slug)
    {
        $doc = Documentation::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $doc->increment('download_count');

        return redirect()->away($doc->download_url ?: $doc->view_url);
    }
}
