@extends('layouts.app')

@section('title', 'Отчёты — Label DataHub')

@section('content')
    <header class="page-header">
        <h1 class="title">Отчёты</h1>
        <p class="muted">Создание отчёта за период и по выбранным трекам.</p>
    </header>

    <section class="page-section {{ auth()->user()->isAdmin() ? 'split-2-equal' : 'layout-stack' }}">
        <div class="card form-card">
            <h3 class="title">Новый отчёт</h3>
            <p class="muted card-desc">Выберите артиста, период и при необходимости треки.</p>
            <div class="form-stretch">
                <form method="POST" action="{{ route('reports.store') }}">
                    <div class="form-fields">
                        <label>Артист</label>
                        <select name="artist_id" required>
                            @foreach($artists as $artist)
                                <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                            @endforeach
                        </select>

                        <div class="field-row-2">
                            <div>
                                <label>Период с</label>
                                <input type="date" name="period_from" required>
                            </div>
                            <div>
                                <label>Период по</label>
                                <input type="date" name="period_to" required>
                            </div>
                        </div>

                        <label>Фильтр по трекам (необязательно)</label>
                        <select name="track_ids[]" multiple size="5">
                            @foreach($tracks as $track)
                                <option value="{{ $track->id }}">{{ $track->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-actions">
                        <button class="primary" type="submit">Создать отчёт</button>
                    </div>
                </form>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
            <div class="card form-card">
                <h3 class="title">Массовое обновление долей</h3>
                <p class="muted card-desc">Изменение процента доли для выбранных треков.</p>
                <div class="form-stretch">
                    <form method="POST" action="{{ route('admin.shares.update') }}">
                        <div class="form-fields">
                            <label>Выберите треки</label>
                            <select name="track_ids[]" multiple size="5" required>
                                @foreach($tracks as $track)
                                    <option value="{{ $track->id }}">{{ $track->title }}</option>
                                @endforeach
                            </select>
                            <label>Новый процент доли</label>
                            <input type="number" step="0.01" min="0" max="100" name="share_percent" required>
                        </div>
                        <div class="form-actions">
                            <button class="secondary" type="submit">Обновить доли</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </section>

    <section class="page-section layout-stack">
        <div class="card card-table">
            <h3 class="title">Последние отчёты</h3>
            <p class="data-source-note">Источник данных: Яндекс DataLens</p>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Артист</th>
                        <th>Период</th>
                        <th>Сумма</th>
                        <th>Создал</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td><span class="badge badge-muted">#{{ $report->id }}</span></td>
                            <td>{{ $report->artist?->name }}</td>
                            <td>{{ $report->period_from?->format('d.m.Y') }} — {{ $report->period_to?->format('d.m.Y') }}</td>
                            <td><strong>{{ number_format($report->total_amount, 2, '.', ' ') }}</strong> {{ $report->currency }}</td>
                            <td class="muted">{{ $report->creator?->name ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="muted" style="text-align: center; padding: 32px;">Отчёты пока не созданы</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card card-table">
            <h3 class="title">История выплат</h3>
            <p class="data-source-note">Источник данных: Яндекс DataLens</p>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr><th>Артист</th><th>Трек</th><th>Период</th><th>Сумма</th><th>Статус</th></tr>
                    </thead>
                    <tbody>
                    @forelse($payouts as $payout)
                        @php
                            $statusRu = match($payout->status) {
                                'paid' => 'Выплачено',
                                'pending' => 'Ожидает',
                                'accrued' => 'Начислено',
                                default => $payout->status,
                            };
                        @endphp
                        <tr>
                            <td>{{ $payout->artist?->name }}</td>
                            <td>{{ $payout->track?->title ?? '—' }}</td>
                            <td class="muted">{{ $payout->period_start?->format('d.m.Y') }} — {{ $payout->period_end?->format('d.m.Y') }}</td>
                            <td>{{ number_format($payout->amount, 2, '.', ' ') }} {{ $payout->currency }}</td>
                            <td><span class="badge">{{ $statusRu }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="muted" style="text-align: center; padding: 28px;">Выплаты отсутствуют</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card card-table">
            <h3 class="title">Инциденты</h3>
            <p class="data-source-note">Источник данных: Яндекс DataLens</p>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr><th>Тип</th><th>Сообщение</th><th>Отклонение</th><th>Трек</th></tr>
                    </thead>
                    <tbody>
                    @forelse($incidents as $incident)
                        <tr>
                            <td><span class="badge">{{ $incident->type }}</span></td>
                            <td>{{ Str::limit($incident->message, 60) }}</td>
                            <td>{{ $incident->deviation_percent }}%</td>
                            <td class="muted">{{ $incident->track?->title ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="muted" style="text-align: center; padding: 28px;">Инцидентов нет</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
