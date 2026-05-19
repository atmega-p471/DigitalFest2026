@extends('layouts.app')

@section('content')
    <h1 class="title">Track cards</h1>
    <p class="muted">Full track info, artists, and accumulated revenue.</p>

    <div class="grid">
        @forelse($tracks as $track)
            <div class="card">
                <h3 class="title">{{ $track->title }}</h3>
                <div class="muted">ISRC: {{ $track->isrc ?? 'n/a' }}</div>
                <div class="muted">Release date: {{ $track->release_date ?? 'n/a' }}</div>
                <div class="muted">Genre: {{ $track->genre ?? 'n/a' }}</div>

                <p style="margin-top:10px;"><strong>Artists</strong></p>
                <ul>
                    @foreach($track->artists as $artist)
                        <li>{{ $artist->name }} - share {{ $artist->pivot->share_percent }}%</li>
                    @endforeach
                </ul>

                <p><strong>Total gross revenue:</strong>
                    {{ number_format($track->revenueEntries->sum('amount'), 2, '.', ' ') }} RUB
                </p>
                <p class="muted">{{ $track->notes }}</p>
            </div>
        @empty
            <div class="card">No tracks yet.</div>
        @endforelse
    </div>
@endsection
