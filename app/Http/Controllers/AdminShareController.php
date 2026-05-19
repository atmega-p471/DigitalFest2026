<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminShareController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'track_ids' => ['required', 'array', 'min:1'],
            'track_ids.*' => ['integer', 'exists:tracks,id'],
            'share_percent' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $tracks = Track::with('artists')->whereIn('id', $data['track_ids'])->get();

        foreach ($tracks as $track) {
            foreach ($track->artists as $artist) {
                $track->artists()->updateExistingPivot($artist->id, [
                    'share_percent' => $data['share_percent'],
                ]);
            }
        }

        return back()->with('status', 'Share percentages updated.');
    }
}
