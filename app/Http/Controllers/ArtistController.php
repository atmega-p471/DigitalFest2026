<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\View\View;

class ArtistController extends Controller
{
    public function index(): View
    {
        $artists = Artist::with(['tracks.revenueEntries'])
            ->latest()
            ->get();

        return view('artists.index', [
            'artists' => $artists,
        ]);
    }
}
