<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Tabel `settings` (key UNIQUE, value TEXT NULL) — sesuai dokumen perancangan.
 * Jika modelmu sudah ada, cukup salin konstanta DEFAULTS dan dua method static di bawah.
 */
class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Nilai bawaan: halaman tetap tampil rapi walau tabel settings masih kosong. */
    public const DEFAULTS = [
        'site_name' => 'Labantik',

        // Hero — dua baris judul: [kata serif] JUDUL / [kata serif]
        'hero_word_1' => 'the',
        'hero_title_1' => 'LABANTIK',
        'hero_word_2' => 'community',
        'hero_text' => 'Labantik adalah komunitas dokumentasi sekolah: fotografi, videografi, editing, podcast, dan programming. Setiap kegiatan sekolah, kegiatan Labantik, dan perlombaan kami rekam di sini.',
        'hero_image' => null,   // path di storage/public (gambar yang berpindah-pindah)
        'hero_bg' => null,   // path gambar/video latar (opsional)

        // Tentang
        'about_label' => 'Tentang Labantik',
        'about_sub' => 'Komunitas dokumentasi sekolah',
        'about_headline' => "Merekam\nsetiap momen.",
        'about_text' => 'Kami percaya dokumentasi yang baik bukan sekadar arsip. Ia menjaga cerita sekolah tetap hidup dan mudah ditemukan oleh siapa saja.',

        // Kontak & sosmed
        'contact_email' => 'hello@labantik.id',
        'instagram_url' => null,
        'youtube_url' => null,
        'tiktok_url' => null,
        'location' => null,
    ];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site_settings'));
        static::deleted(fn () => Cache::forget('site_settings'));
    }

    /** Semua setting (DB menimpa DEFAULTS), di-cache 1 jam. */
    public static function forSite(): array
    {
        return Cache::remember('site_settings', 3600, function () {
            $db = static::query()->pluck('value', 'key')->filter(fn ($v) => $v !== null && $v !== '')->all();

            return array_merge(self::DEFAULTS, $db);
        });
    }

    /**
     * Pecah email jadi potongan untuk marquee ala Figma:
     * "hello@labantik.id" → hello · at · labantik · dot · id
     * 'sans' = true untuk kata penghubung (at / dot), selainnya huruf serif miring.
     */
    public static function emailParts(string $email): array
    {
        [$local, $domain] = array_pad(explode('@', $email, 2), 2, '');
        $parts = [['text' => $local, 'sans' => false]];

        if ($domain !== '') {
            $parts[] = ['text' => 'at', 'sans' => true];
            foreach (explode('.', $domain) as $i => $label) {
                if ($i > 0) {
                    $parts[] = ['text' => 'dot', 'sans' => true];
                }
                $parts[] = ['text' => $label, 'sans' => false];
            }
        }

        return $parts;
    }
}
