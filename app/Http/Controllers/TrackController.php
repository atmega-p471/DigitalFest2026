<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\View\View;

class TrackController extends Controller
{
    public function index(): View
    {
        $tracks = Track::with(['artists', 'revenueEntries'])
            ->latest()
            ->get();

        return view('tracks.index', [
            'tracks' => $tracks,
        ]);
    }
}
