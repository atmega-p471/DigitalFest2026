@extends('layouts.app')

@section('content')
    <div class="card">
        <h1 class="title">Карточки треков</h1>
        <p class="muted">Полная информация по трекам, артистам и доходам.</p>
    </div>

    <div class="grid">
        @forelse($tracks as $track)
            <div class="card">
                <h3 class="title">{{ $track->title }}</h3>
                <div class="muted">ISRC: {{ $track->isrc ?? 'n/a' }}</div>
                <div class="muted">Дата релиза: {{ $track->release_date ?? 'n/a' }}</div>
                <div class="muted">Жанр: {{ $track->genre ?? 'n/a' }}</div>

                <p style="margin-top:10px;"><strong>Артисты</strong></p>
                <ul>
                    @foreach($track->artists as $artist)
                        <li>{{ $artist->name }} - доля {{ $artist->pivot->share_percent }}%</li>
                    @endforeach
                </ul>

                <p><strong>Общий доход (gross):</strong> {{ number_format($track->revenueEntries->sum('amount'), 2, '.', ' ') }} RUB</p>
                <p><strong>Общее число стримов:</strong> {{ number_format($track->revenueEntries->sum('streams'), 0, '.', ' ') }}</p>

                <p><strong>По platform/country (последние записи)</strong></p>
                <ul class="muted">
                    @foreach($track->revenueEntries->take(5) as $entry)
                        <li>{{ $entry->revenue_date?->format('Y-m-d') }} - {{ $entry->platform }}/{{ $entry->country }}: {{ $entry->streams }} стримов, {{ number_format($entry->amount, 2, '.', ' ') }} RUB</li>
                    @endforeach
                </ul>
                <p class="muted">{{ $track->notes }}</p>
            </div>
        @empty
            <div class="card">Треки пока отсутствуют.</div>
        @endforelse
    </div>
@endsection
