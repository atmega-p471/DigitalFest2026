@extends('layouts.app')

@section('title', 'Треки — Label DataHub')

@section('content')
    <header class="page-header">
        <h1 class="title">Карточки треков</h1>
        <p class="muted">Полная информация по трекам, артистам и доходам.</p>
    </header>

    <section class="page-section grid-entities">
        @forelse($tracks as $track)
            @php
                $gross = $track->revenueEntries->sum('amount');
                $streams = $track->revenueEntries->sum('streams');
                $artistsShown = $track->artists->take(3);
                $artistsMore = max($track->artists->count() - 3, 0);
                $entriesShown = $track->revenueEntries->take(2);
                $entriesMore = max($track->revenueEntries->count() - 2, 0);
            @endphp
            <article class="entity-card entity-card--uniform entity-card--track">
                <div class="entity-card__head">
                    <div class="entity-card__avatar">♪</div>
                    <div class="entity-card__title-wrap">
                        <h3 class="entity-card__title" title="{{ $track->title }}">{{ $track->title }}</h3>
                        <div class="meta-row">
                            @if($track->genre)
                                <span class="tag">{{ $track->genre }}</span>
                            @endif
                            @if($track->isrc)
                                <span class="tag">{{ $track->isrc }}</span>
                            @endif
                            @if($track->release_date)
                                <span class="tag">{{ $track->release_date }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="entity-card__content">
                    <div class="entity-card__details">
                        <div class="detail-block">
                            <p class="section-label">Артисты</p>
                            @if($track->artists->isNotEmpty())
                                <ul class="detail-lines">
                                    @foreach($artistsShown as $artist)
                                        <li>{{ $artist->name }} <span class="li-meta">· {{ $artist->pivot->share_percent }}%</span></li>
                                    @endforeach
                                </ul>
                                @if($artistsMore > 0)
                                    <p class="detail-empty">ещё {{ $artistsMore }}</p>
                                @endif
                            @else
                                <p class="detail-empty">Не указаны</p>
                            @endif
                        </div>

                        <div class="detail-block">
                            <p class="section-label">Площадки</p>
                            @if($track->revenueEntries->isNotEmpty())
                                <ul class="detail-lines">
                                    @foreach($entriesShown as $entry)
                                        <li>{{ $entry->platform }} · {{ $entry->country }} <span class="li-meta">· {{ number_format($entry->amount, 0, '.', ' ') }} ₽</span></li>
                                    @endforeach
                                </ul>
                                @if($entriesMore > 0)
                                    <p class="detail-empty">ещё {{ $entriesMore }} записей</p>
                                @endif
                            @else
                                <p class="detail-empty">Нет данных</p>
                            @endif
                        </div>
                    </div>

                    <div class="entity-card__stats">
                        <div class="stats-row" style="margin: 0;">
                            <div class="stat-box">
                                <span class="label">Доход</span>
                                <span class="value">{{ number_format($gross, 0, '.', ' ') }} ₽</span>
                            </div>
                            <div class="stat-box">
                                <span class="label">Стримы</span>
                                <span class="value">{{ number_format($streams, 0, '.', ' ') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="card card-flat" style="grid-column: 1 / -1;">
                <div class="empty-state">
                    <span>♪</span>
                    Треки пока отсутствуют
                </div>
            </div>
        @endforelse
    </section>
@endsection
