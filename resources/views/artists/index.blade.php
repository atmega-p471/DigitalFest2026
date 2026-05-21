@extends('layouts.app')

@section('title', 'Артисты — Label DataHub')

@section('content')
    <header class="page-header">
        <h1 class="title">Карточки артистов</h1>
        <p class="muted">Доход пересчитывается на основе текущих треков и долей.</p>
    </header>

    <section class="page-section grid-entities">
        @forelse($artists as $artist)
            @php
                $total = $artist->tracks->sum(function ($track) use ($artist) {
                    $gross = $track->revenueEntries->sum('amount');
                    $share = (float)($track->pivot->share_percent ?? 0);
                    return $gross * ($share / 100);
                });
                $paid = $artist->payouts->where('status', 'paid')->sum('amount');
                $accrued = $artist->payouts->sum('amount');
                $expected = max($accrued - $paid, 0);
                $tracksShown = $artist->tracks->take(3);
                $tracksMore = max($artist->tracks->count() - 3, 0);
            @endphp
            <article class="entity-card entity-card--artist entity-card--uniform">
                <div class="entity-card__head">
                    <div class="entity-card__avatar entity-card__avatar--artist">★</div>
                    <div class="entity-card__title-wrap">
                        <h3 class="entity-card__title" title="{{ $artist->name }}">{{ $artist->name }}</h3>
                        <div class="meta-row" style="margin-bottom: 0;">
                            @if($artist->stage_name && mb_strtolower(trim($artist->stage_name)) !== mb_strtolower(trim($artist->name)))
                                <span class="tag">{{ $artist->stage_name }}</span>
                            @endif
                            <span class="tag">{{ $artist->tracks->count() }} треков</span>
                        </div>
                        @if($artist->bio && mb_strtolower(trim($artist->bio)) !== mb_strtolower(trim($artist->name)))
                            <p class="entity-card__bio">{{ $artist->bio }}</p>
                        @endif
                    </div>
                </div>

                <div class="entity-card__content">
                    <div class="entity-card__details">
                        <div class="detail-block">
                            <p class="section-label">Треки</p>
                            @if($artist->tracks->isNotEmpty())
                                <ul class="detail-lines">
                                    @foreach($tracksShown as $track)
                                        <li>{{ $track->title }} <span class="li-meta">· {{ $track->pivot->share_percent }}%</span></li>
                                    @endforeach
                                </ul>
                                @if($tracksMore > 0)
                                    <p class="detail-empty">ещё {{ $tracksMore }}</p>
                                @endif
                            @else
                                <p class="detail-empty">Нет привязанных треков</p>
                            @endif
                        </div>
                    </div>

                    <div class="entity-card__stats">
                        <div class="stats-row" style="margin: 0;">
                            <div class="stat-box">
                                <span class="label">Доход</span>
                                <span class="value">{{ number_format($total, 0, '.', ' ') }} ₽</span>
                            </div>
                            <div class="stat-box">
                                <span class="label">Ожидается</span>
                                <span class="value">{{ number_format($expected, 0, '.', ' ') }} ₽</span>
                            </div>
                        </div>
                        <p class="entity-card__substats">
                            Начислено: {{ number_format($accrued, 0, '.', ' ') }} ₽
                            · Выплачено: {{ number_format($paid, 0, '.', ' ') }} ₽
                        </p>
                    </div>
                </div>
            </article>
        @empty
            <div class="card card-flat" style="grid-column: 1 / -1;">
                <div class="empty-state">
                    <span>★</span>
                    Артисты пока отсутствуют
                </div>
            </div>
        @endforelse
    </section>
@endsection
