<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Division;
use App\Models\Documentation;
use App\Models\GalleryPhoto;
use App\Models\Generation;
use App\Models\Member;
use App\Models\Product;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        // 3. Dokumentasi terbaru: 6 data, eager load kategori (hindari N+1)
        $documentations = Documentation::with('category')
            ->where('is_published', true)
            ->orderByDesc('event_date')
            ->take(6)
            ->get();

        // 4. Galeri foto
        $photos = GalleryPhoto::where('is_published', true)
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        // 5. Divisi
        $divisions = Division::orderBy('sort_order')->get();

        // 6. Struktur organisasi: angkatan aktif tampil pertama
        $generations = Generation::orderByDesc('start_year')->get();
        $activeGeneration = $generations->firstWhere('is_active', true) ?? $generations->first();
        $members = $activeGeneration
            ? Member::with('division')
                ->where('generation_id', $activeGeneration->id)
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->get()
            : collect();

        // 7. Prestasi + peserta
        $achievements = Achievement::with('members')
            ->where('is_published', true)
            ->orderByDesc('event_date')
            ->take(8)
            ->get();

        // 8. Produk
        $products = Product::with('division')
            ->where('is_published', true)
            ->orderByDesc('year')
            ->take(6)
            ->get();

        // 9. Testimoni
        $testimonials = Testimonial::where('is_published', true)
            ->latest()
            ->take(10)
            ->get();

        return view('landing.index', compact(
            'documentations', 'photos', 'divisions', 'generations', 'activeGeneration',
            'members', 'achievements', 'products', 'testimonials'
        ));
    }
}
