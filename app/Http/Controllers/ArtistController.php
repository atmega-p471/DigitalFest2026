<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtistController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = Artist::with(['tracks.revenueEntries', 'payouts'])->latest();

        if (! $user->isAdmin()) {
            $query->where('id', $user->artist_id);
        }

        $artists = $query->get();

        return view('artists.index', [
            'artists' => $artists,
        ]);
    }
}
