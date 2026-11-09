<?php

namespace App\Http\Controllers;

use App\Models\Generation;
use App\Models\Member;

class MemberController extends Controller
{
    /** GET /struktur/{generation} — potongan HTML kartu anggota untuk carousel (AJAX). */
    public function byGeneration(Generation $generation)
    {
        $members = Member::with('division')
            ->where('generation_id', $generation->id)
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        return view('landing.partials.member-cards', compact('members'));
    }
}
