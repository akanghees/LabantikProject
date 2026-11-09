<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Documentation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_and_documentation_pages_render(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('LABANTIK')
            ->assertSee('community')
            ->assertDontSee('MEDIA')
            ->assertSee('Dokumentasi Terbaru')
            ->assertSee('Tentang Labantik');

        $this->get('/dokumentasi')
            ->assertOk()
            ->assertSee('Semua Dokumentasi');
    }

    public function test_download_counts_then_redirects_to_the_download_url(): void
    {
        $category = Category::create([
            'name' => 'Kegiatan',
            'slug' => 'kegiatan',
        ]);
        $documentation = Documentation::create([
            'category_id' => $category->id,
            'title' => 'Dokumentasi Kegiatan',
            'slug' => 'dokumentasi-kegiatan',
            'thumbnail' => 'thumb.jpg',
            'media_type' => 'image',
            'view_url' => 'https://example.com/view',
            'download_url' => 'https://example.com/download',
            'event_date' => '2026-10-12',
        ]);

        $this->get(route('dokumentasi.show', $documentation->slug))
            ->assertOk()
            ->assertSee('Oktober');

        $this->get(route('dokumentasi.unduh', $documentation->slug))
            ->assertRedirect('https://example.com/download');

        $this->assertDatabaseHas('documentations', [
            'id' => $documentation->id,
            'download_count' => 1,
        ]);
    }
}
