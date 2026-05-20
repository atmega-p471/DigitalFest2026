<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = Track::with(['artists', 'revenueEntries'])->latest();

        if (! $user->isAdmin()) {
            $query->whereHas('artists', function ($q) use ($user) {
                $q->where('artists.id', $user->artist_id);
            });
        }

        $tracks = $query->get();

        return view('tracks.index', [
            'tracks' => $tracks,
        ]);
    }
}
