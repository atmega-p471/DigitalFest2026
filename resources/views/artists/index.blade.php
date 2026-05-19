@extends('layouts.app')

@section('content')
    <h1 class="title">Artist cards</h1>
    <p class="muted">Income recalculates from current tracks and share percentages.</p>

    <div class="grid">
        @forelse($artists as $artist)
            <div class="card">
                <h3 class="title">{{ $artist->name }}</h3>
                <div class="muted">Stage name: {{ $artist->stage_name ?? 'n/a' }}</div>
                <p>{{ $artist->bio }}</p>

                <p><strong>Tracks:</strong></p>
                <ul>
                    @foreach($artist->tracks as $track)
                        <li>
                            {{ $track->title }} (share {{ $track->pivot->share_percent }}%)
                        </li>
                    @endforeach
                </ul>

                @php
                    $total = $artist->tracks->sum(function ($track) use ($artist) {
                        $gross = $track->revenueEntries->sum('amount');
                        $share = (float)($track->pivot->share_percent ?? 0);
                        return $gross * ($share / 100);
                    });
                @endphp
                <p><strong>Total artist income:</strong> {{ number_format($total, 2, '.', ' ') }} RUB</p>
            </div>
        @empty
            <div class="card">No artists yet.</div>
        @endforelse
    </div>
@endsection
