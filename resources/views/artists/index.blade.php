@extends('layouts.app')

@section('content')
    <div class="card">
        <h1 class="title">Карточки артистов</h1>
        <p class="muted">Доход пересчитывается на основе текущих треков и долей.</p>
    </div>

    <div class="grid">
        @forelse($artists as $artist)
            <div class="card">
                <h3 class="title">{{ $artist->name }}</h3>
                <div class="muted">Stage name: {{ $artist->stage_name ?? 'n/a' }}</div>
                <p>{{ $artist->bio }}</p>

                <p><strong>Треки:</strong></p>
                <ul>
                    @foreach($artist->tracks as $track)
                        <li>
                            {{ $track->title }} (доля {{ $track->pivot->share_percent }}%)
                        </li>
                    @endforeach
                </ul>

                @php
                    $total = $artist->tracks->sum(function ($track) use ($artist) {
                        $gross = $track->revenueEntries->sum('amount');
                        $share = (float)($track->pivot->share_percent ?? 0);
                        return $gross * ($share / 100);
                    });
                    $paid = $artist->payouts->where('status', 'paid')->sum('amount');
                    $accrued = $artist->payouts->sum('amount');
                    $expected = max($accrued - $paid, 0);
                @endphp
                <p><strong>Доход артиста:</strong> {{ number_format($total, 2, '.', ' ') }} RUB</p>
                <p><strong>Начислено:</strong> {{ number_format($accrued, 2, '.', ' ') }} RUB</p>
                <p><strong>Выплачено:</strong> {{ number_format($paid, 2, '.', ' ') }} RUB</p>
                <p><strong>Ожидается:</strong> {{ number_format($expected, 2, '.', ' ') }} RUB</p>
            </div>
        @empty
            <div class="card">Артисты пока отсутствуют.</div>
        @endforelse
    </div>
@endsection
